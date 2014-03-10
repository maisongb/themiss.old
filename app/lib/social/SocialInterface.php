<?php
namespace App\Lib\Social;

/**
* Facebook Library 
* @author Foysal Ahamed
*/
interface SocialInterface
{
	/*
	 * this method checks if there's a token set in the session
	 * if no, then it tries to resets the token of the service provider
	 * on failure, it will throw a notoken exception
	 * @var token is a string that can be set from outside
	 */
	public function checkToken();

	/*
	 * this method resets the service provider's access token
	 * @var token is a string that can be set from outside
	 */
	public function resetToken($token = null);

	/*
	 * this method return config value of the passed param
	 * @param item string
	 * @return string/array
	 */
	public function getConfig($item = '');
}