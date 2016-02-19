<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

	protected $table = 'courses';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'name', 'day', 'start', 'end', 'infos', 'slug', 'instrument_id', 'article_id', 'user_id');

	public function students()
	{
		return $this->hasMany('App\User');
	}

	public function teachers()
	{
		return $this->hasMany('App\User');
	}

	public function instrument()
	{
		return $this->hasOne('App\Instrument');
	}

	public function documents()
	{
		return $this->hasMany('App\Document');
	}

	public function article()
	{
		return $this->hasOne('App\Article');
	}

	public function manager()
	{
		return $this->hasOne('App\User');
	}

	public function course_modification()
	{
		return $this->belongsTo('App\CourseModification');
	}

}