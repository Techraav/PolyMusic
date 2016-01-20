<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    protected $fillable = ['name', 'nb_members', 'members', 'img'];
    protected $hidden	= [];
    protected $table 	= 'bands';
}
