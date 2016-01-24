<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model {

	protected $table = 'announcements';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'user_id', 'title', 'content', 'tags', 'slug', 'validated');

	public function comments()
	{
		return $this->hasMany('App\Comment');
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'author');
	}

}