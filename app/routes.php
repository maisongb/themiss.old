<?php

Route::get('/', array(
	'uses'	=> 'App\Controllers\Pages\HomeController@index',
	'as' => 'page.home'
));

Route::get('latest/{total}/{from}', array(
	'uses'	=> 'App\Controllers\Pages\HomeController@latest',
	'as' => 'pictures.new'
))->where(array('total' => '[0-9]+', 'from' => '[0-9]+'));

Route::get('miss_of_the_month', array(
	'uses'	=> 'App\Controllers\Pages\HomeController@missOfTheMonth',
	'as' => 'pictures.miss_of_the_month'
));

Route::get('winners/{month?}/{year?}', array(
	'uses'	=> 'App\Controllers\Pages\HomeController@winners',
	'as' => 'pictures.winners'
))->where(array('month' => '[0-9]+', 'year' => '[0-9]+'));

//All te routes regarding the /login path
Route::group(array(
	'prefix' 	=> 'login', 
	'namespace'	=> '\App\Controllers\Auth',
	'before' 	=> 'loggedin'
), function(){
	Route::get('/', array(
		'uses' 	=> 'LoginController@index',
		'as'	=> 'login'
	));
	Route::post('/', 'LoginController@signin');

	Route::get('facebook', array(
		'uses' 	=> 'LoginController@facebookSignin',
		'as'	=> 'login.facebook'
	));
	Route::get('instagram', array(
		'uses' 	=> 'LoginController@instagramSignin',
		'as'	=> 'login.instagram'
	));

	//existing users connecting to social
	Route::get('connect/facebook', array(
		'uses' 	=> 'ConnectSocialController@facebook',
		'as' 	=> 'login.connect.facebook'
	));
	Route::get('connect/instagram', array(
		'uses' 	=> 'ConnectSocialController@instagram',
		'as' 	=> 'login.connect.instagram'
	));
});

Route::group(array(
	'prefix' => 'connect_social', 
	'namespace'	=> '\App\Controllers\Auth'
), function(){
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

		Route::get('voted', array(
			'as' => 'profile.voted',
			'uses' => 'IndexController@voted'
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

		Route::group(array('prefix' => 'manage'), function (){
			Route::get('pictures', array(
				'as' => 'dashboard.manage.pictures',
				'uses' => 'ManagementController@pictures'
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

/*
	These routes are only accessible to the admins of the site
*/
Route::group(array('prefix' => 'search'), function (){
	Route::post('username', array(
		'as' => 'search.username',
		'uses' => 'App\Controllers\Profile\SearchController@results'
	));	
});

/*
 * routes related to surveys
 */
Route::group(array(
	'prefix' => 'survey',
	'namespace' => 'App\Controllers\Survey',
	'before' => 'loggedin'
), function (){
	Route::get('{id}', array(
		'as' => 'survey.show',
		'uses' => 'IndexController@show'
	));
	Route::get('create', array(
		'as' => 'survey.create',
		'uses' => 'IndexController@creator'
	));
});

Route::get('test/test', function ()
{	
	$user = \Sentry::getUser();
	$group = \Sentry::findGroupByName('male');
	var_dump($user->hasPermission(array('share')));
});

Route::get('clear/session', function()
{
	//lusitanian_oauth_token
	$f = OAuth::consumer('Facebook');
	$i = OAuth::consumer('Instagram');

	Session::flush();
	session_unset();

	dd($_SESSION);
});