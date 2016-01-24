<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlackList extends Model {

	protected $table = 'blacklist';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'ip', 'infos');

}