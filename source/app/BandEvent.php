<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandEvent extends Model {

	protected $table = 'band_event';
	protected $fillable = array('band_id', 'event_id');
	public $timestamps = false;

}