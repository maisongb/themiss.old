<?php
namespace App\Lib\Social;

/**
* Social Provider Library 
* @author Foysal Ahamed
*/
class SocialProvider
{
	public $provider;
	
	function __construct($service_name) 
	{
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