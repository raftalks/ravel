<?php namespace Raftalks\Ravel;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RavelRolesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ravel:sync_roles';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Work with Ravel Roles and Usergroups.';

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
		
		$Acl = \App::make('AccessControl');
		
		$Acl->syncModules();

		$this->info('Successfully Syncronised Roles for Modules');
	}

	

	

}