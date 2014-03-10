<?php
namespace App\Lib\Social;

use \OAuth;
use \OAuth\OAuth2\Token\StdOAuth2Token;
use \Sentry;
use \Session;
use App\Lib\Exceptions as AppExceptions;

/**
* Facebook Library 
* @author Foysal Ahamed
*/
abstract class AbstractSocial implements SocialInterface
{
	public $service_name;
	public $service;
	public $profile;

	function __construct($profile) 
	{
		$this->profile = $profile;
		$this->service = OAuth::consumer($this->service_name, $this->getConfig('return'));
		$this->auth_uri = (string)$this->service->getAuthorizationUri();
	}

	/*
	 * this method checks if there's a token set in the session
	 * if no, then it tries to resets the token of the service provider
	 * on failure, it will throw a notoken exception
	 * @var token is a string that can be set from outside
	 */
	public function checkToken() 
	{
		if($this->service->getStorage()->hasAccessToken($this->service_name)) 
			return true;

		if($this->profile->hasProvider($this->service_name)) {
			$this->resetToken();
			return true;
		}

		throw new AppExceptions\NoTokenException("Seems Like we need a new token for the user", 1);
	}

	/*
	 * this method resets the service provider's access token
	 * @var token is a string that can be set from outside
	 */
	public function resetToken($token = null) 
	{
		$u_p = strtolower($this->service_name).'_token';
		$token = $token ? $token : $this->profile->user->$u_p;

		$this->service
			->getStorage()
			->storeAccessToken($this->service_name, new StdOAuth2Token($token));
	}

	/*
	 * this method return config value of the passed param
	 * @param item string
	 * @return string/array
	 */
	public function getConfig($item = '')
	{
		if(empty($item)) return false;

		$c = \Config::get(strtolower($this->service_name));
		return $c[$item];
	}
}