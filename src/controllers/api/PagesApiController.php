<?php

class PagesApiController extends ContentApi
{
	protected $moduleName = 'contents';

	public $contentType = 'page';


	public function __construct()
	{
		parent::__construct();
	}

}