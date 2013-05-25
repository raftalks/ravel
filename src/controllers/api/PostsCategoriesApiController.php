<?php

class PostsCategoriesApiController extends ResourceApiBase
{
	protected $moduleName = 'contents';

	protected function setupResources()
	{
		$this->resource = app('PostCategory');
	}

}