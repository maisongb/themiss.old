<?php
namespace App\Lib\Auth;

use \Sentry;
use \Session;
use \Input;

/**
* Registration Library 
* @author Foysal Ahamed
*/
class Registration
{
	private $provider;
	public $status;
	public $errors;
	public $group;

	function __construct($provider)
	{
		$available_providers = array('facebook', 'instagram', 'email');

		if(!in_array($provider, $available_providers))
			throw new \RuntimeException("Oops, the provider isn't compatible!");	

		$this->status = null;
		$this->provider = $provider;
		$this->group = Sentry::findGroupByName('male');
	}


	/*
	 * @execute method
	 * this method traverse through available data and compiles data structre for login process
	 * then calls the login_with_email() method to complete the login process
	 */
	public function execute()
	{
		if($this->provider == 'email'){
			$credentials = $this->withEmail();
	    }elseif ($this->provider == 'facebook') {
	    	//if it's a facebook login, then
	    	$credentials = $this->withFacebook();

	    	if($credentials == false)
	    		return false;
	    }elseif($this->provider == 'instagram'){
	    	//if it's an instagram login, then
	    	$credentials = $this->withInstagram();

	    	if($credentials == false)
	    		return false;
	    }

		return $this->signup($credentials);
	}

	public function withEmail()
	{
		return array(
	        'first_name'    => Input::has('first_name') ? Input::get('first_name') : null,
	        'last_name'    	=> Input::has('last_name') ? Input::get('last_name') : null,
	        'email'    		=> Input::has('email') ? Input::get('email') : null,
	        'username'    	=> Input::has('username') ? Input::get('username') : null,
	        'password' 		=> Input::has('password') ? Input::get('password') : null,
	    );
	}

	public function withInstagram()
	{
		if(Session::has('instagram.profile')){
			$profile 	= Session::get('instagram.profile');
			$full_name 	= explode(' ', $profile['full_name']);

			return array(
		        'first_name'    => isset($full_name[0]) ? $full_name[0] : null,
		        'last_name'    	=> isset($full_name[1]) ? $full_name[1] : null,
		        'username'    	=> isset($profile['username']) ? $profile['username'] : null,
		        'password' 		=> $profile['id'].$profile['username'],
		        'instagram_id'	=> $profile['id'],
		    );
		}
	}

	public function withFacebook()
	{
		if(Session::has('facebook.profile')){
			$profile = Session::get('facebook.profile');

			if(isset($profile['gender'])){
				$this->group = Sentry::findGroupByName($profile['gender']);
			}

			return array(
		        'first_name'    => isset($profile['first_name']) ? $profile['first_name'] : null,
		        'last_name'    	=> isset($profile['last_name']) ? $profile['last_name'] : null,
		        'username'    	=> isset($profile['username']) ? $profile['username'] : null,
		        'email'    		=> isset($profile['email']) ? $profile['email'] : null,
		        'password' 		=> $profile['id'].$profile['username'],
		        'facebook_id'	=> $profile['id'],
		    );
		}
	} 

	/*
	 * @register method
	 * this method traverse through available data and compiles data structre for signup process
	 * then calls the register_with_email() method to complete the registration process
	 */
	private function signup($data)
	{
		try{
		    // Let's register a user.
		    $data['provider'] = $this->provider;
		    $user = Sentry::register($data, true);

		    //assign a group to the user
		    $user->addGroup($this->group);
		    return true;
		}catch (\Cartalyst\Sentry\Users\LoginRequiredException $e){
		    $error = 'Login field is required.';
		}catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e){
		    $error = 'Password field is required.';
		}catch (\Cartalyst\Sentry\Users\UserExistsException $e){
		    $error = 'User with this login already exists.';
		}

		$this->errors = $error;
		return false;
	}
}
