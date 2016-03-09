<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	protected $table = 'comments';
	public $timestamps = true;
	public $touches = ['announcement'];
	protected $fillable = array('timestamps', 'answer_to', 'announcement_id', 'user_id', 'content');

	public function announcement()
	{
		return $this->belongsTo('App\Announcement');
	}

	public function author()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	public function answerTo()
	{
		return $this->belongsTo('App\Comment', 'answer_to');
	}

	public function answers()
	{
		return $this->hasMany('App\Comment', 'answer_to');
	}

}