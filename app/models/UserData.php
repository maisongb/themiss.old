<?php
namespace App\Models;

class UserData {
	protected $table = 'users_data';

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}
}