<?php
namespace App\Controllers\Pictures;

use \App\Models\Picture;
use \App\Models\Vote;

/*
 * IndexController
 */
class IndexController extends \Controller
{
	public function addVote()
	{
		//set a default failure status
		$ret = array(
			'status' => false, 
			'message' => \Lang::get('pictures.vote.add.failure'),
		);

		//if there is no picture id posted, do nothing
		if(\Input::has('picture_id')){
			$user = \Sentry::getUser();

			//if there is no logged in user, do nothing and return unauthorized message
			if (!$user) {
				$ret['message'] = \Lang::get('pictures.vote.add.unauthorized');
				return \Response::json($ret);
			}

			//if everything's okay, attempt to save the vote in the db
			$vote = Vote::create(array(
				'voter_id' 		=> $user->id,
				'picture_id' 	=> \Input::get('picture_id'),
			));

			//if the vote is inserted in the db, create success message
			if ($vote) {
				$ret['status'] = true;
				$ret['message'] = \Lang::get('pictures.vote.add.success');
			}
		}

		//send the json response
		return \Response::json($ret);
	}
}