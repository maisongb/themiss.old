<?php
namespace App\Lib\Auth;

use \Sentry;
use \Session;
use \Input;

/**
* Login Library 
* @author Foysal Ahamed
*/
class Login{
	private $provider;
	public $status;
	public $errors;

	function __construct($provider){
		$available_providers = array('facebook', 'instagram', 'email');
		
		if(!in_array($provider, $available_providers))
			throw new \RuntimeException("Oops, the provider isn't compatible!");	

		$this->status = null;
		$this->provider = $provider;
	}

	/*
	 * @execute method
	 * this method traverse through available data and compiles data structre for login process
	 * then calls the login_with_email() method to complete the login process
	 */
	public function execute(){
		if($this->provider == 'email'){
			$credentials = array(
	            'username'  => Input::has('username') ? Input::get('username') : null,
	            'password'	=> Input::has('password') ? Input::get('password') : null,
	        );
	        $remember = Input::has('remember_me') and Input::get('remember_me') == 'checked';
	    }elseif ($this->provider == 'facebook') {
	    	//if it's a facebook login, then
	    	$credentials = $this->withFacebook();

	    	if($credentials == false)
	    		return false;

	    	$remember = true;
	    }elseif($this->provider == 'instagram'){
	    	//if it's an instagram login, then
	    	$credentials = $this->withInstagram();

	    	if($credentials == false)
	    		return false;

	    	$remember = true;
	    }

	    if(Session::has('connect_social')){
	    	$this->status = 'connect-social';
	    	return false;
	    }

		return $this->signin($credentials, $remember);
	}

	public function withInstagram(){
		if(!Input::has('code')){
    		$this->errors = 'Instagram Response Error!';
    		return false;
    	}

    	$instagram = \OAuth::consumer('Instagram');
		$token = $instagram->requestAccessToken(Input::get('code'));

		$userdata = json_decode($instagram->request('users/self'), true);

    	if(empty($userdata['data'])){
    		$this->errors = 'Instagram Response Error!';
    		return false;
    	}

    	$this->instagram_token = $token->getAccessToken();
    	$userdata['data']['instagram_token'] = $this->instagram_token;
		Session::put('instagram.profile', $userdata['data']);

    	return array(
    		//instagram doesnt allow email address
    		//to strengthen the password we will join the id and username together
    		'username' => $userdata['data']['username'],
    		'password' => $userdata['data']['id'].$userdata['data']['username'],
    	);
	}

	public function withFacebook(){
		if(!Input::has('code')){
    		$this->errors = 'Facebook Response Error!';
    		return false;
    	}

    	$facebook = \OAuth::consumer('Facebook');
		$token = $facebook->requestAccessToken(Input::get('code'));

		$userdata = json_decode($facebook->request('/me'), true);

    	if(empty($userdata)){
    		$this->errors = 'Facebook Response Error!';
    		return false;
    	}

    	$this->facebook_token = $token->getAccessToken();
    	$userdata['facebook_token'] = $this->facebook_token;
		Session::put('facebook.profile', $userdata);

    	return array(
    		'username' => $userdata['username'],
    		'password' => $userdata['id'].$userdata['username'],
    	);
	} 

	/*
	 * @signin method
	 * this method uses sentry to call the authentication and login method
	 * and returns related value upon completion with success or error
	 * error messages get set by the classes $errors @param
	 */
	private function signin($credentials, $remember){
		try{
	        // Log the user in
	        $user = Sentry::authenticate($credentials, $remember);

	        if(isset($this->facebook_token) && !empty($this->facebook_token)){
	        	$user->facebook_token = $this->facebook_token;
	        }elseif(isset($this->instagram_token) && !empty($this->instagram_token)){
	        	$user->instagram_token = $this->instagram_token;
	        }
	        $user->save();

	        return true;
	    }catch (\Cartalyst\Sentry\Users\LoginRequiredException $e){
			$error = 'Login field is required.';
		}catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e){
			$error = 'Password field is required.';
		}catch (\Cartalyst\Sentry\Users\WrongPasswordException $e){
			$error = 'Wrong password, try again.';
		}catch (\Cartalyst\Sentry\Users\UserNotFoundException $e){
			$error = 'User was not found.';
			$this->status = 'not-found';
		}catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e){
			$error = 'User is not activated.';
		}catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e){
			$error = 'User is suspended.';
		}catch (\Cartalyst\Sentry\Throttling\UserBannedException $e){
			$error = 'User is banned.';
		}catch(\Exception $e){
			$error = $e->getMessage();
		}

		$this->errors = $error;
		return false;
	}
}
