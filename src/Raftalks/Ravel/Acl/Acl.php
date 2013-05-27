<?php namespace Raftalks\Ravel\Acl;
use Config;
use Module;
use Usergroup;
use Role;

class Acl implements AccessControlInterface
{
	protected $user = null;

	protected $userGroup = null;

	protected $auth;

	protected $roles = null;

	protected $module = null;

	protected $modules = array();

	protected $moderator_groups = array();

	protected $userGroups = array();


	public function __construct($auth, $rolesConfig)
	{
		$this->auth = $auth;
		$this->modules = $rolesConfig['modules'];
		$this->moderator_groups = $rolesConfig['moderator_usergroups'];
		$this->userGroups = $rolesConfig['usergroups'];
	}

	public function setModuleModel($module = null)
	{
		$this->model_module = (!is_null($module)) ? $module: new Module;
	}

	public function setUsergroupModel($usergroup = null)
	{
		$this->model_usergroup = (!is_null($usergroup)) ? $usergroup : new Usergroup;
	}

	public function setRoleModel($role = null)
	{
		$this->model_role = (!is_null($role)) ? $role : new Role;
	}



	public function getModeratorGroups()
	{
		if(is_null($this->moderator_groups))
		{
			$this->moderator_groups = Config::get('ravel::roles.moderator_usergroups');
		}

		return $this->moderator_groups;
	}


    /**
     * Check if user is a guest (not authenticated)
     * 
     * @access public
     *
     * @return boolean
     */
	public function is_guest()
	{
		return $this->auth->guest();
	}


    /**
     * Check if user is authenticated
     * 
     * @access public
     *
     * @return boolean
     */
	public function check()
	{
		return $this->auth->check();
	}


	public function getUser()
	{
		if(is_null($this->user))
		{
			$this->user = $this->auth->user();
		}

		return $this->user;
	}


	public function isUserActivated()
	{
		$user = $this->getUser();
		if(is_null($user))
		{
			return false;
		}
		return (int)$user->activated == 1;
	}

	public function getUserRoles()
	{

		if($this->is_guest())
		{
			//fetch visitor roles
			if(is_null($this->roles))
			{
				$this->roles = $this->getVisitorRoles();
			}

			return $this->roles;
		}

		 if(is_null($this->roles))
		 {
			$roles_data = array();
			
			$usergroup = $this->user->usergroup;
			
			$roles = $usergroup->roles()->with(array('module'))->get();
			
			foreach($roles as $role)
			{
				$module = $role->module;
				$module_name = strtolower($module->module);
				$module_name = str_replace(' ', '_', $module_name);
				$roles_data[$module_name] = unserialize($role->permissions);
			}

			$this->roles = $roles_data;
		}

		return $this->roles;

	}


	protected function getVisitorRoles()
	{
		$visitorGroupName = Config::get('ravel::roles.visitors_group','user');
		$usrGroup = new Usergroup;
		$usergroup = $usrGroup->getUserGroupByName($visitorGroupName);
		$roles = $usergroup->roles()->with(array('module'))->get();
		$roles_data = array();
		foreach($roles as $role)
		{
			$module = $role->module;
			$module_name = strtolower($module->module);
			$module_name = str_replace(' ', '_', $module_name);
			$roles_data[$module_name] = unserialize($role->permissions);
		}

		return $roles_data;
	}

	protected function getModule()
	{
		return $this->module;
	}

	public function setModule($module)
	{
		$this->module = strtolower($module);
	}


	protected function can_do($moduleName, $action)
	{
		if(!$this->isUserActivated() && !$this->is_guest())
		{
			return false;
		}

		if(!is_null($moduleName))
		{
			$this->getUserRoles();
			
			if(!isset($this->roles[$moduleName]))
			{
				return false;
			}

			$module = $this->roles[$moduleName];

			if(isset($module->$action))
			{
				return $module->$action;
			}

			if(isset($module[$action]))
			{
				return $module[$action];
			}
		}

		return false;

	}


	protected function getUserGroup()
	{
		if(is_null($this->userGroup))
		{
			$user = $this->getUser();
			$usergroup = $user->usergroup()->first();
			$this->userGroup = $usergroup;
		}

		return $this->userGroup;
	}

    /**
     * Verify if user belongs to usergroup
     * 
     * @param string $group UserGroup name.
     *
     * @access protected
     *
     * @return boolean
     */
	protected function is_group($group)
	{
		$usergroup = $this->getUserGroup();
		
		return $usergroup->group == $group;
	}


	public function is_moderator()
	{
		if($this->is_guest())
		{
			return false;
		}
		
		$usergroup = $this->getUserGroup();
		$moderators = $this->getModeratorGroups();

		return in_array($usergroup->group, $moderators);
	}


	public function syncModules()
	{
		$Modules = $this->modules;
		$RegModules = $this->model_module->get();

		$mods = array();
		if(!is_null($RegModules))
		{
			foreach($RegModules as $mod)
			{
				$mods[$mod->module] = $mod->id;
			}

		}
		
		//register new modules not in db
		foreach($Modules as $module)
		{
			if(!isset($mods[$module]))
			{
				//hmmm have to register this mod to the db with all the usergroups
				$this->registerModule($module);
			}
		}

		//remove modules not in use in the db comparing to config
		foreach($mods as $mod=>$mod_id)
		{
			if(!in_array($mod, $Modules))
			{
				//hmmm module in db is not in use
				$this->unregisterModule($mod_id);
			}
		}


	}


	protected function registerUsergroups()
	{
		$usergroups = $this->userGroups;
		$data = array();
		foreach($usergroups as $group)
		{
			$data[] = array(
					'group' => $group,
					'parent_id'	=> 0
				);
		}
		
		$this->model_usergroup->insert($data);
	}


	protected function registerModule($name)
	{
		$mod = $this->model_module->newInstance();
		$mod->module = $name;
		$mod->save();

		$moduleId = $mod->id;

		if(!is_null($moduleId))
		{
			$this->createDefaultRoleForModule($moduleId);
		}
	}

	protected function unregisterModule($id)
	{
		$mod = $this->model_module->newInstance();
		$mod = $mod->find($id);
		$mod->delete();
	}




	protected function createDefaultRoleForModule($moduleId)
	{
		//for each usergroup we have to register the new module to roles table in db
		$usergroups = $this->model_usergroup->get();
		if(!$usergroups->count())
		{
			$this->registerUsergroups();
			$usergroups = $this->model_usergroup->get();
		}

		$role_actions = Config::get('ravel::roles.role_actions');

		$actions = array();
		$default_role_action_value = Config::get('ravel::roles.default_action_set', false);
		$forced_usergroups_to_role_action_true = Config::get('ravel::roles.usergroups_default_to_true', array());

		foreach($usergroups as $group)
		{
			$role = $this->model_role->newInstance();
			$role->usergroup_id = $group->id;
			$role->module_id = $moduleId;

			foreach($role_actions as $action)
			{
				if(in_array($group->group, $forced_usergroups_to_role_action_true))
				{
					$actions[$action] = true; 
				}
				else
				{
					$actions[$action] = $default_role_action_value; //setting false to all actions by default
				}
				
			}

			$permission = serialize($actions);

			$role->permissions = $permission;
			$role->save();
		}
			
	}


	public function __call($method, $args)
	{
		if(starts_with($method, 'can_'))
		{
			$action = str_replace('can_', '', $method);
			$module = $this->getModule();
			return $this->can_do($module, $action);
		}

		if(starts_with($method, 'is_'))
		{
			$action = str_replace('is_', '', $method);
			
			return $this->is_group($action);
		}
	}



}