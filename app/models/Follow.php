<?php
namespace App\Models;

use Eloquent;

class Picture extends Eloquent {
	protected $table = 'follows';
	protected $fillable = array('*');

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function follower()
	{
		return $this->belongsTo('User', 'follower_id');
	}
}