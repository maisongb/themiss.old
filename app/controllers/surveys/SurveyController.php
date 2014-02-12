<?php
namespace App\Controllers\Survey;

use App\Models\Survey;

/*
 * IndexController
 */
class IndexController
{
	public function creator(){
		return \View::make('surveys.creator')
			->withPictures($pictures);
	}
}