<?php namespace Raftalks\Ravel\Post;

use Raftalks\Ravel\Content\Content;

class Post extends Content
{

	protected $contentType = 'post';

	protected $useContentCategories = true;
	

	public function ContentModel()
	{
		return app('ContentModel');
	}
}