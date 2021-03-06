<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model {

	protected $table = 'news';
	protected $dates = ['published_at'];
	public $timestamps = true;
	protected $fillable = array('published_at', 'title', 'content', 'user_id', 'active', 'slug');
	const NAMEFIELD = 'title';


	public function activate()
	{
		return $this->update(['active' => 1]);
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function scopeValidated($query)
	{
		return $query->where('active', 1);
	}

	public function scopeUnvalidated($query)
	{
		return $query->where('active', 0);
	}

	public function scopePublished($query)
	{
		return $query->where('active', 1)->where('published_at', '<=', DB::raw('NOW()'));
	}

}