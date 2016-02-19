<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model {

	protected $table = 'course_user';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'course_id', 'user_id', 'date', 'message', 'validated', 'level');

}