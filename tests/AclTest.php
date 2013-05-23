<?php

class AclTest extends RavelTestCase
{

	public function setUp()
	{
		$rolesConfig = $this->_getRolesConfig(); //Config::get('Ravel::Roles');
		$auth = $this->_getAuthMock();
		$this->acl = new Raftalks\Ravel\Acl\Acl($auth, $rolesConfig);

		$Module = $this->_getModuleMock();
		
		
		$this->acl->setModuleModel($Module);
		$this->acl->setUsergroupModel($this->_getUsergroupMock());
		$this->acl->setRoleModel($this->_getRoleMock());
	}


	public function testSomething()
	{
		$this->assertTrue(true);
	}


	public function testAclCheckUserIsGuest()
	{
		$this->assertFalse($this->acl->is_guest());
	}



	public function testCheckUserAuthenticated()
	{
		$this->assertTrue($this->acl->check());
	}



	public function testGetModeratorGroups()
	{
		$rolesConfig = $this->_getRolesConfig();
		$this->assertEquals($this->acl->getModeratorGroups(), $rolesConfig['moderator_usergroups'] );
	}


	public function testIsUserActivated()
	{
		$this->assertTrue($this->acl->isUserActivated());
	}





	protected function _getAuthMock()
	{
		$user = $this->_getUserMock();

		$mock = \Mockery::mock('stdClass');
		$mock->shouldReceive(array(
				'guest' => false,
				'check' => true,
				'user'  => $user
			));

		return $mock;
	}


	protected function _getModuleMock()
	{
		$mock = Mockery::mock('stdClass');

		return $mock;
	}


	protected function _getUserMock()
	{
		$mock = Mockery::mock('stdClass');

		$mock->activated= true;

		return $mock;
	}

	protected function _getUsergroupMock()
	{
		$mock = \Mockery::mock('stdClass');
		
		return $mock;
	}

	protected function _getRoleMock()
	{
		$mock = \Mockery::mock('stdClass');
		
		return $mock;
	}

	protected function _getRolesConfig()
	{
		return array(

		'usergroups'		=> array('superadmin','admin','manager','editor','author','user'),

		'moderator_usergroups'	=> array('superadmin','admin','manager','editor'),


		//add modules here and it will get registered to the db automatically
		'modules'	=> array(

				'global',
				'contents',
				'categories',
				'settings'

		),

		'role_actions'	=> array(

				'create',
				'read',
				'update',
				'delete',

		),

		//default action value applied to all usergroup role actions except to those groups
		//mentioned under usergroups_default_to_true
		'default_action_set' => false,

		//given usergroups when registering the roles, actions will default to true
		'usergroups_default_to_true' => array('superadmin') 

);
	}
}