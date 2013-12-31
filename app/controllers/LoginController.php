<?php
/*
 * LoginController
 */
class LoginController extends BaseController {
	public function index(){
		$fb = OAuth::consumer('Facebook', Config::get('facebook.return'));
		$instagram = OAuth::consumer('Instagram', Config::get('instagram.return'));

		$fb_login_uri = (string)$fb->getAuthorizationUri();
		$instagram_login_uri = (string)$instagram->getAuthorizationUri();

		return View::make('auth.login')
			->with('fb_login_uri', $fb_login_uri)
			->with('instagram_login_uri', $instagram_login_uri);
	}

	public function signin(){
        $signin = new \App\Lib\Registration('signin', 'email');

        if($signin->execute() == true){
        	return Redirect::to('/')
        		->withMessages('Logged in!');
        }else{
			return View::make('auth.login')
				->withErrors(array('login' => $signin->errors))
				->withInput(Input::except('password'));
        }
	}

	public function facebook_signin(){
		$signin = new \App\Lib\Registration('signin', 'facebook');

		if($signin->execute() === true){
			return Redirect::to('/')
        		->withMessages('Logged in!');
		}elseif($signin->status == 'not-found'){
			return Redirect::to('/login/facebook/confirm');
		}else{
			dd($signin->errors);
		}
	}

	public function instagram_signin(){
		$signin = new \App\Lib\Registration('signin', 'instagram');

		if($signin->execute() === true){
			return Redirect::to('/')
        		->withMessages('Logged in!');
		}elseif($signin->status == 'not-found'){
			return Redirect::to('/login/instagram/confirm');
		}else{
			dd($signin->errors);
		}
	}
}