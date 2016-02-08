<?php

namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('email', 'password', 'first_name', 'last_name', 'birth_date', 'phone', 'profil_picture', 'description', 'school_year', 'slug', 'level', 'timestamps', 'department_id');

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

	public function modifications()
	{
		return $this->belongsToMany('Modification');
	}
}