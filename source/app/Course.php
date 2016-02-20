<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

	protected $table = 'courses';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'name', 'day', 'start', 'end', 'infos', 'slug', 'instrument_id', 'article_id', 'user_id');

	public function users()
	{
		return $this->belongsToMany('App\User');
	}

	public function instrument()
	{
		return $this->hasOne('App\Instrument');
	}

	public function article()
	{
		return $this->hasOne('App\Article');
	}

	public function documents()
	{
		return $this->hasMany('App\Document');
	}

	public function manager()
	{
		return $this->hasOne('App\User');
	}

	public function course_modification()
	{
		return $this->belongsTo('App\CourseModification');
	}

	public function setDefaultInstrument()
	{
		return $this->update(['instrument_id' => Instrument::$defaultValue]);
	}

}