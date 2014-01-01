<?php
/*
 * RegistrationController
 */
class RegistrationController extends BaseController 
{
	public function index()
	{
		$fb = OAuth::consumer('Facebook', Config::get('facebook.return'));
		$instagram = OAuth::consumer('Instagram', Config::get('instagram.return'));

		$fb_login_uri = (string)$fb->getAuthorizationUri();
		$instagram_login_uri = (string)$instagram->getAuthorizationUri();

		return View::make('auth.registration.index')
			->with('fb_login_uri', $fb_login_uri)
			->with('instagram_login_uri', $instagram_login_uri);
	}

	public function signup(){
		$signup = new \App\Lib\Auth\Registration('email');

		if($signup->execute() === true){
			return Redirect::to('/')
        		->withMessages('Registered!');
		}else{
			return Redirect::to('auth.registration.index')
				->withErrors(array('register' => $error))
				->withInput(Input::except('password'));
		}
	}

	public function facebookSignup()
	{
		$signup = new \App\Lib\Auth\Registration('facebook');

		if($signup->execute() === true){
			return Redirect::to('/')
        		->withMessages('Registered!');
		}else{
			return Redirect::to('auth.registration.index')
				->withErrors(array('register' => $error))
				->withInput(Input::except('password'));
		}
	}

	public function confirmFacebookSignup()
	{
		$profile = Session::get('facebook.profile');

		return View::make('auth.registration.confirm_facebook')
			->withProfile($profile);
	}

	public function instagramSignup()
	{
		$signup = new \App\Lib\Auth\Registration('instagram');

		if($signup->execute() === true){
			return Redirect::to('/')
        		->withMessages('Registered!');
		}else{
			return Redirect::to('auth.registration.index')
				->withErrors(array('register' => $error))
				->withInput(Input::except('password'));
		}
	}

	public function confirmInstagramSignup()
	{
		$profile = Session::get('instagram.profile');

		return View::make('auth.registration.confirm_instagram')
			->withProfile($profile);
	}
}