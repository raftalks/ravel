<?php

class ContentApi extends ResourceApiBase
{

	protected $moduleName = 'Contents';

	public $contentType = 'page';

	protected $resource = null;


	protected function setupResources()
	{
		$resourceClass = ucfirst($this->contentType);
		$this->resource = new $resourceClass;
	}

	
}