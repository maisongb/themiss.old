<?php
namespace App\Controllers\Dashboard;

use Config;
use Input;
use OAuth;
use Sentry;
use Redirect;
use Session;
use View;
use \App\Models\Picture;

/*
 * IndexController
 */
class IndexController extends BaseController
{
	public function home($username){
		$user = Sentry::getUser();

		$pictures = Picture::with('user')->get();

		return View::make('pictures.list')
			->withPictures($pictures);
	}
}