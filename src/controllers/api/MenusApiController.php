<?php

class MenusApiController extends ResourceApiBase
{
	protected $moduleName = 'Menus';

	protected function setupResources()
	{
		$this->resource = new Menu;
	}


		
}