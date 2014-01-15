<?php
namespace App\Controllers\Dashboard;

use App\Lib\Social\SocialProvider;
use App\Lib\Uploader\Uploader;
use App\Models\Picture;
use App\Lib\Profile\ProfileFactory;

/*
 * UploadController
 */
class UploadController extends BaseController {
	public function home($username)
	{
		return \View::make('dashboard.upload.home');
	}

	public function save($username)
	{
		$uploader = new Uploader(array(
			'profile' 	=> new ProfileFactory(\Sentry::getUser()),
			'picture' 	=> \Input::file('picture') ? : \Input::get('picture'),
			'provider' 	=> \Input::get('provider'),
		));
		
		$uploader->startRobot()->savePicture()->stopRobot();

		Picture::create(array(
			'user_id' 	=> $uploader->profile->user->id,
			'url'		=> $uploader->uploaded_picture,
			'provider'	=> $uploader->provider,
		));

		return \Redirect::route('profile.home', array('username' => $username));
	}

	public function facebookAlbums($username)
	{
		$profile = new ProfileFactory(\Sentry::getUser());
		$social = new SocialProvider($profile, 'facebook');
		$facebook = $social->provider;

		$albums = $facebook->getAlbums();

		return \View::make('dashboard.upload.facebook.albums')
					->withAlbums($albums['data']);
	}

	public function facebookPhotos($username, $album_id)
	{
		$profile = new ProfileFactory(\Sentry::getUser());
		$social = new SocialProvider($profile, 'facebook');
		$facebook = $social->provider;

		$photos = $facebook->getPhotos($album_id);

		return \View::make('dashboard.upload.facebook.pictures')
					->withPhotos($photos['data']);
	}

	public function instagramPhotos($username)
	{
		$profile = new ProfileFactory(\Sentry::getUser());
		$social = new SocialProvider($profile, 'instagram');
		$instagram = $social->provider;

		$pictures = $instagram->getPhotos();

		return \View::make('dashboard.upload.instagram.pictures')
					->withPictures($pictures['data']);
	}
} 