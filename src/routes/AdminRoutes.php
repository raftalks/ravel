<?php


Route::filter('ravelauth', function()
{
	if(Request::ajax())
	{
		if (Auth::guest()){
			App::abort(403);
		}
	}

	if (Auth::guest()) return Redirect::action('AdminUserLoginController@getIndex');
});



Route::group(array('prefix'=>_ADMIN_BASE_),function()
{
	Route::get('/','DashboardAdminController@getIndex');
	Route::get('/logout',array('uses'=>'AdminUserLoginController@getLogout','as'=>'ravellogout'));
	Route::controller("/posts", 'PostsAdminController');
	Route::controller("/categories",'PostsCategoriesAdminController');
	Route::controller("/pages", 'PagesAdminController');
	Route::controller("/login", 'AdminUserLoginController');
	Route::controller("/settings/users", 'UsersAdminController');
	Route::controller('/medias','MediaAdminController');
	Route::controller('/menus','MenusAdminController');
});

