<?php
namespace App\Controllers\Profile;

use App\Models\Picture as PictureModel;
use App\Models\Follow as FollowModel;
use App\Lib\Profile\ProfileFactory;
use App\Lib\Exceptions as AppException;

/*
 * IndexController
 */
class IndexController extends \Controller
{
	public function home($username){
		$profile = new ProfileFactory(\Sentry::findUserByLogin($username));

		return \View::make('profile.home')
			->withPictures($profile->getPictures())
			->withProfile($profile)
			->with('user_data', new ProfileFactory(\Sentry::getUser()));
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
			try{
				$follower = new ProfileFactory(\Sentry::getUser());
				$followed = \Sentry::findUserById(\Input::get('user_id'));

				$follower->startFollowing($followed);

				$ret['status'] = true;
				$ret['message'] = \Lang::get(
					'profile.follow.success', 
					array('name' => $followed->username)
				);
			}catch(AppException\ActionUnauthorizedException $e){
				//if there is no logged in user, do nothing and return unauthorized message
				$ret['message'] = \Lang::get('profile.follow.unauthorized');
			}catch(AppException\ActionAlreadyDoneException $e){
				//check if the user has already been followed by the follower
				$ret['message'] = \Lang::get(
					'profile.follow.already_followed', 
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
			try{
				$follower = new ProfileFactory(\Sentry::getUser());
				//find the user we're trying to add a follower to
				$followed = \Sentry::findUserById(\Input::get('user_id'));

				$follower->stopFollowing($followed);

				$ret['status'] = true;
				$ret['message'] = \Lang::get(
					'profile.unfollow.success', 
					array('name' => $followed->username)
				);
			}catch(AppException\ActionUnauthorizedException $e){
				//if there is no logged in user, do nothing and return unauthorized message
				$ret['message'] = \Lang::get('profile.unfollow.unauthorized');
			}catch(AppException\ActionAlreadyDoneException $e){
				//check if the user has already been followed by the follower
				$ret['message'] = \Lang::get(
					'profile.unfollow.not_followed', 
					array('name' => $followed->username)
				);
			}
		}

		//send the json response
		return \Response::json($ret);
	}

	//single photo controller method
	public function picture($username, $id){
		$picture = PictureModel::whereId($id)->first();

		return \View::make('profile.photo')
			->withPicture($picture)
			->withProfile(new ProfileFactory(\Sentry::findUserByLogin($username)))
			->with('user_data', new ProfileFactory(\Sentry::getUser()));
	}
}