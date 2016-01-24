<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

	protected $table = 'courses';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'name', 'day', 'start', 'end', 'infos', 'slug');

	public function members()
	{
		return $this->hasMany('App\User');
	}

}