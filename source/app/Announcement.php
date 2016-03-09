<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model {

	protected $table = 'announcements';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'user_id', 'title', 'content', 'tags', 'slug', 'validated', 'subject', 'category_id');

	public function validate()
	{
		return $this->update(['validated'	=> 1 ]);
	}

	public function comments()
	{
		return $this->hasMany('App\Comment');
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function category()
	{
		return $this->belongsTo('App\Category');
	}

	public function scopeValidated($query)
	{
		return $query->where('validated', 1);
	}

	public function scopeUnvalidated($query)
	{
		return $query->where('validated', 0);
	}

	public function scopeOfCategory($query, $category_id)
	{
		return $query->where('category_id', $category_id);
	}

}