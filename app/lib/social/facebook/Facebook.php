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
		if(!$this->alreadyLikedPicture($url)){
			try{
				$post_url = '/me/og.likes?access_token='. $this->user->access_token .'&profile='. $url .'.ogp.me%2F390580850990722';
				$like = json_decode($this->service->request($post_url, 'POST'));
				return $like->data;
			}catch(OAuth\Common\Http\Exception\TokenResponseException $e){
				return false;
			}
		}

		return false;
	}

	/*
	 * checks if a given url is already liked by the logged in user
	 */
	public function alreadyLikedPicture($url)
	{
		$already_liked = json_decode($this->service->request('/me/og.likes?profile='. $url));
		return !empty($already_liked->data);
	}
}