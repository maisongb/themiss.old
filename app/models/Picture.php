<?php
namespace App\Models;

use Carbon\Carbon;

class Picture extends \Eloquent {
	protected $table = 'pictures';
	protected $softDelete = true;
	protected $guarded = array();

	public function user()
	{
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	public function voters()
	{
		return $this->belongsToMany('App\Models\User', 'votes', 'picture_id', 'voter_id');
	}

	public function isVotable()
	{
		$now = Carbon::now();
		return ($now->month === $this->created_at->month) && ($now->year === $this->created_at->year);
	}

	public function scopeOnlyCurrentMonth($query)
	{
		return $query->whereRaw('MONTH(created_at) = MONTH(NOW())');
	}

	public function scopeOfMonth($query, $month = 0)
	{
		$m = Carbon::now();

		if((int)$month > 0) $m->month = $month;

		return $query->whereRaw('MONTH(created_at) = MONTH("'. $m->toDateTimeString() .'")');
	}

	public function scopeOfYear($query, $year = 0)
	{
		$y = Carbon::now();

		if((int)$year > 0) $y->year = $year;

		return $query->whereRaw('YEAR(created_at) = YEAR("'. $y->toDateTimeString() .'")');
	}
}