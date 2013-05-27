<?php

class PagesAdminController extends AdminController
{

	protected $title = 'Pages';

	protected $moduleName = 'Contents';

	public function getIndex()
	{

		$posts = Post::get();
		
		if(!$posts)
		{
			$posts = app('EmptyCollection');
		}

		$data['data'] = $posts->toArray();

		$this->layout->nest('content','ravel::admin.content.pages.home',$data);

	}

}