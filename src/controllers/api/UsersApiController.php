<?php

class UsersApiController extends ResourceApiBase
{

	protected $moduleName = 'Settings';


	protected function setupResources()
	{
		$this->resource = app('UsersLibrary');
	}

	
}