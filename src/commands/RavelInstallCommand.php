<?php namespace Raftalks\Ravel;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RavelInstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ravel:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Install Ravel including migrations';

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
		$app = $this->getLaravel();
		$env = $app->environment();
	

		if($this->checkifWorkBench())
		{
			$this->call('migrate',array('--bench'=>'raftalks/ravel'));
		}
		else
		{	
			$this->call('migrate',array('--package'=>'raftalks/ravel'));
		}

		$this->call('db:seed',array('--class'=>'RavelDatabaseSeeder'));

		//$this->call('migrate',array('--path'=>$path));

		//$this->info('Successfully Syncronised Roles for Modules');
	}


	public function checkifWorkBench()
	{
		$path = __FILE__;
		return str_contains(strtolower($path),'/workbench/raftalks/ravel/');
	}

	

	

}