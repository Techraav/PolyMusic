<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

	protected $table = 'events';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'location', 'day', 'start', 'end', 'infos', 'name', 'slug');

	public function bands()
	{
		return $this->hasMany('App\Band');
	}

}