<?php namespace Raftalks\Ravel\Page;

use Raftalks\Ravel\Content\Content;

class Page extends Content
{

	protected $contentType = 'page';
	
	protected $useContentCategories = false;

	public function ContentModel()
	{
		return app('ContentModel');
	}
}