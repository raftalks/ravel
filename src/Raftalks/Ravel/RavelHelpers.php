<?php

if(! function_exists('adminUrl'))
{
	function adminUrl($str)
	{
		$prefix = _ADMIN_BASE_;
		return $prefix . $str;
	}

}

if(! function_exists('currentUserName'))
{
	function currentUserName()
	{
		$user = Auth::getUser();
		if(!is_null($user))
		{
			return $user->username;
		}

		return null;
	}
}

if(! function_exists('currentUserId'))
{
	function currentUserId()
	{
		$user = Auth::getUser();
		if(!is_null($user))
		{
			return $user->id;
		}

		return null;
	}
}


if(! function_exists('is_moderator'))
{
	function is_moderator()
	{
		$Acl = app('AccessControl');
		return $Acl->is_moderator();
	}
}


if(! function_exists('apiUrl'))
{
	function apiUrl($str)
	{
		$prefix = _API_BASE_;
		return $prefix . $str;
	}
}

if(! function_exists('frontUrl'))
{
	function frontUrl($str)
	{
		$prefix = _FRONT_BASE_;
		return $prefix . $str;
	}
}

if(! function_exists('dd'))
{
	function dd($value)
	{
		die(call_user_func_array('var_dump', func_get_args()));
	}
}


if(! function_exists('admin_asset'))
{
	function admin_asset($path)
	{
		return URL::asset('packages/raftalks/ravel/'.$path);
	}
}

if(! function_exists('aw'))
{
	function aw($str)
	{
		return "{{ $str }}";
	}
}

if(! function_exists('showflag'))
{
	function showflag($ccode)
	{
		return "<img  class='flag flag-$ccode'/>";
	}
}

if(! function_exists('langflag'))
{
	function langflag($lang)
	{
		$ccode = Config::get("ravel::flags.$lang",'en');
		if(!is_null($ccode))
		{
			return showflag($ccode);
		}
	}
}

if(! function_exists('current_lang'))
{
	function current_lang()
	{
		return Config::get('app.locale');
	}
}

if(! function_exists('showActivated'))
{
	function showActivated()
	{
		return '<p>Activated</p>';
	}
}


if(! function_exists('showDeactivated'))
{
	function showDeactivated()
	{
		return '<p>Deactivated</p>';
	}
}


if(! function_exists('makeApiKey'))
{
	function makeApiKey()
	{
		$uniqid = uniqid();
		$rand = rand(1000,9999);
		$key = md5($rand . $uniqid);
		
		return $key;
	}
}

if(! function_exists('is_closure'))
{
	function is_closure($t) {
   		 return is_object($t) && ($t instanceof Closure);
	}
}


if(! function_exists('buildTree'))
{
	function buildTree(array $elements, $parentId = 0, $parentKey = 'parent_id', $childKey='children') {
	    
	    $branch = array();
	    foreach ($elements as $menu_id => $element) {
	        if ($element[$parentKey] == $parentId) {
	            $children = buildTree($elements, $menu_id, $parentKey, $childKey);
	            if ($children) {
	                $element[$childKey] = $children;
	            }
	            $branch[] = $element;
	        }
	    }

	    return $branch;
	}
}
