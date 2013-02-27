<?php

class UsersApiController extends ResourceApiBase
{

	protected $moduleName = 'settings';


	protected function setupResources()
	{
		$this->resource = app('UsersLibrary');
	}

	
}