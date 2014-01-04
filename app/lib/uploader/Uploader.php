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
	public $user;
	public $picture;
	public $provider;
	public $robot;
	public $uploaded_pictures;

	function __construct($params)
	{
		$this->user 	= isset($params['user']) && !empty($params['user']) ? $params['user'] : null;
		$this->picture 	= isset($params['picture']) && !empty($params['picture']) ? $params['picture'] : null;
		$this->provider = isset($params['provider']) && !empty($params['provider']) ? $params['provider'] : null;
	}

	public function startRobot()
	{
		switch ($this->provider) {
			case 'user':
				$this->robot = new Hoarder($this->picture, $this->user);
				break;

			case 'facebook':
				$this->robot = new Transporter($this->picture, $this->user);
				break;
			
			default:
				break;
		}

		return $this;
	}

	public function savePicture()
	{
		if ($this->robot instanceof Hoarder) {
			$this->robot->save();
			$pictures = $this->robot->file_info();
			$this->uploaded_pictures = array($pictures['path']);
		} elseif ($this->robot instanceof Transporter) {
			$this->uploaded_pictures = $this->robot->file_info;
		}

		return $this;
	}

	public function stopRobot()
	{
		

		return $this;
	}
}