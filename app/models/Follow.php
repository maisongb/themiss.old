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

	public function scopeUserFollows($query, $follower, $user)
	{
		return $query->where('follower_id', $follower)->where('user_id', $user);
	}
}