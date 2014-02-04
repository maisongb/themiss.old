<?php
namespace App\Lib\Uploader;

use Carbon\Carbon;
use App\Lib\Exceptions as AppException;

/**
* @author Foysal Ahamed
* @package uploader package for the app 
*/
class Hoarder
{
	public $profile;
	public $user_dir;
	public $file_info;
	private $file;
	private $provider;

	function __construct($file, $profile, $provider)
	{
		$this->profile = $profile;
		$this->file = $file;
		$this->provider = $provider;
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
			$this->profile->user->username, 
			$now->year, 
			$now->month, 
			$now->day
		);
		$d_name = '';

		//if a directory for the user doesn't exist, create one
		foreach ($d_segments as $segment) {
			$d_name .= $segment. '/';

			if (! \File::isDirectory($d_name)) {
				\File::makeDirectory($d_name, 0777, true);
			}
		}

		$this->user_dir = $d_name;
	}

	public function save()
	{
		if($this->provider == 'facebook')
			return $this->saveFromFacebook($this->file);

		elseif($this->provider == 'instagram')
			return $this->saveFromInstagram($this->file);

		return $this->saveFromUser();
	}

	public function saveFromUser()
	{
		$file_ext = $this->file->getClientOriginalExtension();
		$file_size = $this->file->getSize() ? $this->file->getSize() : 0;

		if(!$this->isValidExtension($file_ext))
			throw new AppException\InvalidFileUpload;

		//move the uploaded file to the user's directory with appropriate filename
		$file_name = time() .'_'. $this->profile->user->id .'.'. $file_ext;
		$this->file->move($this->user_dir, $file_name);

		//set the file info stuff 
		$this->file_info = array(
			'path' => \URL::to(str_replace(public_path(), '', $this->user_dir) . $file_name),
			'size' => $file_size
		);

		return true;
	}

	//takes a the url of an image on facebook and copies it to our server
	public function saveFromFacebook($url)
	{
		$file_ext = explode('.', $url);
		$file_ext = end($file_ext);

		if(!$this->isValidExtension($file_ext))
			throw new AppException\InvalidFileUpload;

		//copy the file from the url to the user's directory with appropriate filename
		$file_name = time() .'_'. $this->profile->user->id .'.'. $file_ext;
		$f = \File::copy($url, $this->user_dir.$file_name);

		//set the file info stuff 
		$this->file_info = array(
			'path' => \URL::to(str_replace(public_path(), '', $this->user_dir) . $file_name),
		);

		return true;
	}

	//takes a the url of an image on facebook and copies it to our server
	public function saveFromInstagram($url)
	{
		$file_ext = explode('.', $url);
		$file_ext = end($file_ext);

		if(!$this->isValidExtension($file_ext))
			throw new AppException\InvalidFileUpload;

		//copy the file from the url to the user's directory with appropriate filename
		$file_name = time() .'_'. $this->profile->user->id .'.'. $file_ext;
		\File::copy($url, $this->user_dir.$file_name);

		//set the file info stuff 
		$this->file_info = array(
			'path' => \URL::to(str_replace(public_path(), '', $this->user_dir) . $file_name),
		);

		return true;
	}

	//checks if a file extension is supported and valid
	public function isValidExtension($extension)
	{
		$valid_extensions = array('jpg', 'jpeg', 'png');

		return in_array(strtolower($extension), $valid_extensions);
	}
}