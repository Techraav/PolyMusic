<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instrument extends Model {

	protected $table = 'instruments';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $nameField = 'name';

	public function players()
	{
		return $this->belongsToMany('BandMember');
	}

	public function courses()
	{
		return $this->belongsToMany('Course');
	}

}