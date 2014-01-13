<?php
namespace App\Controllers\Profile;

use App\Models\Picture as PictureModel;
use App\Models\Follow as FollowModel;

/*
 * IndexController
 */
class IndexController extends \Controller
{
	public function home($username){
		$profile = \Sentry::findUserByLogin($username);

		$pictures = PictureModel::with('user')
			->where('user_id', $profile->id)
			->get();

		return \View::make('profile.home')
			->withPictures($pictures)
			->withProfile($profile)
			->with('user_data', \Sentry::getUser());
	}

	public function follow()
	{
		//set a default failure status
		$ret = array(
			'status' => false, 
			'message' => \Lang::get('profile.follow.failure'),
		);

		//if there is no picture id posted, do nothing
		if(\Input::has('user_id')){
			$follower = \Sentry::getUser();

			//if there is no logged in user, do nothing and return unauthorized message
			if (!$follower) {
				$ret['message'] = \Lang::get('profile.follow.unauthorized');
				return \Response::json($ret);
			}
			
			//find the user we're trying to add a follower to
			$followed = \Sentry::findUserById(\Input::get('user_id'));

			//check if the user has already been followed by the follower
			if($follower->hasFollowed($followed->id)){
				$ret['message'] = \Lang::get(
					'profile.follow.already_followed', 
					array('name' => $followed->username)
				);
				return \Response::json($ret);
			}

			//if everything's okay, attempt to save the follow in the db
			$follow = FollowModel::create(array(
				'follower_id' 	=> $follower->id,
				'user_id' 		=> $followed->id,
			));

			//if the follow is inserted in the db, create success message
			if ($follow) {
				$ret['status'] = true;
				$ret['message'] = \Lang::get(
					'profile.follow.success', 
					array('name' => $followed->username)
				);
			}
		}

		//send the json response
		return \Response::json($ret);
	}

	public function unfollow()
	{
		//set a default failure status
		$ret = array(
			'status' => false, 
			'message' => \Lang::get('profile.unfollow.failure'),
		);

		//if there is no picture id posted, do nothing
		if(\Input::has('user_id')){
			$follower = \Sentry::getUser();

			//if there is no logged in user, do nothing and return unauthorized message
			if (!$follower) {
				$ret['message'] = \Lang::get('profile.unfollow.unauthorized');
				return \Response::json($ret);
			}
			
			//find the user we're trying to add a follower to
			$followed = \Sentry::findUserById(\Input::get('user_id'));

			//check if the user has already been followed by the follower
			$has_followed = $follower->hasFollowed($followed->id);
			if(!$has_followed){
				$ret['message'] = \Lang::get(
					'profile.unfollow.not_followed', 
					array('name' => $followed->username)
				);
				return \Response::json($ret);
			}

			//if everything's okay, attempt to remove the follow entry from the db
			//if the follow entry is inserted in the db, create success message
			$has_followed->delete();

			$ret['status'] = true;
			$ret['message'] = \Lang::get(
				'profile.unfollow.success', 
				array('name' => $followed->username)
			);
		}

		//send the json response
		return \Response::json($ret);
	}

	//single photo controller method
	public function picture($username, $id){
		$picture = PictureModel::with('user')->whereId($id)->first();

		return \View::make('profile.photo')
			->withPicture($picture)
			->with('user_data', \Sentry::getUser());
	}
}