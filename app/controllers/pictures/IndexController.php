<?php
namespace App\Controllers\Pictures;

use \App\Lib\Picture\PictureFactory;
use \App\Lib\Exceptions as AppException;

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
			try{
				$vote = new PictureFactory(\Input::get('picture_id'));
				$vote->addVote(\Sentry::getUser());
				
				$ret['status'] = true;
				$ret['message'] = \Lang::get('pictures.vote.add.success');
			}catch(AppException\ActionUnauthorizedException $e){
				$ret['message'] = \Lang::get('pictures.vote.add.unauthorized');
			}catch(AppException\ActionAlreadyDoneException $e){
				$ret['message'] = \Lang::get('pictures.vote.add.already_voted');
			}catch(AppException\ActionTechnicalException $e){}
		}

		//send the json response
		return \Response::json($ret);
	}
}