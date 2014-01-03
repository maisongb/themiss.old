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
		$uploader = new Uploader('save', array(
			'user' => Sentry::getUser(),
			'file' => Input::file('picture')
		));

		dd($uploader->robot->save());
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