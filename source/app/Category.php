<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';
	public $timestamps = true;
	protected $fillable = array('name');

	public function articles(){
		return $this->hasMany('App\Article');
	}

	public function announcements(){
		return $this->hasMany('App\Announcement');
	}

}
