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
			$connection->clearSessions();

			return \Redirect::route($goto, array('username' => $connection->data['username']));

		}else{
			//something went wrong
		}
	}
	public function instagram()
	{
		$connection = new ConnectSocial('instagram');

		if($connection->execute()){
			//connection established
			$goto = \Session::get('was_here');
			$connection->clearSessions();

			return \Redirect::route($goto, array('username' => $connection->data['username']));

		}else{
			dd($connection);
			//something went wrong
		}
	}
}