<?php
namespace App\Controllers\Dashboard;

use Config;
use Input;
use OAuth;
use Redirect;
use Session;
use View;
use Sentry;
use App\Lib\Social\SocialProvider;
use App\Lib\Uploader\Uploader;
use App\Models\Picture;

/*
 * UploadController
 */
class UploadController extends BaseController {
	public function home($username)
	{
		return View::make('dashboard.upload.home');
	}

	public function save()
	{
		$uploader = new Uploader(array(
			'user' 		=> Sentry::getUser(),
			'picture' 	=> Input::file('picture') ? : Input::get('picture'),
			'provider' 	=> Input::get('provider'),
		));
		
		$uploader->startRobot()->savePicture()->stopRobot();

		foreach ($uploader->uploaded_pictures as $pic) {
			Picture::create(array(
				'user_id' 	=> $uploader->user->id,
				'url'		=> $pic,
				'provider'	=> $uploader->provider,
			));
		}
	}

	public function facebookAlbums($username)
	{
		$social = new SocialProvider('facebook');
		$facebook = $social->provider;

		$albums = $facebook->getAlbums();

		return View::make('dashboard.upload.facebook.albums')
					->withAlbums($albums['data']);
	}

	public function facebookPhotos($username, $album_id)
	{
		$social = new SocialProvider('facebook');
		$facebook = $social->provider;

		$photos = $facebook->getPhotos($album_id);

		return View::make('dashboard.upload.facebook.pictures')
					->withPhotos($photos['data']);
	}

	public function instagramPhotos($username)
	{
		$social = new SocialProvider('instagram');
		$instagram = $social->provider;

		$pictures = $instagram->getPhotos();

		return View::make('dashboard.upload.instagram.pictures')
					->withPictures($pictures['data']);
	}
} 