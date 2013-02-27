<?php

class RavelDatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call('RavelInitSeeder');
		$this->call('RavelAdminUserSeeder');
	}

}