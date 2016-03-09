<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use App\Modification;
use App\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class DocumentController extends Controller
{
    public function index()
    {
    	$documents = Document::orderBy('created_at', 'desc')->with('author', 'course')->paginate(15);
    	return view('admin.documents.index', compact('documents'));
    }

    public function fromUser($id)
    {
    	$documents = Document::where('user_id', $id)->with('author', 'course')->orderBy('created_at', 'desc')->paginate(15);
    	$filter = 'utilisateurs';
    	return view('admin.documents.index', compact('documents', 'filter', 'id'));
    }

    public function forCourse($id)
    {
    	$documents = Document::where('course_id', $id)->with('author', 'course')->orderBy('created_at', 'desc')->paginate(15);
    	$filter = 'cours';
    	return view('admin.documents.index', compact('documents', 'filter', 'id'));
    }
}
