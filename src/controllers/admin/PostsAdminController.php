<?php

class PostsAdminController extends AdminController
{

	protected $title = 'Posts';

	protected $moduleName = 'Contents';
	

	public function getIndex()
	{
		$locale = config::get('app.locale');
		$categories = CategoryModel::where('lang','=',$locale)->get();

		$data = array();
		
		$cats = array();
		
		foreach($categories as $category)
		{
			$indx = $category->id;
			$cats[] = array(
							'id' => (int)$category->id,
							'name' =>$category->name
						);
		}

		$data['post_categories'] = $cats;

		$this->layout->nest('content','ravel::admin.content.posts.home',$data);

	}

}