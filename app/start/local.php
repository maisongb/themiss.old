<?php

App::error(function(\App\Lib\Social\ProviderNotConnectedException $e, $code){
	dd('connect user with the social service');
});

//