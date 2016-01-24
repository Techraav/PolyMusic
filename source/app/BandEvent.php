<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandEvent extends Model {

	protected $table = 'band_events';
	public $timestamps = false;
	protected $fillable = array('band_id', 'event_id');

}