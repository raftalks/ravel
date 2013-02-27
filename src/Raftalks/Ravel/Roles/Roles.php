<?php namespace Raftalks\Ravel\Roles;

use Raftalks\Ravel\ServiceModel;
use Config;

class Roles extends ServiceModel
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

	

	public function __construct()
	{
		$this->setup();
	}


	protected function setup()
	{
		$this->model = app('Role');
		$this->acl = app('AccessControl');
		$this->model_usergroup = app('Usergroup');
	}



	public function getRoles()
	{
		$usergroups = $this->model_usergroup->with('role.module')->get();

		$usergroups->each(function($group)
		{
			$group->roles->each(function($role)
			{
				$role->permissions = unserialize($role->permissions);
			});
		});

		return $usergroups;

	}


	public function getGroupRoles($usergroup_id)
	{
		$callback = function($model, $host) use($usergroup_id)
		{
			$model->where('usergroup_id','=', $usergroup_id);

			return $model;
		};

		return $this->fetchAll($callback);
	}



	public function getRole($role_id, $callback = null)
	{
		return $this->show($role_id, $callback);
	}



	public function insertRole($data, $callback = null)
	{
		if(isset($data['permissions']))
		{
			$data['permissions'] = serialize($data['permissions']);
		}

		return $this->insert($data, $callback);
	}


	public function updateRole($id, $data, $callback = null)
	{
		return $this->save($data, $id, $callback);
	}



	public function removeRole($id)
	{
		return $this->delete($id);
	}

}

