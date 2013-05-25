<?php

class PostsCategoriesAdminController extends AdminController
{
	protected $title = 'Post Categories';

	protected $moduleName = 'contents';



	public function getIndex()
	{
		$layouts = Config::get('ravel::app.layouts');
		$Listlayouts = array_combine($layouts['list'],$layouts['list']);

		$ItemLayouts = array_combine($layouts['item'],$layouts['item']);
		
		$data = array(
			'ravel_list_layouts' => $Listlayouts,
			'ravel_item_layouts' => $ItemLayouts,
			);
	
		$this->layout->nest('content','ravel::admin.content.categories.home',$data);

	}

}