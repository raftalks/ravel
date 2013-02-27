<?php namespace Raftalks\Ravel;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RavelCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ravel';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Ravel CMS commands.';

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
		$respond = \Config::get('ravel::roles.modules');
		$this->info($respond[0]);
	}

	
	

}