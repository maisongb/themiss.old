<?php
/*
 * DashboardController
 */
class DashboardController extends BaseController {
	public function upload(){
		if(!Session::has('token.facebook'))
			return 'nope!';

		$fb = OAuth::consumer('Facebook');
		$albums = json_decode($fb->request('/me/albums'), true);

		return View::make('dashboard')
					->withAlbums($albums['data'])
					->withToken(Session::get('token.facebook'));
	}

	public function album($album_id){
		if(!Session::has('token.facebook'))
			return 'nope!';

		$fb = OAuth::consumer('Facebook');

		$photos = json_decode($fb->request('/' .$album_id. '/photos?limit=30'), true);

		return View::make('album')
					->withPhotos($photos['data'])
					->withToken(Session::get('token.facebook'));
	}
}