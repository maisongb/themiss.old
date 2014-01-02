<?php
namespace App\Controllers\Auth;

use \Config;
use \Input;
use \OAuth;
use \Redirect;
use \Session;
use \View;

/*
 * LoginController
 */
class LoginController extends \Controller 
{
	public function index()
	{
		$fb = OAuth::consumer('Facebook', Config::get('facebook.return'));
		$instagram = OAuth::consumer('Instagram', Config::get('instagram.return'));

		$fb_login_uri = (string)$fb->getAuthorizationUri();
		$instagram_login_uri = (string)$instagram->getAuthorizationUri();

		return View::make('auth.login.index')
			->with('fb_login_uri', $fb_login_uri)
			->with('instagram_login_uri', $instagram_login_uri);
	}

	public function signin()
	{
        $signin = new \App\Lib\Auth\Login('email');

        if($signin->execute() == true){
        	return Redirect::to('/')
        		->withMessages('Logged in!');
        }else{
			return View::make('auth.login.index')
				->withErrors(array('login' => $signin->errors))
				->withInput(Input::except('password'));
        }
	}

	public function facebookSignin()
	{
		$signin = new \App\Lib\Auth\Login('facebook');

		if($signin->execute() === true){
			return Redirect::to('/')
        		->withMessages('Logged in!');
		}elseif($signin->status == 'not-found'){
			return Redirect::to('/register/facebook/confirm');
		}else{
			dd($signin->errors);
		}
	}

	public function instagramSignin()
	{
		$signin = new \App\Lib\Auth\Login('instagram');

		if($signin->execute() === true){
			return Redirect::to('/')
        		->withMessages('Logged in!');
		}elseif($signin->status == 'not-found'){
			return Redirect::to('/register/instagram/confirm');
		}else{
			dd($signin->errors);
		}
	}
}