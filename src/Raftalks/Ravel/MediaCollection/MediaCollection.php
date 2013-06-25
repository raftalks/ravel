<?php namespace Raftalks\Ravel\MediaCollection;

use Raftalks\Ravel\ServiceModel;


class MediaCollection extends ServiceModel
{

	protected $resource_with = array('items');

	protected function setup()
	{
		$this->model = app('Mcollection');
	}



	public function show($id, $callback = null)
	{
		if(is_null($callback))
		{
			$callback = function(&$model, $host)
			{
				$model = $model->with('items');
			};
		}

		$list = parent::show($id, $callback);
		$host = $this;
		$list->items->each(function($item) use($host)
		{
			$host->setCollectionItemLinks($item);
		});

		return $list;
	}


	public function setCollectionItemLinks(&$item)
	{
		$url = url($item->url);
		$filename = $item->file_name;
		$medium_path = '/medium/';
		$thumb_path = '/thumbs/';
		$thumb_prefix = 'thumb_';
		$item->thumb_url = $url . $thumb_path . $thumb_prefix . $filename;
		$item->medium_url = $url . $medium_path . $filename;
		$item->src_url = $url . '/' . $filename;
	}




	public function fetch($page = 1, $take=10, $callback=null)
	{

		if(is_null($callback))
		{
			$callback = function(&$model,$host)
			{
				$model = $model->with('items')->mycollections();

			};
						
		}

		$list = parent::fetch($page, $take, $callback);
		$host = $this;
		$list->each(function($collection) use($host)
		{
			$collection->items->each(function($item) use($host)
			{
				$host->setCollectionItemLinks($item);
			});
			
		});

		return $list;
		
	}

}