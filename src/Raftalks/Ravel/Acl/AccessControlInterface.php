<?php namespace Raftalks\Ravel\Acl;

Interface AccessControlInterface
{
	public function 	getModeratorGroups();

	public function 	is_guest();

	public function 	check();

	public function 	getUser();

	public function 	isUserActivated();

	public function 	getUserRoles();

	public function 	setModule($module);

	public function 	is_moderator();

	public function 	syncModules();

	public function 	__call($method, $args);
	
}