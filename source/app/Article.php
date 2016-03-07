<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

	protected $table = 'articles';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'title', 'subtitle', 'content', 'user_id', 'slug', 'category_id', 'validated');

	public function validate()
	{
		return $this->update(['validated'	=> 1 ]);
	}

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

	public function scopeOfCategory($query, $category_id)
	{
		return $query->where('category_id', $category_id);
	}

}