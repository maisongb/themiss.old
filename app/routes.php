<?php
Route::get('/', function(){
	return View::make('index');
});

Route::group(array('prefix' => 'login'), function(){
	Route::get('/', 'LoginController@index');

	Route::get('facebook', 'LoginController@facebook_signin');
	Route::get('facebook/confirm', 'LoginController@confirm_facebook_signup');

	Route::get('instagram', 'LoginController@instagram_signin');
	Route::get('instagram/confirm', 'LoginController@confirm_instagram_signup');

	Route::post('/', 'LoginController@signin');
});

Route::group(array('prefix' => 'register'), function(){
	Route::get('/', 'RegistrationController@index');
	Route::post('/', 'RegistrationController@signup');

	Route::get('facebook', 'RegistrationController@facebook_signup');
	Route::get('instagram', 'RegistrationController@instagram_signup');
});

Route::get('dashboard', 'DashboardController@index');
Route::get('dashboard/upload/album/{album_id}', 'DashboardController@album');