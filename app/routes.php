<?php

Route::get('/', function(){
	return View::make('index');
});

//All te routes regarding the /login path
Route::group(array('prefix' => 'login', 'before' => 'loggedin'), function(){
	Route::get('/', '\App\Controllers\Auth\LoginController@index');
	Route::post('/', '\App\Controllers\Auth\LoginController@signin');

	Route::get('facebook', '\App\Controllers\Auth\LoginController@facebookSignin');
	Route::get('instagram', '\App\Controllers\Auth\LoginController@instagramSignin');
});

Route::get('logout', function(){
	Sentry::logout();
	return Redirect::to('/');
});

//All te routes regarding the /register path
Route::group(array('prefix' => 'register', 'before' => 'loggedin'), function(){
	Route::get('/', '\App\Controllers\Auth\RegistrationController@index');
	Route::post('/', '\App\Controllers\Auth\RegistrationController@signup');

	Route::get('facebook', '\App\Controllers\Auth\RegistrationController@facebookSignup');
	Route::get('instagram', '\App\Controllers\Auth\RegistrationController@instagramSignup');

	Route::get('facebook/confirm', '\App\Controllers\Auth\RegistrationController@confirmFacebookSignup');
	Route::get('instagram/confirm', '\App\Controllers\Auth\RegistrationController@confirmInstagramSignup');
});

Route::group(array(
		'prefix' 	=> '{username}', 
		'namespace'	=> '\App\Controllers\Dashboard',
		'before' 	=> 'dashboard',
	), function (){
		Route::get('/', array(
			'as'	=> 'dashboard.home',
			'uses' 	=> 'IndexController@home'
		));

		Route::group(array(
				'prefix' 	=> 'upload'
			), function() {
				Route::get('/', array(
					'as'	=> 'dashboard.upload',
					'uses' 	=> 'UploadController@home'
				));
				
				Route::get('facebook', array(
					'as'		=> 'dashboard.upload.facebook',
					'uses' 		=> 'UploadController@facebookAlbums'
				));

				Route::get('facebook/album/{album_id}', array(
					'as'		=> 'dashboard.upload.facebook.album',
					'uses' 		=> 'UploadController@facebookPhotos'
				));

				Route::get('instagram', array(
					'as'	=> 'dashboard.upload.instagram',
					'uses' 	=> 'UploadController@instagramPhotos'
				));
		});
});