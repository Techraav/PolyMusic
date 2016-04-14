<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model {

	protected $table = 'course_user';
	protected $dates = ['date'];
	public $timestamps = true;
	protected $fillable = array('timestamps', 'course_id', 'user_id', 'date', 'message', 'validated', 'level');

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function course()
	{
		return $this->belongsTo('App\Course');
	}

}