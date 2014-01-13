<?php
namespace App\Lib\Social\Facebook;

use \OAuth;
use \Session;
use \OAuth\OAuth2\Token\StdOAuth2Token;
use \App\Lib\Social\AbstractSocial;
use \App\Lib\Social\SocialInterface;

/**
* Facebook Library 
* @author Foysal Ahamed
*/
class Facebook extends AbstractSocial
{
	public $service_name = 'Facebook';
	public $token_session_name = 'token.facebook';

	/*
	 * gets all the photo albums from the facebook user and returns the array
	 *
	 */
	public function getAlbums()
	{
		return json_decode($this->service->request('/me/albums'), true);
	}

	/*
	 * gets all the photo albums from the facebook user and returns the array
	 *
	 */
	public function getPhotos($album_id, $limit = 30)
	{
		$request_uri = '/' .$album_id. '/photos?limit='. $limit;
		return json_decode($this->service->request($request_uri), true);
	}

	/*
	 * likes a photo on user's behalf
	 */
	public function likePicture($url)
	{
		$like = $this->service->request('/me/og.likes?object='. $url);
		dd(json_decode($like));
	}
}