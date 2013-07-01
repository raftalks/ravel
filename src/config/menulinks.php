<?php

return array(
    'default' => array(
        'dashboard' => array(
            'label' => 'Dashboard',
            'link' => action('DashboardAdminController@getIndex')
        ),
        'contents' => array(
            'label' => 'Contents',
            'link' => '#',
            'children' => array(
                'pages' => array(
                    'label' => 'Pages',
                    'link' => action('PagesAdminController@getIndex'),
                ),
                'posts' => array(
                    'label' => 'Posts',
                    'link' => action('PostsAdminController@getIndex'),
                ),
                'posts_categories' => array(
                    'label' => 'Post Categories',
                    'link' => action('PostsCategoriesAdminController@getIndex'),
                ),
            )
        ),
        'media' => array(
            'label' => 'Media',
            'link' => action('MediaAdminController@getIndex'),
        ),
        'settings' => array(
            'label' => 'Settings',
            'link' => '#',
            'children' => array(
                'users' => array(
                    'label' => 'Users',
                    'link' => action('UsersAdminController@getIndex'),
                ),
                'page' => array(
                    'label' => 'Page Settings',
                    'link' => '/admin',
                ),
            )
        ),
    ),
    'template' => 'ravel::templates.admin.menu'
);