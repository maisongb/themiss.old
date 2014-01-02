<?php
namespace App\Controllers\Dashboard;

use \Config;
use \Input;
use \OAuth;
use \Redirect;
use \Session;
use \View;

/*
 * IndexController
 */
class IndexController extends BaseController
{
	public function home($username){
		dd($username);
	}
}