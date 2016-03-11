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
	protected $fillable = array('email', 'password', 'first_name', 'last_name', 'birth_date', 'phone', 'profil_picture', 'description', 'school_year', 'slug', 'level_id', 'timestamps', 'department_id');

	public function level()
	{
		return $this->belongsTo('App\Level');
	}

	public function notifications()
	{
		return $this->hasMany('App\Notification');
	}

	public function articles()
	{
		return $this->hasMany('App\Article');
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

	public function emailSent()
	{
		return $this->hasMany('App\Email', 'sender_id');
	}

	public function documents()
	{
		return $this->hasMany('App\Document');
	}

	public function emailReceived()
	{
		return $this->hasMany('App\Email', 'receiver_id');
	}

	public function courses()
	{
		return $this->belongsToMany('App\Course')->withPivot('level', 'validated');
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
		return $this->hasMany('App\Modification');
	}

	public function courseManaged()
	{
		return $this->hasMany('App\Course', 'user_id');
	}

	public function courseModified()
	{
		return $this->hasMany('App\CourseModification', 'author_id');
	}

	public function bannish()
	{
		$this->banned = 1;
		return $this->save();
	}

	public function scopeBanned($query)
	{
		return $query->where('banned', 1);
	}

	public function scopeNotBanned($query)
	{
		return $query->where('banned', 0);
	}

	public function isTeacherOf(Course $course)
	{
		return $course->users->contains([$this->id, 2]);
	}
}