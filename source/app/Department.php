<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table = 'departments';
	public $timestamps = true;
	protected $fillable = array('timestamps', 'name', 'short_name');
	protected $nameField = 'name';

	public function users()
	{
		return $this->hasMany('App\User');
	}

}