<?php

// ------------------------------------------------------------
// Error Handlers
// ------------------------------------------------------------

App::error(function(Exception $e, $code)
{
	Log::error($e);


	if (Request::ajax())
	{
		$default_message = 'Error : '.$e->getMessage().
                        " : \n".$e->getFile()." : \n".$e->getLine()." : \n".$e->getCode();
		$headers = array();

		return Response::json(array(
			'error' => $e->getMessage() ?: $default_message,
		), $code, $headers);
	}


});

