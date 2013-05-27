<?php 

class Usergroup extends EloquentBaseModel
{

	protected 		$table 			='usergroups';
	protected	 	$fillable 		= array('group');


	public function roles()
	{
		return $this->hasMany('Role');
	}



	//Custom helper methods

	//get select options
	function getSelectList()
	{
		$usergroups = $this->get(array('id','group'));
		$data = array();
		foreach($usergroups as $group)
		{
			$data[$group->id] = $group->group;
		}

		return $data;
	}

	function getUserGroupByName($name)
	{
		$usergroup = $this->where('group','=',$name)->first();
		return $usergroup;
	}


}