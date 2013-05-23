<?php 

class Module extends EloquentBaseModel
{

	protected 		$table 			='modules';
	protected	 	$fillable 		= array('module');


	public function roles()
	{
		return $this->hasMany('role');
	}

}