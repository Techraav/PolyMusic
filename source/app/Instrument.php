<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Instrument;

class Instrument extends Model {

	protected $table = 'instruments';
	public $timestamps = false;
	protected $fillable = array('name');
	protected $nameField = 'name';
	public static $defaultValue = 1;

	public function players()
	{
		return $this->hasMany('App\BandUser', 'instrument_id')->with('user');
	}

	public function courses()
	{
		return $this->hasMany('App\Course')->with('band');
	}

}