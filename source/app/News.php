<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

	protected $table = 'news';
	public $timestamps = true;
	protected $fillable = array('publish_at', 'title', 'content', 'user_id', 'active', 'slug');
	protected $nameField = 'title';

	public function author()
	{
		return $this->belongsTo('App\User');
	}

}