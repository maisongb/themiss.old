<?php
/*
 * RegistrationController
 */
class RegistrationController extends BaseController {
	public function index(){
		$fb = OAuth::consumer('Facebook', Config::get('facebook.return'));
		$instagram = OAuth::consumer('Instagram', Config::get('instagram.return'));

		$fb_login_uri = (string)$fb->getAuthorizationUri();
		$instagram_login_uri = (string)$instagram->getAuthorizationUri();

		return View::make('auth.registration.index')
			->with('fb_login_uri', $fb_login_uri)
			->with('instagram_login_uri', $instagram_login_uri);
	}

	public function confirm_facebook_signup(){
		$profile = Session::get('facebook.profile');

		return View::make('auth.confirm_facebook')
			->withProfile($profile);
	}

	public function confirm_instagram_signup(){
		$profile = Session::get('instagram.profile');

		return View::make('auth.confirm_instagram')
			->withProfile($profile);
	}

	public function signup(){
		$signup = new \App\Lib\Registration('signup', 'email');

		if($signup->execute() === true){
			return Redirect::to('/')
        		->withMessages('Registered!');
		}else{
			return Redirect::to('auth.register')
				->withErrors(array('register' => $error))
				->withInput(Input::except('password'));
		}
	}

	public function facebook_signup(){
		$signup = new \App\Lib\Registration('signup', 'facebook');

		if($signup->execute() === true){
			return Redirect::to('/')
        		->withMessages('Registered!');
		}else{
			return Redirect::to('auth.register')
				->withErrors(array('register' => $error))
				->withInput(Input::except('password'));
		}
	}

	public function instagram_signup(){
		$signup = new \App\Lib\Registration('signup', 'instagram');

		if($signup->execute() === true){
			return Redirect::to('/')
        		->withMessages('Registered!');
		}else{
			return Redirect::to('auth.register')
				->withErrors(array('register' => $error))
				->withInput(Input::except('password'));
		}
	}
}