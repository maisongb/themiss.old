<?php
namespace App\Lib\Auth;

/**
* Login Library 
* @author Foysal Ahamed
*/
class ConnectSocial{
	private $provider;
	public $status;
	public $errors;

	function __construct($provider){
		$available_providers = array('facebook', 'instagram');
		
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
		if ($this->provider == 'facebook') {
	    	//if it's a facebook connection, then
	    	if($this->withFacebook() == false) return false;
	    }elseif($this->provider == 'instagram'){
	    	//if it's an instagram connection, then
	    	if($this->withInstagram() == false) return false;
	    }

		return $this->connect();
	}

	public function withInstagram(){
		if(!\Input::has('code')){
    		$this->errors = 'Instagram Response Error!';
    		return false;
    	}

    	$instagram = \OAuth::consumer('Instagram');
		$token = $instagram->requestAccessToken(\Input::get('code'));

		$userdata = json_decode($instagram->request('users/self'), true);

    	if(empty($userdata['data'])){
    		$this->errors = 'Instagram Response Error!';
    		return false;
    	}

    	$this->instagram_token = $token->getAccessToken();
    	$this->instagram_id = $userdata['id'];

    	return true;
	}

	public function withFacebook(){
		if(!\Input::has('code')){
    		$this->errors = 'Facebook Response Error!';
    		return false;
    	}

    	$facebook = \OAuth::consumer('Facebook');
		$token = $facebook->requestAccessToken(\Input::get('code'));

		$userdata = json_decode($facebook->request('/me'), true);

    	if(empty($userdata)){
    		$this->errors = 'Facebook Response Error!';
    		return false;
    	}

    	$this->facebook_token = $token->getAccessToken();
    	$this->facebook_id = $userdata['id'];

    	return true;
	} 

	/*
	 * @connect method
	 * this method puts the access token of the social provider in the users table
	 * and returns related value upon completion with success or error
	 */
	private function connect(){
		$user = \Sentry::getUser();

		if(isset($this->facebook_token) && !empty($this->facebook_token)){
			$user->facebook_token = $this->facebook_token;

			if(strlen($user->facebook_id) > 0) $user->facebook_id = $this->facebook_id;
		}elseif(isset($this->instagram_token) && !empty($this->instagram_token)){
			$user->instagram_token = $this->instagram_token;
			if(strlen($user->instagram_id) > 0) $user->instagram_id = $this->instagram_id;
		}else{
			return false;
		}

		$user->save();
		$this->username = $user->username;
		return true;
	}
}
