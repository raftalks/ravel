<?php 

class Usermodel extends User {

	
	protected $fillableFields = array('email', 'password', 'username', 'usergroup_id');

	protected $softDelete = true;
	
	protected $validation_rules = array(

			'username' 		=> 'required',
			'email'			=> 'required',
			'usergroup_id'	=> 'required',
			'password'		=> 'required|confirmed',

		);

	protected $baseModel = null;
	
	public function __construct()
	{
		$this->fillable = array_merge($this->fillable, $this->fillableFields);
		
	}

		
	public function usergroup()
	{
		return $this->belongsTo('Usergroup','usergroup_id');
	}


	public function setPasswordAttribute($password)
    {
    	
    	$this->attributes['password'] = Hash::make($password);
    }


    //bind service model mthods
    public function __call($method, $args)
	{
		$instance = $this->fetchBaseModel();
	    return call_user_func_array(array($instance, $method), $args);
	}


	protected function fetchBaseModel()
	{
		if(is_null($this->baseModel))
		{
			$this->baseModel = new Userobj;
			$this->baseModel->setTableName($this->table);
			$this->baseModel->setValidationRules($this->validation_rules);
		}

		return $this->baseModel;
	}


	public function isValid($attributes = null)
	{
		if(empty($this->validation_rules))
		{
			return true;
		}

		if(is_null($attributes))
		{
			$attributes = $this->attributes;
		}

		return $this->fetchBaseModel()->isValid($attributes);

	}



	public function validationErrors()
	{
		return $this->fetchBaseModel()->validationErrors();
	}


}