<?php 

class UsersAdminController extends AdminController
{
	protected $title = 'Users';

	protected $moduleName = 'AdminGlobal';


	public function __construct(Usergroup $usergroup)
	{
		parent::__construct();
		$this->resource_usergroup = $usergroup;
	}


	public function getIndex()
	{
		$data = array();

		$data['usergroups'] = $this->resource_usergroup->getSelectList();

		$this->layout->nest('content','ravel::admin.settings.users.home',$data);
	}
}