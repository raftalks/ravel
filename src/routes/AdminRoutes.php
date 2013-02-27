<?php

Route::filter('ravelauth', function()
{
	if(Request::ajax())
	{
		if (Auth::guest()){
			App::abort(403);
			//throw new PermissionException();
		}
	}

	if (Auth::guest()) return Redirect::action('AdminUserLoginController@getIndex');
});



Route::group(array('prefix'=>_ADMIN_BASE_),function()
{
	//Route::controller("/", 'DashboardAdminController');
	Route::get('/','DashboardAdminController@getIndex');
	Route::get('/logout',array('uses'=>'AdminUserLoginController@getLogout','as'=>'ravellogout'));
	Route::controller("/posts", 'PostsAdminController');
	Route::controller("/pages", 'PagesAdminController');
	Route::controller("/login", 'AdminUserLoginController');
	Route::controller("/settings/users", 'UsersAdminController');

});




// Route::get('test',function()
// {

// 	$users = Usermodel::with(array('usergroup' => function($query)
// 	{

// 	    $query->join('roles','usergroups.id','=','roles.usergroup_id');
// 	    $query->select(array('usergroups.id','usergroups.group','roles.permissions'));

// 	}))->where('users.usergroup_id','=', 1)->get();

// 	dd($users->toArray());

// });

