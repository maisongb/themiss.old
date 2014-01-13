<?php
namespace App\Models;

class Vote extends \Eloquent {
	protected $table = 'votes';
	protected $guarded = array();

	public function voter()
	{
		return $this->belongsTo('User', 'voter_id');
	}

	public function picture()
	{
		return $this->belongsTo('Picture', 'picture_id');
	}

	public function scopeAlreadyLiked($query, $voter, $picture)
	{
		return $query->where('voter_id', $voter)->where('picture_id', $picture);
	}
}