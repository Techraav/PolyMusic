<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandMember extends Model {

	protected $table = 'band_members';
	public $timestamps = false;
	protected $fillable = array('user_id', 'band_id', 'instrument_id');

	public function instrument()
	{
		return $this->hasOne('Instrument');
	}

}