<?php

App::missing(function ($error){
	echo "404";
});

App::error(function(App\Lib\Exceptions\ProviderNotConnectedException $e, $code){
	//dd('connect user with the social service');
});

App::error(function(Cartalyst\Sentry\Users\UserNotFoundException $e, $code){
	return "damnit! the user doesn't exist.... yet!";
});

//