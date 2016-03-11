<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseModification extends Model {

	protected $table = 'course_modifications';
	public $timestamps = true;
	protected $fillable = array('author_id', 'user_id', 'course_id', 'message', 'value');

	public function course()
	{
		return $this->belongsTo('App\Course');
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'author_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

}