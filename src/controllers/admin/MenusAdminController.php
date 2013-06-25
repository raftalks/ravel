<?php


class MenusAdminController extends AdminController
{
	protected $title = 'Menus';

	protected $moduleName = 'Menus';

	public function getIndex()
	{
		
		$data = array();

		$this->layout->nest('content','ravel::admin.menus.home',$data);

	}
}