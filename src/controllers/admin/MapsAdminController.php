<?php

class MapsAdminController extends AdminController
{
	protected $title = "Maps";

	protected $moduleName = 'Maps';
	
	public function getIndex()
	{

		$data = array();
		$this->layout->nest('content','ravel::admin.maps.home',$data);
	}
}