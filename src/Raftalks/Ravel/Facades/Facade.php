<?php namespace Raftalks\Ravel\Facades;

Class Facade
{

	protected static $resolvedInstance;
	
	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		throw new \RuntimeException("Facade does not implement getFacadeAccessor method.");
	}


	/**
	 * Resolve the facade root instance from the container.
	 *
	 * @param  string  $name
	 * @return mixed
	 */
	protected static function resolveFacadeInstance($name)
	{
		if (is_object($name)) return $name;

		if (isset(static::$resolvedInstance[$name]))
		{
			return static::$resolvedInstance[$name];
		}

		$NP = ucfirst($name);
		$classInstance = "Raftalks\\Ravel\\$NP\\$NP";
		return static::$resolvedInstance[$name] = new $classInstance;
	}


	public static function resolveMethod($method, $args)
	{
		$instance = static::resolveFacadeInstance(static::getFacadeAccessor());
		return call_user_func_array(array($instance, $method), $args);
	}
	


	public static function __callStatic($method, $args)
	{
		return static::resolveMethod($method, $args);
	}

	public function __call($method, $args)
	{
		return static::resolveMethod($method, $args);
	}


	

}