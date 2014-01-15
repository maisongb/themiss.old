<?php
namespace App\Lib\Picture;

use App\Models\Picture as PictureModel;
use App\Models\Vote as VoteModel;
use App\Lib\Exceptions as AppException;

/**
* @author Foysal Ahamed
* @package picture factory package for the app 
* @param 
*/
class PictureFactory
{
	protected $pic;

	public function __construct($picture = false)
	{
		$this->pic = $picture;
	}

	/*
	 * adds a new vote for a picture
	 * @param voter - a user object to identify the user
	 */
	public function addVote($voter = null)
	{
		//if there is no logged in user, do nothing and return unauthorized message
		if(!$voter) throw new AppException\ActionUnauthorizedException('User Not Logged in!');
		if(!$this->pic) throw new AppException\ActionUnauthorizedException("Action is Not permitted for this object");
		
		if(VoteModel::alreadyLiked($voter->id, $this->pic)->first())
			throw new AppException\ActionAlreadyDoneException;
			

		//if everything's okay, attempt to save the vote in the db
		$vote = VoteModel::create(array(
			'voter_id' 		=> $voter->id,
			'picture_id' 	=> $this->pic,
		));

		//if the vote is inserted in the db, create success message
		if ($vote) return true;

		throw new AppException\ActionTechnicalException('There was a technical error');
		return false;
	}
}