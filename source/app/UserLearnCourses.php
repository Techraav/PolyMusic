<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLearnCourses extends Model {

	protected $table = 'users_learn_courses';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'course_id', 'user_id', 'date', 'message', 'validated');

}