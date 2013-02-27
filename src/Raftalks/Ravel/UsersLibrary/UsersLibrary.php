<?php namespace Raftalks\Ravel\UsersLibrary;

use Raftalks\Ravel\ServiceModel;
use Event;

class UsersLibrary extends ServiceModel
{	

	protected function setup()
	{
		$this->model = app('Usermodel');
		$this->resource_with = array('usergroup');
		
	}


	public function insert($data, $callback=null)
	{
		if(is_null($callback))
		{
			$callback = function($user)
			{
				$user->api_token = makeApiKey();
				return $user;
			};
		}

		return parent::insert($data, $callback);
	}


}