<?php
namespace App\Controllers\Profile;

use App\Models\User;
use App\Lib\Profile\ProfileFactory;
use App\Lib\Exceptions as AppException;

/*
 * SearchController
 */
class SearchController extends \Controller
{
	public function results(){
		if(\Input::has('username')){
			$profile = User::where('username', 'like', '%' .\Input::get('username'). '%');
		}

		if(isset($profile) && !empty($profile)){
			return $profile->take(10)
				->get(array('id', 'first_name', 'last_name', 'username'));
		}
	}
}