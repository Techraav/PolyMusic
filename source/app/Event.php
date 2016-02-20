<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

	protected $table = 'events';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'location', 'day', 'start', 'end', 'infos', 'name', 'slug');
	protected $nameField = 'name';

	public function bands()
	{
		return $this->belongsToMany('App\Band');
	}

}