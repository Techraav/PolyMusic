<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'teacher', 'day', 'start', 'end', 'infos', 'nb_members'];
    protected $hidden 	= [];
    protected $table 	= 'course';
}
