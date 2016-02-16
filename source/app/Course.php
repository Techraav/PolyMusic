<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

	protected $table = 'courses';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'name', 'day', 'start', 'end', 'infos', 'slug', 'instrument_id', 'article_id', 'user_id');

	public function members()
	{
		return $this->hasMany('App\User');
	}

	public function instrument()
	{
		return $this->hasOne('Instrument');
	}

	public function documents()
	{
		return $this->hasMany('Document');
	}

	public function article()
	{
		return $this->hasOne('Article');
	}

	public function manager()
	{
		return $this->hasOne('User', 'user_id');
	}

	public function course_modification()
	{
		return $this->belongsTo('CourseModification');
	}

}