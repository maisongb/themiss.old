<?php
namespace App\Models;

use Eloquent;

class Picture extends Eloquent {
	protected $table = 'pictures';
	protected $fillable = array('*');

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}
}