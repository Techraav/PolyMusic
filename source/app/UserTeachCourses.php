<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTeachCourses extends Model {

	protected $table = 'users_teach_courses';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'user_id', 'course_id', 'date', 'message', 'validated');

}