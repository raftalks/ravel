<?php
//View Composers

View::composer('ravel::layouts.admin.partials.sidebar', function($view)
{
		$view->with('menulinks', Menu::build());
});