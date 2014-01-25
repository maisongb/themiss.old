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
	public $data;

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
		if(\Session::has('instagram.profile')){
			$profile 	= \Session::get('instagram.profile');
			$this->data = array(
		        'instagram_id'		=> $profile['id'],
		        'instagram_token'	=> $profile['instagram_token'],
		    );

			\Session::forget('instagram.profile');
		    return true;
		}

    	return false;
	}

	public function withFacebook(){
		if(\Session::has('facebook.profile')){
			$profile 	= \Session::get('facebook.profile');
			$this->data = array(
		        'facebook_id'	=> $profile['id'],
		        'facebook_token'	=> $profile['facebook_token'],
		    );

			\Session::forget('facebook.profile');
		    return true;
		}

    	return false;
	} 

	/*
	 * @connect method
	 * this method puts the access token of the social provider in the users table
	 * and returns related value upon completion with success or error
	 */
	private function connect(){
		$user = \Sentry::getUser();

		if(isset($this->data['facebook_token'])){
			$user->facebook_token = $this->data['facebook_token'];

			if(strlen($user->facebook_id) > 0) 
				$user->facebook_id = $this->data['facebook_id'];
		}elseif(isset($this->data['instagram_token'])){
			$user->instagram_token = $this->data['instagram_token'];
			if(strlen($user->instagram_id) > 0) 
				$user->instagram_id = $this->data['instagram_id'];
		}else{
			return false;
		}

		$user->save();
		$this->data['username'] = $user->username;
		return true;
	}

	/*
	 * @clearSession method
	 * this removes all the session vars related to social connect
	 */
	public function clearSessions()
	{
		$ses = array('connect_social', 'was_here');
		foreach ($ses as $s) {
			\Session::forget($s);
		}
	}
}
