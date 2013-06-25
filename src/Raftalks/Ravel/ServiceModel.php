<?php namespace Raftalks\Ravel;
use Closure;
use Event;
use Config;
use Exception;

abstract class ServiceModel
{

	/**
     * Content Model
     *
     * @var Object
     *
     * @access protected
     */
	protected $model;


	/**
     * Acl Class Instance
     *
     * @var object
     *
     * @access private
     */
	private $acl;

	protected $authenticate_full = true;

	protected $error_messages = array();

	protected $response_status = 200;

	protected $resource_with = null;


	public function __construct()
	{
		$this->acl = app('AccessControl');
		$this->setup();
	}


	protected function setup()
	{
		throw new Exception("Error Providing Service Model Setup method. Service Model must have setup method defined.", 1);
	}


	public function model()
	{
		return $this->model;
	}


	public function acl()
	{
		return $this->acl;
	}

	public function getLocale()
	{
		return Config::get('app.locale');
	}


	public function setModule($module)
	{
		$this->acl->setModule($module);
	}



	protected function addErrorMessage($message, $status=200, $key = 'errors')
	{	
		$this->error_messages = $message;
		$this->response_status = $status;
	}


	public function getErrors()
	{
		$errors = $this->error_messages;
		if(is_array($errors) && !empty($errors))
		{
			return implode(', ', array_values($errors));
		}
		return $errors;
	}

	public function getResponseStatus()
	{
		return $this->response_status;
	}


	protected function verify($action)
	{
		$method = strtolower('can_' . $action);

		if($this->acl()->$method())
		{
			return true;
		}
		$this->addErrorMessage(ucfirst($action) .' '. trans('ravel::error.action_restricted'),403);
		return false;
	}


	public function is_moderator()
	{
		//return true;
		return $this->acl()->is_moderator();
	}

	public function is_guest()
	{
		return $this->acl()->is_guest();
	}

	/**
     * Check if the user is authenticated
     * 
     * @access protected
     *
     * @return mixed Value.
     */
	public function is_user()
	{
		return $this->acl()->check();
	}


	public function getAuthor()
	{
		return $this->acl()->getUser();
	}

	public function getAuthorId()
	{
		$author = $this->getAuthor();
		return $author->id;
	}

	public function getAuthorName()
	{
		$author = $this->getAuthor();
		return $author->username;
	}


	public function fetchAll($callback=null)
	{
		return $this->fetch(0,0,$callback);
	}


	public function getTotalRows($callback = null)
	{
		$model = $this->model()->newInstance();
		if(is_callable($callback))
		{
			$this->doRunClosure($callback, $model);
		}

		$total = $model->count();
		return $total;
	}


	public function fetch($page = 1, $take=10, $callback=null)
	{
		if($this->authenticate_full)
		{
			if($this->verify('read') == false)
			{
				return false;
			}
		}

		$model = $this->model();
		
		$skip = ((int)$page - 1) * (int)$take;

		if(is_callable($callback))
		{
			$this->doRunClosure($callback, $model);
		}

		if(is_array($this->resource_with))
		{
			$model = $model->with($this->resource_with);
		}

		$model = $this->beforeFetch($model);

		if($page == 0 && $take == 0)
		{
			$result = $model->get();
		}
		else
		{
			$result = $model->skip($skip)->take($take)->get();
		}
		

		if($result->count())
		{
			$result = $this->afterFetch($result);
			return $result;
		}
		else
		{
			$this->addErrorMessage(trans('ravel::error.no_content_found'),404);
			return false;
		}

	}

	protected function doRunClosure(closure $callback, &$model)
	{
		$host = $this;
		if(is_closure($callback))
		{
			$callback($model, $host);
		}
		
	}

	protected function beforeFetch($model)
	{
		return $model;
	}

	protected function afterFetch($result)
	{
		return $result;
	}


	public function get($callback = null, $page=1, $take =10)
	{
		return $this->fetch($page, $take, $callback);
	}

	

	public function show($id, $callback = null)
	{

		$model = $this->model()->newInstance();

		//$model = $this->model();

		if(!is_null($callback) && is_closure($callback))
		{
			$this->doRunClosure($callback, $model);
		}
		

		$result = $model->find($id);
		if(is_null($result))
		{
			$this->addErrorMessage('Not Found',404);
			return false;
		}

		return $result;

	}



	public function edit($id, $callback = null)
	{
		if($this->is_user())
		{
			return $this->show($id, $callback);
		}
	}



	public function insert($data, $callback=null)
	{
		if($data == false || empty($data))
		{
			$this->addErrorMessage('Empty Item Submitted',404);
			return false;
		}

		if($this->verify('create'))
		{
				$model = $this->model()->newInstance();
				
				if(is_object($data))
				{
					$data = (array)$data;
				}
				
				$model->fill($data);

				if(is_callable($callback))
				{
					$this->doRunClosure($callback, $model);
				}

				if($model->isValid($data))
				{
					if($model->save())
					{
						$this->afterInsert($model, $data);
						return $model;
					}
				}
				else
				{
					//validation failed
					$errors = $model->validationErrors();
					$this->addErrorMessage($errors,400);		
				}
		}

		return false;

	}



	protected function afterInsert($model, $data)
	{
		return true;
	}



	public function save($data, $id, $callback = null)
	{

		if($this->verify('update'))
		{
			
			$model = $this->model()->find($id);

			if(is_object($data))
			{
				$data = (array)$data;
			}
				
			$model->fill($data);

			if(is_callable($callback))
			{
				$this->doRunClosure($callback, $model);
			}

			if($model->isValid())
			{
				if($model->save())
				{
					$this->afterSave($model, $data);
					return $model;
				}
			}
			else
			{
				//validation failed
				$errors = $model->validationErrors();
				$this->addErrorMessage($errors,400);		
			}
			
		}

		return false;

	}

	protected function afterSave($model, $data)
	{
		return true;
	}



	public function delete($id)
	{
		if($this->verify('delete'))
		{
			$model = $this->model()->find($id);
			if($model->delete())
			{
				return true;
			}
			else
			{
				$this->addErrorMessage('Something went wrong, unable to delete',500);
			}
		}

		return false;

	}
}