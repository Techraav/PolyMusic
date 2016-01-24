<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model {

	protected $table = 'emails';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'sender_email', 'subject', 'content', 'receiver_id', 'sender_id');

	public function receiver()
	{
		return $this->belongsToMany('App\User', 'receiver_id');
	}

}