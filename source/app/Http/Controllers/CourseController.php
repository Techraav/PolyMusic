<?php namespace App\Http\Controllers;

use App\Course;
use App\User;
use App\Modification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class CourseController extends Controller {

// ________________________________________________________________
//
//                        	GET FUNCTIONS 
// ________________________________________________________________  

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$courses = Course::orderBy('day')->paginate(20);
		return view('admin.courses.index', compact('courses'));
	}

	/**
	* Display the specified resource.
	*
	* @param  str $slug
	* @return Response
	*/
	public function show($slug)
	{

	}

	/**
	* Display the specified resource.
	*
	* @param  str $slug
	* @return Response
	*/
	public function members($slug)
	{

	}

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create()
	{

	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  str $slug
	* @return Response
	*/
	public function edit($slug)
	{

	}
	
// ________________________________________________________________
//
//                          	HELPERS 
// ________________________________________________________________  

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
	{

	}

	/**
	* Update the specified resource in storage.
	*
	* @param  str $slug
	* @return Response
	*/
	public function update($slug)
	{

	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  str $slug
	* @return Response
	*/
	public function destroy($slug)
	{

	}

// ________________________________________________________________
//
//                          	HELPERS 
// ________________________________________________________________  

	protected function validator($data)
	{
		return Validator::make($data, [
			'name' 			=> 'required|min:6|max:255',
			'day' 			=> 'required',
			'start' 		=> 'required',
			'end' 			=> 'required',
			'instrument_id' => 'required',
			]);

		// creer un article vide avec le meme titre que le cours, puis redirect vers l'article pour l'éditer
	}
  
}

?>