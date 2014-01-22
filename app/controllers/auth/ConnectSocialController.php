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
			$goto = \Session::get('was_here');
			\Session::forget('was_here');
			return \Redirect::route($goto, array('username' => $connection->username));

		}else{
			//something went wrong
		}
	}
}