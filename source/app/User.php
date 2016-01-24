<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('email', 'password', 'first_name', 'last_name', 'birth_date', 'phone', 'profil_picture', 'description', 'school_year', 'slug', 'level', 'timestamps');

	public function level()
	{
		return $this->belongsTo('Level', 'level');
	}

	public function articles()
	{
		return $this->hasMany('Article');
	}

	public function news()
	{
		return $this->hasMany('App\News');
	}

	public function comments()
	{
		return $this->hasMany('App\Comment');
	}

	public function department()
	{
		return $this->belongsTo('App\Department');
	}

	public function emails_received()
	{
		return $this->hasMany('User');
	}

	public function courses()
	{
		return $this->belongsToMany('App\Course');
	}

	public function bands()
	{
		return $this->belongsToMany('App\Band');
	}

	public function announcements()
	{
		return $this->hasMany('App\Announcement');
	}
}