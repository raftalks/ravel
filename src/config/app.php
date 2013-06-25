<?php

return array(

	/**
	 * frontend theme
	 */
	'frontend_theme'	=> 'default',

	/**
	 * base url for administration
	 */
	'admin_base_uri'	=> 'admin',

	/**
	 * api base uri
	 */	
	'api_base_uri'		=> 'ravel/api', 

	/**
	 * front end uri
	 */
	'frontend_base_uri'	=> '', 

	/**
	 * Default User added to when installing
	 */
	'setup_user'		=> array('username'=>'admin', 'password'=>'ravel', 'email' => 'admin@yourwebsite.com'),


	/**
	 * path from src directory of the package
	 */
	'required_files'	=> array(
							'Raftalks/Ravel/FormTemplates.php',
						),

	/**
	 * Layouts used in the system frontend theme
	 */
	'layouts'			=> array(
							'list' => array(
										'blog',
										'list',
									),
							'item' => array(
									'page',
									'post',
								)
						),
	/**
	 * Namespace Class Aliases
	 */
	'aliases' 			=> array(

							'Acl'			=> 'Raftalks\Ravel\Facades\Acl',
							'Post'			=> 'Raftalks\Ravel\Facades\Post',
							'Page'			=> 'Raftalks\Ravel\Facades\Page',
							'Media'			=> 'Raftalks\Ravel\Facades\Media',
							'MediaCollection' => 'Raftalks\Ravel\Facades\MediaCollection',
							'PostCategory'	=> 'Raftalks\Ravel\Facades\PostCategory',
							'Menu'			=> 'Raftalks\Ravel\Facades\Menu',
							'UsersLibrary'	=> 'Raftalks\Ravel\Facades\UsersLibrary',
							'Xhtml'			=> 'Raftalks\Form\Html\Html',
							'Xform'			=> 'Raftalks\Form\Form',
							'Image' 		=> 'Intervention\Image\Facades\Image',
						),    

);