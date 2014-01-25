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
	public $pic;

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
		
		if(VoteModel::alreadyLiked($voter->id, $this->pic->id)->first())
			throw new AppException\ActionAlreadyDoneException;
			

		//if everything's okay, attempt to save the vote in the db
		$vote = VoteModel::create(array(
			'voter_id' 		=> $voter->id,
			'picture_id' 	=> $this->pic->id,
		));

		//if the vote is inserted in the db, create success message
		if ($vote) return true;

		throw new AppException\ActionTechnicalException('There was a technical error');
		return false;
	}

	/*
	 * @return an array of all the user models that voted the image
	 */
	public function getVoters()
	{
		return $this->pic->voters()->get(array('users.username', 'users.id'));
	}

	/*
	 * @param total @number of images to fetch
	 * @param from @number from where to start fetching
	 * @return collection of recent pictures for the homepage mainly 
	 */
	public function getRecentPictures($total = 10, $from = 0)
	{
		$pics = PictureModel::with('user')
			->skip($from)
			->take($total)
			->orderBy('created_at', 'desc')
			->get();

		return $pics;
	}
}