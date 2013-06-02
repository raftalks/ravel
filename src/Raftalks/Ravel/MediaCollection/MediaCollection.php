<?php namespace Raftalks\Ravel\MediaCollection;

use Raftalks\Ravel\ServiceModel;


class MediaCollection extends ServiceModel
{

	protected $resource_with = array('items');

	protected function setup()
	{
		$this->model = app('Mcollection');
	}


	public function fetch($page = 1, $take=10, $callback=null)
	{

		if(is_null($callback))
		{
			$callback = function(&$model,$host)
			{
				$model = $model->mycollections();

			};
						
		}

		return parent::fetch($page, $take, $callback);
		

	}

}