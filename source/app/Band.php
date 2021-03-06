<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Band extends Model {

	protected $table = 'bands';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'name', 'image', 'infos', 'user_id', 'validated', 'slug', 'article_id');
	const NAMEFIELD = 'name';

	public function members()
	{
		return $this->belongsToMany('App\User');
	}

	public function events()
	{
		return $this->belongsToMany('App\Event');
	}

	public function manager()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function article()
	{
		return $this->belongsTo('App\Article', 'article_id');
	}

	public function scopeValidated($query)
	{
		return $query->where('validated', 1);
	}

	public function scopeUnvalidated($query)
	{
		return $query->where('validated', 0);
	}

}