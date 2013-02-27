<?php

class PostsAdminController extends AdminController
{

	protected $title = 'Posts';

	public function getIndex()
	{

		$data = array();
		
		$this->layout->nest('content','ravel::admin.content.posts.home',$data);

	}

}