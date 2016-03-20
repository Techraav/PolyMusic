<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

	protected $table = 'notifications';
	public $timestamps = true;
	protected $fillable = array('message', 'user_id', 'link');

	public function user()
	{
		return $this->belongsTo('App\User');
	}

}