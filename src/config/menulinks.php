<?php

return array(

	'default' => array(
		'dashboard'	=> array(
						'label'=>'Dashboard', 
						'link'=> action('DashboardAdminController@getDashboard')
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

										'posts_categories' => array(
												'label' => 'Post Categories',
												'link'	=> action('PostsCategoriesAdminController@getIndex'),
												),
										)
						),

		

		'media'		=> array(
						'label'		=>'Media', 
						'link'		=>action('MediaAdminController@getIndex'),
						
						),

		'menus'		=> array(

							'label' => 'Menus',
							'link'	=> action('MenusAdminController@getIndex'),

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

	'template'	=> 'ravel::templates.admin.menu',
	'frontend_template'	=> 'ravel::templates.frontend.menu'

);