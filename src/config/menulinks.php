<?php

return array(

	'default' => array(
		'dashboard'	=> array(
						'label'=>'Dashboard', 
						'link'=> action('DashboardAdminController@getIndex')
						),

		'contents'		=> array(
						'label'		=>'Contents', 
						'link'		=>'#',
						'children'	=> array(

										'pages' => array(
												'label' => 'Pages',
												'link'	=> action('PagesAdminController@getIndex'),
												),

										'posts' => array(
												'label' => 'Posts',
												'link'	=> action('PostsAdminController@getIndex'),
												),
										)
						),

		

		'media'		=> array(
						'label'		=>'Media', 
						'link'		=>'#',
						'children'	=> array(

										'create' => array(
												'label' => 'New Media',
												'link'	=> '#',
												),

										'list' => array(
												'label' => 'All Media',
												'link'	=> '#',
												),
										)
						),


		'settings'	=> array(
						'label'		=>'Settings', 
						'link'		=>'#',
						'children'	=> array(

										'users' => array(
												'label' => 'Users',
												'link'	=> action('UsersAdminController@getIndex'),
												),

										'page' => array(
												'label' => 'Page Settings',
												'link'	=> '#',
												),
										)
						),

	),

	'template'	=> 'ravel::templates.admin.menu'

);