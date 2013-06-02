<?php 

class EloquentBaseModel extends Eloquent
{

    /**
     * Validation rules for the model
     *
     * @var array
     *
     * @access protected
     */	
	protected $validation_rules = array();

	protected $validation_messages = array();

	protected $validation_error_messages = array();

	protected $valdation_error_template = ":message";

	protected $validation_object = false;


	public function setTableName($name)
	{
		$this->table = $name;
	}

	public function setValidationRules($rules)
	{
		$this->validation_rules = $rules;
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

		// generate the validator and return its success status
		$this->validation_object = \Validator::make(
													$attributes, 
													$this->validation_rules, 
													$this->validation_messages);

		if($this->validation_object->fails())
		{
			
			$this->validation_error_messages = $this->validation_object->messages();
			return false;
		}

		return true;
	}

	public function validationErrors()
	{
		return $this->validation_error_messages->all($this->valdation_error_template);
	}

	public function errorMessageBag()
	{
		return $this->validation_error_messages;
	}

	

}