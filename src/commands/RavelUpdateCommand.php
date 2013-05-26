<?php namespace Raftalks\Ravel;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Raftalks\Ravel\ComposerCommand;

class RavelUpdateCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ravel:update';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Update Ravel including migrations';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{

		// $app = $this->getLaravel();
		// $env = $app->environment();
	

		if($this->checkifWorkBench())
		{
			$this->call('asset:publish',array('--bench'=>'raftalks/ravel'));
			$this->call('migrate',array('--bench'=>'raftalks/ravel'));
		}
		else
		{	
			$this->runComposerPackageUpdate();
			$this->call('asset:publish',array('package'=>'raftalks/ravel'));
			$this->call('migrate',array('--package'=>'raftalks/ravel'));
		}

	
		$this->info('Successfully updated Ravel');
	}


	public function checkifWorkBench()
	{
		$path = __FILE__;
		return str_contains(strtolower($path),'/workbench/raftalks/ravel/');
	}


	public function runComposerPackageUpdate()
	{
		$path = app_path();
		$cmd = new ComposerCommand('raftalks/ravel',$path);
		$cmd->runPackageUpdate();
	}

}