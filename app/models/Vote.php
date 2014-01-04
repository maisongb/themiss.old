<?php
namespace App\Models;

use Eloquent;

class Vote extends Eloquent {
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
}