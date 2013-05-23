<?php 

class Role extends EloquentBaseModel
{

	protected 		$table 			='roles';
	protected	 	$fillable 		= array('usergroup_id','module_id','permissions');

	public function usergroup()
	{
		return $this->belongsTo('Usergroup');
	}

	public function module()
	{
		return $this->belongsTo('Module');
	}

	

    
}