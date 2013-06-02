<?php

App::bind('LoggedInUser',function()
{
	return Auth::user();
});


App::bind('AccessControl','acl');


App::bind('ContentModel', function()
{
	return new ContentModel;
});

App::bind('Media',function()
{
	return new Media;
});

App::bind('Mcollection', function()
{
	return new Mcollection;
});

App::bind('Usermodel', function()
{
	return new Usermodel;
});



App::bind('EmptyCollection',function()
{
	return new Illuminate\Support\Collection(array());
});





