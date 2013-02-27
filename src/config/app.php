<?php

return array(

	'frontend_theme'	=> 'default', //default theme to load the frontend

	'admin_base_uri'	=> 'admin',//base url for admin

	'api_base_uri'		=> 'ravel/api', //base url for api

	'frontend_base_uri'	=> '', //base url for frontend

	'setup_user'		=> array('username'=>'admin', 'password'=>'ravel', 'email' => 'admin@yourwebsite.com'),


						//path from src directory of the package
	'required_files'	=> array(
							'Raftalks/Ravel/FormTemplates.php',
						),

	'aliases' 			=> array(

							'Acl'			=> 'Raftalks\Ravel\Facades\Acl',
							'Post'			=> 'Raftalks\Ravel\Facades\Post',
							'Page'			=> 'Raftalks\Ravel\Facades\Page',
							'Menu'			=> 'Raftalks\Ravel\Facades\Menu',
							'UsersLibrary'	=> 'Raftalks\Ravel\Facades\UsersLibrary',
							'Html'			=> 'Html\Html',
							'Form'			=> 'Form\Form',


						),    

);