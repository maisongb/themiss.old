<?php
namespace App\Controllers\Dashboard;

use App\Lib\Picture\PictureFactory;

/*
 * ManageController
 */
class ManageController extends BaseController
{
	public function pictures($username){
		return View::make();
	}
}