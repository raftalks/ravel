<?php

class RavelAdminUserSeeder extends Seeder
{


	public function run()
	{

		$adminUser = Config::get('ravel::app.setup_user');

		$adminGroup = Usergroup::orderBy('id','asc')->first();

		$adminUser['usergroup_id'] = (int) $adminGroup->id;


		DB::table('users')->delete();
		
		$user = new Usermodel;
		$user->fill($adminUser);
		$user->activated = true;
		$user->api_token = makeApiKey();
		$user->save();
		
	}
}