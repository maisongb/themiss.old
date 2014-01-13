<?php

Route::get('/', function(){
	return View::make('index');
});

//All te routes regarding the /login path
Route::group(array(
	'prefix' => 'login', 
	'namespace'	=> '\App\Controllers\Auth',
	'before' => 'loggedin'
), function(){
	Route::get('/', 'LoginController@index');
	Route::post('/', 'LoginController@signin');

	Route::get('facebook', 'LoginController@facebookSignin');
	Route::get('instagram', 'LoginController@instagramSignin');
});

Route::get('logout', function(){
	Sentry::logout();
	return Redirect::to('/');
});

//All te routes regarding the /register path
Route::group(array(
	'prefix' 	=> 'register', 
	'namespace'	=> '\App\Controllers\Auth',
	'before' 	=> 'loggedin'
), function(){
	Route::get('/', 'RegistrationController@index');
	Route::post('/', 'RegistrationController@signup');

	Route::get('facebook', 'RegistrationController@facebookSignup');
	Route::get('instagram', 'RegistrationController@instagramSignup');

	Route::get('facebook/confirm', 'RegistrationController@confirmFacebookSignup');
	Route::get('instagram/confirm', 'RegistrationController@confirmInstagramSignup');
});

Route::group(array('prefix' => '{username}'), function (){

	Route::group(array('namespace' => '\App\Controllers\Profile'), function(){
		Route::get('/', array(
			'as'	=> 'profile.home',
			'uses' 	=> 'IndexController@home'
		));

		Route::get('photo/{id}', array(
			'as' => 'pictures.single',
			'uses' => 'IndexController@picture'
		));	
	});

	Route::group(array(
		'prefix' 	=> 'dashboard', 
		'namespace'	=> '\App\Controllers\Dashboard',
		'before' 	=> 'dashboard',
	), function() {
		Route::group(array('prefix' => 'upload'), function(){
			Route::get('/', array(
				'as'	=> 'dashboard.upload',
				'uses' 	=> 'UploadController@home'
			));
			Route::post('/', array(
				'as'	=> 'dashboard.upload.save',
				'uses' 	=> 'UploadController@save'
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
});

Route::post('pictures/vote/add', array(
	'as' => 'pictures.vote.add',
	'uses' => '\App\Controllers\Pictures\IndexController@addVote'
));
Route::post('pictures/remove', array(
	'as' => 'pictures.remove',
	'uses' => '\App\Controllers\Pictures\IndexController@remove'
));

Route::post('profile/follow', array(
	'as'	=> 'profile.follow',
	'uses' 	=> '\App\Controllers\Profile\IndexController@follow'
));
Route::post('profile/unfollow', array(
	'as'	=> 'profile.unfollow',
	'uses' 	=> '\App\Controllers\Profile\IndexController@unfollow'
));

Route::get('test/test', function ()
{	
	$f = new \App\Lib\Social\SocialProvider('facebook');
	$f = $f->provider;
	dd($f->likePicture('http://themiss.local/AhmedFoysal/photo/7'));
});