<?php

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