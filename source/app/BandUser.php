<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Instrument;

class BandUser extends Model {

	protected $table = 'band_user';
	public $timestamps = false;
	protected $fillable = array('user_id', 'band_id', 'instrument_id');

	public function instrument()
	{
		return $this->belongsTo('App\Instrument');
	}

	public function setDefaultInstrument()
	{
		return $this->update(['instrument_id' => Instrument::$defaultValue]);
	}

}