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

	public function latest($total = 5, $from = 0)
	{
		$pics = new PictureFactory();
		$pics = $pics->getRecentPictures(array(
			'total' => $total,
			'from' => $from
		));

		return \View::make('pictures.list')
			->withPictures($pics);
	}
}