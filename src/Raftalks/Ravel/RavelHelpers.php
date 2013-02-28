<?php

function adminUrl($str)
{
	$prefix = _ADMIN_BASE_;
	return $prefix . $str;
}


function currentUserName()
{
	$user = Auth::getUser();
	if(!is_null($user))
	{
		return $user->username;
	}

	return null;
}

function apiUrl($str)
{
	$prefix = _API_BASE_;
	return $prefix . $str;
}

function frontUrl($str)
{
	$prefix = _FRONT_BASE_;
	return $prefix . $str;
}

function dd($value)
{
	die(call_user_func_array('var_dump', func_get_args()));
}


function admin_asset($path)
{
	return URL::asset('packages/raftalks/ravel/'.$path);
}

function aw($str)
{
	return "{{ $str }}";
}

function showflag($ccode)
{
	return "<img  class='flag flag-$ccode'/>";
}

function langflag($lang)
{
	$ccode = Config::get("ravel::flags.$lang",'en');
	if(!is_null($ccode))
	{
		return showflag($ccode);
	}
}

function current_lang()
{
	return Config::get('app.locale');
}


function showActivated()
{
	return '<p>Activated</p>';
}

function showDeactivated()
{
	return '<p>Deactivated</p>';
}


function makeApiKey()
{
	$uniqid = uniqid();
	$rand = rand(1000,9999);
	$key = md5($rand . $uniqid);
	
	return $key;
}
