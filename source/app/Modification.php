<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modification extends Model {

	protected $table = 'modifications';
	public $timestamps = true;
	protected $fillable = array('user_id', 'table', 'message');

	public function user()
	{
		return $this->hasOne('App\User');
	}

}