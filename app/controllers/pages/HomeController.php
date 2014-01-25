<?php
namespace App\Controllers\Pages;

use App\Lib\Picture\PictureFactory;
/*
 * HomeController
 */
class HomeController extends \Controller 
{
	public function index()
	{
		$pics = new PictureFactory();
		$pics = $pics->getRecentPictures();
		
		return \View::make('pages.home.all')
			->withPictures($pics);
	}
}