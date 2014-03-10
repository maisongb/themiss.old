<?php
namespace App\Controllers\Dashboard;

use App\Models\Picture;

/*
 * IndexController
 */
class IndexController extends BaseController
{
	public function home($username){
		$pictures = Picture::with('user')->get();

		return \View::make('pictures.list')
			->withPictures($pictures);
	}
}