<?php
namespace App\Lib\Uploader;

/**
* @author Foysal Ahamed
* @package uploader package for the app 
*/
class Transporter
{
	public $user;
	public $picture;
	public $file_info;

	function __construct($picture, $user)
	{
		$this->user = $user;
		$this->picture = $picture;
		$this->file_info = $picture;
	}
}