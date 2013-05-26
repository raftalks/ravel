<?php

class PostsApiController extends ContentApi
{
	protected $moduleName = 'contents';

	public $contentType = 'post';


	public function __construct()
	{
		parent::__construct();
	}


}