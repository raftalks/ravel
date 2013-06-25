<?php

return array(

		'usergroups'		=> array('superadmin','admin','manager','editor','author','user','guest'),

		'moderator_usergroups'	=> array('superadmin','admin','manager','editor'),

		'visitors_group'	=> 'guest',
		
		//add modules here and it will get registered to the db automatically
		'modules'	=> array(

				'global',
				'contents',
				'medias',
				'menus',
				'categories',
				'settings'

		),

		'role_actions'	=> array(

				'create',
				'read',
				'update',
				'delete',
				'moderator'

		),

		//default action value applied to all usergroup role actions except to those groups
		//mentioned under usergroups_default_to_true
		'default_action_set' => true,

		//given usergroups when registering the roles, actions will default to true
		'usergroups_default_to_true' => array('superadmin') 

);