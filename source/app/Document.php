<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $fillable = ['title', 'name', 'user_id', 'description', 'course_id', 'validated'];
    protected $timestamp = true;
    protected $nameField = 'title';

    public function course()
    {
    	return $this->belongsTo('App\Course');
    }

    public function author()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
