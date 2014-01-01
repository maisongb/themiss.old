<?php
Route::get('/', function(){
	return View::make('index');
});

Route::group(array('prefix' => 'login', 'before' => 'loggedin'), function(){
	Route::get('/', 'LoginController@index');

	Route::get('facebook', 'LoginController@facebookSignin');

	Route::get('instagram', 'LoginController@instagramSignin');

	Route::post('/', 'LoginController@signin');
});

Route::group(array('prefix' => 'register', 'before' => 'loggedin'), function(){
	Route::get('/', 'RegistrationController@index');
	Route::post('/', 'RegistrationController@signup');

	Route::get('facebook', 'RegistrationController@facebookSignup');
	Route::get('instagram', 'RegistrationController@instagramSignup');

	Route::get('facebook/confirm', 'RegistrationController@confirmFacebookSignup');
	Route::get('instagram/confirm', 'RegistrationController@confirmInstagramSignup');
});

Route::get('dashboard', 'DashboardController@index');
Route::get('dashboard/upload/album/{album_id}', 'DashboardController@album');