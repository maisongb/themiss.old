<?php
namespace App\Controllers\Auth;

use App\Lib\Auth\ConnectSocial;

/*
 * ConnectController
 */
class ConnectSocialController extends \Controller 
{
	public function facebook()
	{
		$connection = new ConnectSocial('facebook');

		if($connection->execute()){
			//connection established
			dd($connection);

		}else{
			//something went wrong
		}
	}
}