<?php
namespace App\Lib\Profile;

use App\Models\Picture as PictureModel;
use App\Models\Vote as VoteModel;
use App\Models\User as UserModel;
use App\Models\Follow as FollowModel;
use App\Lib\Exceptions as AppException;

/**
* @author Foysal Ahamed
* @package user profile factory package for the app 
* @param 
*/
class ProfileFactory
{
	public $user;

	public function __construct($user = false)
	{
		if(!$user) throw new AppException\NotLoggedInException;
		$this->user = $user;
	}

	/*
	 * @return a user object if followed, null otherwise
	 */
	public function hasFollowed($user)
	{
		$follower_id = (is_int($this->user)) ? $this->user : $this->user->id;

		//if accidentally, users try to follow themselves, not yet sure what to do
		if($follower_id == $user)

		return FollowModel::userFollows($follower_id, $user)->first();
	}

	/*
	 * adds a new follower to a user
	 * @param follower - a user object to identify the user
	 */
	public function startFollowing($user)
	{
		//if there is no user passed in to follow, do nothing and return unauthorized message
		if(!$user) throw new AppException\ActionUnauthorizedException('cant find the user to follow!');
		
		if($this->hasFollowed($user->id))
			throw new AppException\ActionAlreadyDoneException;

		//if everything's okay, attempt to save the follow in the db
		$follower_id = (is_int($this->user)) ? $this->user : $this->user->id;
		$follow = FollowModel::create(array(
			'follower_id' 	=> $follower_id,
			'user_id'		=> $user->id,
		));

		//if the follow is inserted in the db, create success message
		if ($follow) return true;

		throw new AppException\ActionTechnicalException('There was a technical error');
		return false;
	}


	/*
	 * adds a new follower to a user
	 * @param follower - a user object to identify the user
	 */
	public function stopFollowing($user)
	{
		//if there is no user passed in to follow, do nothing and return unauthorized message
		if(!$user) throw new AppException\ActionUnauthorizedException('cant find the user to follow!');

		$follow = $this->hasFollowed($user->id);
		if(!$follow)
			throw new AppException\ActionAlreadyDoneException;

		//if everything's okay, attempt to remove the follow entry from the db
		//if the follow entry is inserted in the db, create success message
		if ($follow->delete()) return true;

		throw new AppException\ActionTechnicalException('There was a technical error');
		return false;
	}

	/*
	 * @params -
	 * $from - where to start the select from
	 * $total - total # of pictures to get
	 * $voted - true if only the voted pictures are to be fetched
	 * $orderby - which parameter to be used for ordering the pictures
	 * gets all the pictures of a profile and paginates them
	 */
	public function getPictures($params = array())
	{
		if(array_get($params, 'voted')){
			$pictures = $this->user->votes();
		}else{
			$pictures = PictureModel::where('user_id', $this->user->id);
		}

		return $pictures
			->skip(array_get($params, 'from', 0))
			->take(array_get($params, 'total', 10))
			->get();
	}

	/*
	 * @params - $provider - name of the social provider to check
	 * checks if a user is connected to a social provider
	 */
	public function hasProvider($provider)
	{
		$u_p = strtolower($provider).'_token';
		//if the token is a string that means user is connected
		return strlen($this->user->$u_p) > 0;
	}
}