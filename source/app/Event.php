<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

	protected $table = 'events';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'location', 'day', 'start', 'end', 'infos', 'name', 'slug', 'article_id');
	protected $nameField = 'name';

	public function bands()
	{
		return $this->belongsToMany('App\Band');
	}

	public function scopeOfDay($query, $day)	
	{
		return $query->where('day', $day);
	}

	public function scopeOfLocation($query, $location)	
	{
		return $query->where('location', $location);
	}

}