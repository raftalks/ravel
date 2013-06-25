<?php

Route::controller('/pages','PageController');
Route::controller('/posts','PostController');


// Route::group(array('prefix'=>_FRONT_BASE_),function()
// {
// 	Route::get('/',function()
// 		{
// 			return "this is home";
// 		});

// 	Route::controller('/pages','PageController');
// 	Route::controller('/posts','PostController');

// });
