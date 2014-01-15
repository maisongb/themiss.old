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
	public $profile;
	
	function __construct($profile, $service_name) 
	{
		$this->profile = $profile;
		
		if(!$this->profile->hasProvider($service_name))
			throw new ProviderNotConnectedException("User has not connected with ".$service_name, 1);
			
		switch ($service_name) {
			case 'facebook':
				$this->provider = new \App\Lib\Social\Facebook\Facebook($profile);
				break;

			case 'instagram':
				$this->provider = new \App\Lib\Social\Instagram\Instagram($profile);
				break;
			
			default:
				$this->provider = new \App\Lib\Social\Facebook\Facebook($profile);
				break;
		}
	}
}