<?php namespace App\Http\Controllers;

use App\Course;
use App\User;
use App\Modification;
use App\Article;
use App\CourseUser;
use App\Announcement;
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
		return view('courses.index', compact('courses'));
	}

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function adminIndex()
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
		$course = Course::where('slug', $slug)->first();
		$id 	= $course->id;

		$students = CourseUser::where('course_id', $id)->where('validated', 1)->where('level', 0)->paginate(30);
		$teachers = CourseUser::where('course_id', $id)->where('validated', 1)->where('level', 1)->get();

		$waitingStudents = CourseUser::where('validated', 0)->where('course_id', $id)->where('level', 0)->orderBy('created_at')->get();
		$waitingTeachers = CourseUser::where('validated', 0)->where('course_id', $id)->where('level', 1)->orderBy('created_at')->get();

		return view('admin.courses.members', compact('course', 'students', 'teachers', 'waitingTeachers', 'waitingStudents'));
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
	* @param  int $id
	* @return Response
	*/
	public function edit($id)
	{
		$course = Course::where('id', $id)->first();
		if(Auth::user()->id != $course->user_id && Auth::user()->level < 3)
		{
			Flash::error("Vous n'avez pas le droit de modifier ce cours !");
			return redirect('admin/courses');
		}
		return view('admin.courses.edit', compact('course'));
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
	public function store(Request $request)
	{
		$validator = $this->validator($request->all());

		if($validator->fails())
		{
			Flash::error('Impossible de créer le cours. Veuillez vérifier les champs renseignés.');
			return Redirect::back()->withErrors($validator->errors());
		}

		$article = Article::createWithSlug([
			'title'		=> $request->name,
			'user_id'	=> Auth::user()->id,
			]);

		if(!isset($article))
		{
			Flash::errors("Erreur lors de la création de l'article concernant ce cours.");
			return Redirect::back();
		}

		$slug = $article->slug;

		$infos = postTextFormat($request->infos, allowedTags(['a', 'hr', 'br', 'b', 'i', 'u', 'ul', 'li']));
		$course = Course::createWithSlug([
			'name'		=> $request->name,
			'day'		=> $request->day,
			'start'		=> $request->start,
			'end'		=> $request->end,
			'infos'		=> $infos,
			'instrument_id' => $request->instrument_id,
			'article_id'	=> $article->id,
			'user_id'		=> $request->user_id,
			]);

		Modification::create([
			'table'		=> 'courses, articles',
			'user_id'	=> Auth::user()->id,
			'message'	=> 'Created course and article "'.$request->name.'".',
			]);

		return redirect('admin/articles/edit/'.$slug);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  str $slug
	* @return Response
	*/
	public function update(Request $request, $slug)
	{
		$validator = $this->validator($request->all());

		if($validator->fails())
		{
			Flash::error('Impossible de créer le cours. Veuillez vérifier les champs renseignés.');
			return Redirect::back()->withErrors($validator->errors());
		}

		$course = Course::where('slug', $slug)->first();

		if(Auth::user()->id != $course->user_id && Auth::user()->level < 3)
		{
			Flash::error("Vous n'avez pas le droit de modifier ce cours !");
			return redirect('admin/courses');
		}

		$oldName = $course->name;

		$slug = str_slug($request->name).'-'.$course->id;

		$course->update([
			'name'		=> $request->name,
			'slug'		=> $slug,
			'day'		=> $request->day,
			'start'		=> $request->start,
			'end'		=> $request->end,
			'infos'		=> $request->infos,
			'instrument_id' => $request->instrument_id,
			'user_id'		=> $request->user_id,
			]);

		Modification::create([
			'table'		=> 'courses',
			'user_id'	=> Auth::user()->id,
			'message'	=> 'Updated course from "'.$oldName.'" to "'.$request->name.'"',
			]);

		return redirect('courses/'.$slug);
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
			'name' 			=> 'required|min:6|max:255|unique:courses,name',
			'day' 			=> 'required',
			'start' 		=> 'required',
			'end' 			=> 'required',
			'instrument_id' => 'required',
			]);
	}
  
}

?>