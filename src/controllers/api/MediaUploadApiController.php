<?php

class MediaUploadApiController extends ResourceApiBase
{
	protected $moduleName = 'Medias';

	protected function setupResources()
	{
		$this->resource = app('Media');
	}


	/**
	 * POST Create new Resource
	 */
	public function store()
	{
		$data = Input::all();
		
		$respond = $this->resource->insert($data);

		//if respond returns boolean false
		if(is_bool($respond) === true)
		{
			$errors = $this->resource->getErrors();
			$status = $this->resource->getResponseStatus();
			return $this->errorResponse($errors, $status);
		}

		if(is_bool($respond) === true && ($respond === false))
		{
			$errors = $this->resource->getErrors();
			$status = $this->resource->getResponseStatus();
			return $this->errorResponse($errors, 400);
		} else
		{
			return Response::json('success', 200);
		}
	}
	
}