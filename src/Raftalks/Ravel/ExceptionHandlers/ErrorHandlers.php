<?php

// ------------------------------------------------------------
// Error Handlers
// ------------------------------------------------------------

App::error(function(Exception $e, $code)
{
	Log::error($e);


	if (Request::ajax())
	{
		$default_message = 'Oops! Something went wrong...';
		$headers = array();

		return Response::json(array(
			'error' => $e->getMessage() ?: $default_message,
		), $code, $headers);
	}


});

