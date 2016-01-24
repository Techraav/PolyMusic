<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model {

	protected $table = 'levels';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'level', 'name', 'infos');

	public function users()
	{
		return $this->hasMany('App\User');
	}

}