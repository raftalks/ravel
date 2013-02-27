<?php

class PagesApiController extends ContentApi
{
	protected $moduleName = 'Contents';

	public $contentType = 'page';


	public function __construct()
	{
		parent::__construct();
	}

}