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
	public function getRecentPictures($params = array())
	{
		//we pass this closure to the eager loader to filter only
		//the id and the username field from users table
		$user_filter = function ($query){
			$query->select(array('id', 'username'));
		};

		$pics = PictureModel::with(array('user' => $user_filter));

		//if there's a user id passed in, we return only the pics of that user
		if((int)array_get($params, 'user', 0) > 0){
			$pics = $pics->where('user_id', array_get($params, 'user'));
		}

		//if there's a starting point set, we start from there
		if((int)array_get($params, 'from', 0) > 0){
			$pics = $pics->skip(array_get($params, 'from', 0));
		}

		return $pics
			->take(array_get($params, 'total', 5))
			->orderBy('created_at', 'desc')
			->get();
	}

	public function getVotedPictures($params = array())
	{
		
	}
}