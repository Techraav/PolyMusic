<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Band extends Model {

	protected $table = 'bands';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'name', 'image', 'infos', 'user_id', 'validated', 'slug');

	public function members()
	{
		return $this->hasMany('App\User');
	}

	public function events()
	{
		return $this->belongsToMany('App\Event');
	}

}