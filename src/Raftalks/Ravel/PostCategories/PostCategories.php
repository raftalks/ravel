<?php namespace Raftalks\Ravel\PostCategories;

use Raftalks\Ravel\ServiceModel;
use Event;

class PostCategories extends ServiceModel
{	

	protected function setup()
	{
		$this->model = app('CategoryModel');
		
	}

}