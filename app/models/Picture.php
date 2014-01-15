<?php
namespace App\Models;

class Picture extends \Eloquent {
	protected $table = 'pictures';
	protected $guarded = array();

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function voters()
	{
		return $this->belongsToMany('App\Models\User', 'votes');
	}
}