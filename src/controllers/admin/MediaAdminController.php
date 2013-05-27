<?php

class MediaAdminController extends AdminController
{

	protected $title = 'Medias';

	protected $moduleName = 'Medias';

	public function getIndex()
	{
		
		$data = array();

		$this->layout->nest('content','ravel::admin.media.home',$data);

	}

}