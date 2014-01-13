<?php
namespace App\Lib\Social;

use \Sentry;

/**
* Social Provider Library 
* @author Foysal Ahamed
*/
class SocialProvider
{
	public $provider;
	
	function __construct($service_name) 
	{
		if($this->userHasProvider($service_name)) {
			switch ($service_name) {
				case 'facebook':
					$this->provider = new \App\Lib\Social\Facebook\Facebook();
					break;

				case 'instagram':
					$this->provider = new \App\Lib\Social\Instagram\Instagram();
					break;
				
				default:
					$this->provider = new \App\Lib\Social\Facebook\Facebook();
					break;
			}
		}
	}

	public function userHasProvider($service_name)
	{
		$user = Sentry::getUser();

		if(!$user || $user->provider != $service_name){
			throw new ProviderNotConnectedException("User has not connected with ".$service_name, 1);
			return false;
		}

		return true;
	}
}