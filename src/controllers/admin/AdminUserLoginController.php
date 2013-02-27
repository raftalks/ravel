<?php

class AdminUserLoginController extends AppController
{

	protected $title = 'Login';

	protected $layout = 'ravel::layouts.admin.login';

	protected $auth;

	

	public function getIndex()
	{

		$this->layout->nest('content','ravel::admin.login.index');
	}

	public function postIndex()
	{
		$credentials = array(
				'username' => Input::get('username'),
				'password' => Input::get('password'),
			);
	
		$remember = Input::has('remember');

		//Check user authentication attempt and if successful, login the user else return to login page
		
		$loginAttempt = Auth::attempt($credentials, $remember);

		if($loginAttempt)
		{
			$message = Lang::get('auth.user_welcome');
			return Redirect::action('PostsAdminController@getIndex')->with('notice',$message);
		}
		else
		{
			$error_msg = Lang::get('auth.login_failed');

			return Redirect::back()->withErrors($error_msg);
		}
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('/');
	}
}