<?php
//View Composers

View::composer('ravel::layouts.admin.partials.sidebar', function($view)
{
		$view->with('ravel_admin_menulinks', Menu::build());
});