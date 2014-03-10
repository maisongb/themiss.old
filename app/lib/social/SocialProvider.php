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
		
		switch ($service_name) {
			case 'facebook':
				$this->provider = new Facebook\Facebook($this->profile);
				break;

			case 'instagram':
				$this->provider = new Instagram\Instagram($this->profile);
				break;
			
			default:
				$this->provider = new Facebook\Facebook($this->profile);
				break;
		}
	}
}