<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

	protected $table = 'courses';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'name', 'day', 'start', 'end', 'infos', 'slug', 'instrument_id', 'article_id', 'user_id', 'active');
	const NAMEFIELD = 'name';

	public function joinNotification()
	{
		return $this->manager->sendNotification('Un membre a demandé à rejoindre le cours &laquo; '.ucfirst($this->name).' &raquo;.', 'admin/courses/'.$this->slug.'/members');
	}

	public function leaveNotification($level, User $user)
	{
		return $this->manager->sendNotification(ucfirst($user->first_name).' '.ucfirst($user->last_name)." s'est retiré des ". ($level == 1 ? 'professeurs' : 'élèves') . 'du cours &laquo; '.ucfirst($this->name).' &raquo;.', 'admin/courses/'.$this->slug.'/members');
	}

	public function waitingStudents()
	{
		return $this->hasMany('App\CourseUser');
	}

	public function waitingTeachers()
	{
		return $this->hasMany('App\CourseUser');
	}

	public function users()
	{
		return $this->belongsToMany('App\User')->withPivot('level', 'validated');
	}

	public function teachers()
	{
		return $this->belongsToMany('App\User')->withPivot('level', 'validated');
	}

	public function unvalidatedUsers()
	{
		return $this->belongsToMany('App\User')->withPivot('level', 'validated');
	}

	public function unvalidatedTeachers()
	{
		return $this->belongsToMany('App\User')->withPivot('level', 'validated');
	}

	public function instrument()
	{
		return $this->belongsTo('App\Instrument');
	}

	public function article()
	{
		return $this->belongsTo('App\Article');
	}

	public function documents()
	{
		return $this->hasMany('App\Document');
	}

	public function manager()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function modifications()
	{
		return $this->hasMany('App\CourseModification');
	}

	public function setDefaultInstrument()
	{
		return $this->update(['instrument_id' => Instrument::$defaultValue]);
	}

	public function scopeOfInstrument($query, $instrument_id)
	{
		return $query->where('instrument_id', $instrument_id);
	}

	public function scopeOfDay($query, $day)	
	{
		return $query->where('day', $day);
	}

	public function demands()
	{
		return $this->belongsToMany('App\User');
	}

}