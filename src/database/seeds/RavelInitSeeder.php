<?php

class RavelInitSeeder extends Seeder
{


	public function run()
	{

		$Acl = App::make('AccessControl');
		
		$Acl->syncModules();
	}
}