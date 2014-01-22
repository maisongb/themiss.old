<?php
namespace App\Lib\Social\Instagram;

use \OAuth;
use \Session;
use \OAuth\OAuth2\Token\StdOAuth2Token;
use \App\Lib\Social\AbstractSocial;
use \App\Lib\Social\SocialInterface;

/**
* Instagram Library 
* @author Foysal Ahamed
*/
class Instagram extends AbstractSocial implements SocialInterface
{
	public $service_name = 'Instagram';
	public $token_session_name = 'token.instagram';

	/*
	 * gets all the photo albums from the instagram user and returns the array
	 *
	 */
	public function getPhotos()
	{
		$this->checkToken();
		$request_uri = 'users/'. $this->profile->user->instagram_id .'/media/recent';
		//dd($this->profile->user->id);
		return json_decode($this->service->request($request_uri), true);
	}
}