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
	public $robot;

	function __construct($action, $params)
	{
		if(isset($params['user']) && !empty($params['user']))
			$this->user = $params['user'];

		switch ($action) {
			case 'save':
				$this->robot = new Hoarder($params['file'], $this->user);
				break;
			
			default:
				# code...
				break;
		}
	}
}