<?php namespace Raftalks\Ravel;

// use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class ComposerCommand {
	
	/**
	 * Package to be updated.
	 *
	 * @var string
	 */
	protected $package;

	/**
	 * The working path to regenerate from.
	 *
	 * @var string
	 */
	protected $workingPath;

	/**
	 * Create a new Composer manager instance.
	 *
	 * @param  \Illuminate\Filesystem\Filesystem  $files
	 * @param  string  $workingPath
	 * @return void
	 */
	public function __construct($package,$workingPath = null)
	{
		$this->package = $package;
		$this->workingPath = $workingPath;
	}


	public function getPackage()
	{
		return $this->package;
	}

	/**
	 * Regenerate the Composer autoloader files.
	 *
	 * @param  string  $extra
	 * @return void
	 */
	public function runPackageUpdate()
	{
		$process = $this->getProcess();

		$process->setCommandLine(trim($this->findComposer().' update '. $this->getPackage()));

		$process->run();
	}

	/**
	 * Regenerate the optimized Composer autoloader files.
	 *
	 * @return void
	 */
	public function dumpOptimized()
	{
		$this->dumpAutoloads('--optimize');
	}

	/**
	 * Get the composer command for the environment.
	 *
	 * @return string
	 */
	protected function findComposer()
	{
		// if ($this->files->exists($this->workingPath.'/composer.phar'))
		// {
			return 'php composer.phar';
		// }
		
		// return 'composer';
	}

	/**
	 * Get a new Symfony process instance.
	 *
	 * @return \Symfony\Component\Process\Process
	 */
	protected function getProcess()
	{
		return new Process('', $this->workingPath);
	}

	// *
	//  * Set the working path used by the class.
	//  *
	//  * @param  string  $path
	//  * @return \Raftalks\Ravel\Composer
	public function setWorkingPath($path)
	{
		$this->workingPath = realpath($path);

		return $this;
	}

}
