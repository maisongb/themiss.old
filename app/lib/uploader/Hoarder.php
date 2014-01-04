<?php
namespace App\Lib\Uploader;

use File;
use Carbon;

/**
* @author Foysal Ahamed
* @package uploader package for the app 
*/
class Hoarder
{
	public $user;
	public $user_dir;
	public $file_info;
	private $file;

	function __construct($file, $user)
	{
		$this->user = $user;
		$this->file = $file;
		$this->setUserDir();
	}

	/*
	* check if a directory for the user already exists
	* if not, create one
	* finally, assign the directory name to the $user_dir var
	*/
	private function setUserDir()
	{
		$now = Carbon::now();

		// the 'D' means directory, nothing pervy
		$d_segments = array(
			public_path(), 
			'pictures', 
			$this->user->username, 
			$now->year, 
			$now->month, 
			$now->day
		);
		$d_name = '';

		//if a directory for the user doesn't exist, create one
		foreach ($d_segments as $segment) {
			$d_name .= $segment. '/';

			if (! File::isDirectory($d_name)) {
				File::makeDirectory($d_name, 0777, true);
			}
		}

		$this->user_dir = $d_name;
	}

	public function save()
	{
		$file_ext = $this->file->getClientOriginalExtension();
		$file_name = time() .'_'. $this->user->id .'.'. $file_ext;

		if ($this->isValidExtension($file_ext)) {
			$this->file->move($this->user_dir, $filename);

			$this->file_info = array(
				'path' => $this->user_dir . $filename,
				'size' => $this->file->getSize()
			);

			return true;
		} else {

		}
	}

	//checks if a file extension is supported and valid
	public function isValidExtension($extension)
	{
		$valid_extensions = array('jpg', 'jpeg', 'png');

		return in_array(strtolower($extension), $valid_extensions);
	}
}