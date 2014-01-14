<?php
namespace App\Models;

class Follow extends \Eloquent {
	protected $table = 'follows';
	protected $guarded = array();

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function follower()
	{
		return $this->belongsTo('App\Models\User', 'follower_id');
	}
}