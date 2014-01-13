<?php
namespace App\Models;

class Follow extends \Eloquent {
	protected $table = 'follows';
	protected $guarded = array();

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function follower()
	{
		return $this->belongsTo('User', 'follower_id');
	}
}