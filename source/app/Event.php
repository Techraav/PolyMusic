<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['band_id', 'location', 'date', 'band', 'start', 'end', 'infos'];
    protected $hidden	= [];
    protected $table 	= 'events';
}
