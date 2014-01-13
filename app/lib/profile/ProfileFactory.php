<?php
namespace App\Lib\Profile;

use App\Models\Picture as PictureModel;
use App\Models\Vote as VoteModel;
use App\Models\User as UserModel;
use App\Lib\Exceptions as AppException;

/**
* @author Foysal Ahamed
* @package user profile factory package for the app 
* @param 
*/
class ProfileFactory
{
	protected $user;

	public function __construct($user = false)
	{
		if(!$user) throw new AppException\NotLoggedInException;
		$this->user = $user;
	}

	public function hasFollowed($user)
	{
		$follower_id = (is_int($this->user)) ? $this->user : $this->user->id;
		return UserModel::alreadyFollowed($follower_id, $user)->first();
	}
}