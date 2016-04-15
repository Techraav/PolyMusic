<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

	protected $table = 'images';
	public $timestamps = false;
	protected $fillable = array('title', 'description', 'name', 'article_id');

	public function article()
	{
		return $this->belongsTo('App\Article');
	}

}