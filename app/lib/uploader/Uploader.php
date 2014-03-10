<?php
namespace App\Lib\Uploader;

use Input;
use App\Lib\Uploader\Transporter;
use App\Lib\Uploader\Hoarder;

/**
* @author Foysal Ahamed
* @package uploader package for the app 
* @param robot is the instance of the task that needs to be done, can be transfer or saving process
*/
class Uploader
{
	public $profile;
	public $picture;
	public $provider;
	public $robot;
	public $uploaded_picture;

	function __construct($params)
	{
		$this->profile 	= isset($params['profile']) && !empty($params['profile']) ? $params['profile'] : null;
		$this->picture 	= isset($params['picture']) && !empty($params['picture']) ? $params['picture'] : null;
		$this->provider = isset($params['provider']) && !empty($params['provider']) ? $params['provider'] : null;
	}

	public function startRobot()
	{
		$this->robot = new Hoarder($this->picture, $this->profile, $this->provider);

		return $this;
	}

	public function savePicture()
	{
		if ($this->robot instanceof Hoarder) {
			$this->robot->save();
			$pictures = $this->robot->file_info;
			$this->uploaded_picture = $pictures['path'];
		}

		return $this;
	}

	public function stopRobot()
	{
		

		return $this;
	}
}