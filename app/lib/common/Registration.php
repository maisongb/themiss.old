<?php
namespace App\Lib;
use \Sentry;
use \Session;
use \Input;

/**
* Registration Library 
* @author Foysal Ahamed
*/
class Registration{
	private $action;
	private $provider;
	public $status;
	public $errors;

	function __construct($do, $provider){
		$available_actions = array('signin', 'signup');
		$available_providers = array('facebook', 'instagram', 'email');

		if(!in_array($do, $available_actions))
			throw new \RuntimeException("Oops, the action doesn't exist in the class!");	

		if(!in_array($provider, $available_providers))
			throw new \RuntimeException("Oops, the provider isn't compatible!");	

		$this->status = null;
		$this->action = $do;
		$this->provider = $provider;
	}

	public function execute(){
		switch ($this->action) {
			case 'signin':
				return $this->login();
				break;
			
			case 'signup':
				return $this->register();
				break;
			default:
				
				break;
		}
	}

	/*
	 * @login method
	 * this method traverse through available data and compiles data structre for login process
	 * then calls the login_with_email() method to complete the login process
	 */
	private function login(){
		if($this->provider == 'email'){
			$credentials = array(
	            'email'    => Input::has('email') ? Input::get('email') : null,
	            'password' => Input::has('password') ? Input::get('password') : null,
	        );
	        $remember = Input::has('remember_me') and Input::get('remember_me') == 'checked';
	    }elseif ($this->provider == 'facebook') {
	    	//if it's a facebook login, then
	    	if(!Input::has('code')){
	    		$this->errors = 'Facebook Response Error!';
	    		return false;
	    	}

	    	$facebook = \OAuth::consumer('Facebook');
			$token = $facebook->requestAccessToken(Input::get('code'));

			$token_str = $token->getAccessToken();

			$userdata = json_decode($facebook->request('/me'), true);

	    	if(empty($userdata)){
	    		$this->errors = 'Facebook Response Error!';
	    		return false;
	    	}

			Session::put('token.facebook', $token_str);
			Session::put('facebook.profile', $userdata);
			Session::save();

	    	$credentials = array(
	    		'email' => $userdata['email'],
	    		'password' => $userdata['id']
	    	);
	    	$remember = true;
	    }

		return $this->login_with_email($credentials, $remember);
	}

	/*
	 * @login_with_email method
	 * this method uses sentry to call the authentication and login method
	 * and returns related value upon completion with success or error
	 * error messages get set by the classes $errors @param
	 */
	private function login_with_email($credentials, $remember){
		try{
	        // Log the user in
	        $user = Sentry::authenticate($credentials, $remember);
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

	/*
	 * @login method
	 * this method traverse through available data and compiles data structre for signup process
	 * then calls the register_with_email() method to complete the registration process
	 */
	private function register(){
		if($this->provider == 'email'){
			$userdata = array(
		        'first_name'    => Input::has('first_name') ? Input::get('first_name') : null,
		        'last_name'    	=> Input::has('last_name') ? Input::get('last_name') : null,
		        'email'    		=> Input::has('email') ? Input::get('email') : null,
		        'password' 		=> Input::has('password') ? Input::get('password') : null,
		    );
		}elseif($this->provider == 'facebook'){
			if(Session::has('facebook.profile')){
				$profile = Session::get('facebook.profile');

				$userdata = array(
			        'first_name'    => isset($profile['first_name']) ? $profile['first_name'] : null,
			        'last_name'    	=> isset($profile['last_name']) ? $profile['last_name'] : null,
			        'email'    		=> isset($profile['email']) ? $profile['email'] : null,
			        'password' 		=> $profile['id'],
			    );
			}
		}

		return $this->register_with_email($userdata);
	}

	private function register_with_email($data){
		try{
		    // Let's register a user.
		    $user = Sentry::register($data, true);
		    return true;
		}catch (Cartalyst\Sentry\Users\LoginRequiredException $e){
		    $error = 'Login field is required.';
		}catch (Cartalyst\Sentry\Users\PasswordRequiredException $e){
		    $error = 'Password field is required.';
		}catch (Cartalyst\Sentry\Users\UserExistsException $e){
		    $error = 'User with this login already exists.';
		}

		$this->errors = $error;
		return false;
	}
}
