<?php namespace Raftalks\Ravel;

use Illuminate\Support\ServiceProvider;

class RavelServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;


	protected $PkgAppConfig = array();

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app->register('Intervention\Image\ImageServiceProvider');
		$this->package('raftalks/ravel');

		$this->registerCommands();

		$auth = $this->app['auth'];
		$rolesConfig = $this->getAppConfig('roles');
		$this->app['acl'] = new Acl\Acl($auth, $rolesConfig);
		$this->app['acl']->setModuleModel(); 
		$this->app['acl']->setUsergroupModel(); 
		$this->app['acl']->setRoleModel(); 

		$this->loadFilesRequired();

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		if(ini_get('xdebug.max_nesting_level'))
		{
			ini_set('xdebug.max_nesting_level', 250);
		}
		

		$this->defineConstants();
		$path = $this->guessPackagePath();

		\Config::set('auth.model', 'Usermodel');

		$this->loadExceptionHandlers();

		$this->loadAliases();

		$this->loadRavelEventHandler();

		$this->loadRoutes();
	}


	public function getAppConfig($file = 'app')
	{
		if(!isset($this->PkgAppConfig[$file]))
		{
			$path = $this->guessPackagePath();
			$ConfigFile = $path . '/config/'.$file.'.php';
			$this->PkgAppConfig[$file] = $this->app['files']->getRequire($ConfigFile);
		}
		
		return $this->PkgAppConfig[$file];
	}


	public function defineConstants()
	{
		$appConfig = $this->getAppConfig();
		define('_ADMIN_BASE_', $appConfig['admin_base_uri']);
		define('_API_BASE_', $appConfig['api_base_uri']);
		define('_FRONT_BASE_', $appConfig['frontend_base_uri']);
	}



    /**
     * Load All Routes
     * 
     * @access public
     *
     * @return void
     */
	public function loadRoutes()
	{
		$path = $this->guessPackagePath();

		$routes = $path.'/routes';
		if ($this->app['files']->isDirectory($routes))
		{
			$files = $this->app['files']->files($routes);
			if(!empty($files))
			{
				foreach($files as $file)
				{
					require_once $file;
				}
			}
		}
	}


	protected function loadFilesRequired()
	{
		$path = $this->guessPackagePath();
		$appConfig = $this->getAppConfig();
		foreach($appConfig['required_files'] as $file)
		{
			$filepath = $path .'/'. $file;
			if($this->app['files']->exists($filepath))
			{
				$this->app['files']->requireOnce($filepath);
			}
			else
			{
				throw new \Exception('Ravel App Required file not found : '.$filepath);
			}
			
		}
	}


	protected function loadExceptionHandlers()
	{
		$path = $this->guessPackagePath();
		$handlerPath = $path . '/Raftalks/Ravel/ExceptionHandlers/Exceptions';

		if ($this->app['files']->isDirectory($handlerPath))
		{

			$files = $this->app['files']->files($handlerPath);
			if(!empty($files))
			{
				foreach($files as $file)
				{

					require_once $file;
				}
			}
		}

		$handlerPath = $path . '/Raftalks/Ravel/ExceptionHandlers/ErrorHandlers.php';
		
		if($this->app['files']->exists($handlerPath))
		{
			require_once $handlerPath;
		}
		
	}


	public function loadRavelEventHandler()
	{
		$path = $this->guessPackagePath();
		$handlerPath = $path . '/Raftalks/Ravel/Events.php';

		if($this->app['files']->exists($handlerPath))
		{
			require_once $handlerPath;
		}
	}


	/**
	* register class aliases
	* 
	* @return  void
	*/
	public function loadAliases()
	{
		$appConfig = $this->getAppConfig();
		
		$aliases = $appConfig['aliases'];

		foreach($aliases as $alias => $class)
		{
			class_alias($class, $alias);
		}
	}

	/** register the custom commands **/
	public function registerCommands()
	{
		$commands = array('Ravel','RavelRoles','RavelInstall','RavelUpdate');

		foreach ($commands as $command)
		{
			$this->{'register'.$command.'Command'}();
		}

		$this->commands(
			'command.ravel','command.ravel.sync_roles','command.ravel.install','command.ravel.update'
		);

	}


	public function registerRavelCommand()
	{
		$this->app['command.ravel'] = $this->app->share(function($app)
		{
			return new RavelCommand();
		});
	}


	public function registerRavelRolesCommand()
	{
		$this->app['command.ravel.sync_roles'] = $this->app->share(function($app)
		{
			return new RavelRolesCommand();
		});
	}


	public function registerRavelInstallCommand()
	{
		$this->app['command.ravel.install'] = $this->app->share(function($app)
		{
			return new RavelInstallCommand();
		});
	}

	public function registerRavelUpdateCommand()
	{
		$this->app['command.ravel.update'] = $this->app->share(function($app)
		{
			return new RavelUpdateCommand();
		});
	}



	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}