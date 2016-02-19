<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	protected $table = 'articles';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'title', 'subtitle', 'content', 'user_id', 'slug', 'category_id');

	public function author()
	{
		return $this->belongsTo('App\User');
	}

	public function images()
	{
		return $this->hasMany('App\Image');
	}

	public function course()
	{
		return $this->belongsTo('App\Course');
	}

	public function category()
	{
		return $this->belongsTo('App\Category');
	}

}