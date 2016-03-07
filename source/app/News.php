<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model {

	protected $table = 'news';
	public $timestamps = true;
	protected $fillable = array('published_at', 'title', 'content', 'user_id', 'active', 'slug');
	protected $nameField = 'title';


	public function activate()
	{
		return $this->update(['active' => 1]);
	}

	public function author()
	{
		return $this->belongsTo('App\User');
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