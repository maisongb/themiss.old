<?php
Route::get('/', function(){
	return View::make('index');
});

Route::get('login', 'LoginController@index');
Route::get('login/facebook', 'LoginController@facebook_signin');
Route::get('login/facebook/confirm', 'LoginController@confirm_facebook_signup');
Route::post('login', 'LoginController@signin');

Route::get('register', 'LoginController@register');
Route::get('register/facebook', 'LoginController@facebook_signup');
Route::post('register', 'LoginController@signup');

Route::get('dashboard/upload', 'DashboardController@upload');
Route::get('dashboard/upload/album/{album_id}', 'DashboardController@album');