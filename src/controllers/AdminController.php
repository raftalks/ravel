<?php

class AdminController extends AppController
{
	protected $title = '';

	protected $moduleName = 'AdminGlobal';

	protected $layout = 'ravel::layouts.admin.default';


	public function __construct()
	{

		$this->beforeFilter('ravelauth');

		$ACL = $this->Acl = App::make('AccessControl');
		
		$ACL->setModule($this->moduleName);
		
		
	}

	//overide baseController method to include title in the layout
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);

			$this->layout->title = $this->title;
		}
	}
}