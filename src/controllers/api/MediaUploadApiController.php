<?php

class MediaUploadApiController extends ResourceApiBase
{
	protected $moduleName = 'Medias';

	protected function setupResources()
	{
		$resourceClass = new Media;
		$this->resource = new $resourceClass;
	}


	/**
	 * POST Create new Resource
	 */
	public function store()
	{
		$data = Input::get();

		return Response::json('success', 200);

		$respond = $this->resource->insert($data);

		//if respond returns boolean false
		if(is_bool($respond) === true)
		{
			$errors = $this->resource->getErrors();
			$status = $this->resource->getResponseStatus();
			return $this->errorResponse($errors, $status);
		}

		return $this->responseMessage($respond);
	}
	
}