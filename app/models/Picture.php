<?php
namespace App\Models;

use Eloquent;

class Picture extends Eloquent {
	protected $table = 'pictures';
	protected $guarded = array();

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}
}