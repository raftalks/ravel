<?php

abstract class ResourceApiBase extends RavelBaseController
{
	protected $moduleName = 'Global';

	protected $resource = null;

	public function __construct()
	{
		$this->setupResources();
		$this->resource->setModule($this->moduleName);
	}


	protected function setupResources()
	{
		throw new Exception("Error Setting up Resource", 1);
		
	}

	/**
	 * GET List Resources
	 */
	public function index()
	{

		$pageNum = Request::query('page');
		$page = is_null($pageNum) ? 1 : (int)$pageNum;
		$data = $this->resource->fetch($page);
		$totalRows = $this->resource->getTotalRows();
		$extras = array('totalrows'=> (int)$totalRows);

		return $this->responseMessage($data,'successful',200, $extras);
	}



	/**
	 * GET by ID resource 
	 */
	public function show($id)
	{
		$data = $this->resource->show($id);
		return $this->responseMessage($data);
	}




	/**
	 * POST Create new Resource
	 */
	public function store()
	{
		$data = Input::get();

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




	/**
	 * PUT Update Resource
	 */
	public function update($id)
	{
		$data = Input::get();
		$respond = $this->resource->save($data, $id);

		//if respond returns boolean false
		if(is_bool($respond) === true)
		{
			$errors = $this->resource->getErrors();
			$status = $this->resource->getResponseStatus();
			return $this->errorResponse($errors, $status);
		}

		return $this->responseMessage($respond);
	}



	/**
	 * DELETE Resource
	 */
	public function destroy($id)
	{
		
		if($this->resource->delete($id))
		{
			$response = null;
		} else
		{
			$response = false;
		}
		return $this->responseMessage($response);
	}


	protected function errorResponse($errors, $status = 400)
	{
		App::abort($status, $errors);
	}



	protected function responseMessage($data, $message = 'request successful', $status = 200, $extras = array())
	{

		if(is_bool($data) === true && ($data === false))
		{
			$errors = $this->resource->getErrors();
			$status = $this->resource->getResponseStatus();
			return $this->errorResponse($errors, $status);
		}

		if(is_object($data))
		{
			$ResponseData = $data->toArray();
		}
		else
		{
			$ResponseData = $data;
		}

		$obj = json_encode($ResponseData, JSON_NUMERIC_CHECK);
		$ResponseData = json_decode($obj, true);
		
		$output = array(
				'error' => false,
				'message'	=> $message,
				'data'	=> $ResponseData
				);

		$output = array_merge($output, $extras);


		return Response::json($output, $status);
	}
}