<?php
namespace App\Lib\Social;

use \OAuth;
use \OAuth\OAuth2\Token\StdOAuth2Token;
use \Sentry;
use \Session;
use \App\Lib\Social\SocialInterface;
use \App\Lib\Social\NoTokenException;

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
		$this->service = OAuth::consumer($this->service_name);
		$this->checkToken();
	}

	//checks for access token in the session
	public function userHasToken() 
	{
		return strlen($this->profile->user->access_token) > 0;
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

		if($this->userHasToken()) {
			$this->resetToken();
			return true;
		}

		throw new NoTokenException("Seems Like we need a new token for the user", 1);
		return false;
	}

	/*
	 * this method resets the service provider's access token
	 * @var token is a string that can be set from outside
	 */
	public function resetToken($token = null) 
	{
		$token = $token ? $token : $this->profile->user->access_token;

		$this->service
			->getStorage()
			->storeAccessToken($this->service_name, new StdOAuth2Token($token));
	}
}