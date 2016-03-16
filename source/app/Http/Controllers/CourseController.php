<?php namespace App\Http\Controllers;

use App\Course;
use App\Document;
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
		$courses = Course::orderBy('day')->with('manager','instrument', 'article', 'documents')->paginate(20);
		return view('courses.index', compact('courses'));
	}

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function adminIndex()
	{
		$courses = Course::orderBy('day')->with('manager', 'users', 'instrument', 'article', 'documents')->paginate(20);
		return view('admin.courses.index', compact('courses'));
	}

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function instrument($id)
	{
		$courses = Course::ofInstrument($id)->orderBy('day')->with('manager', 'users', 'instrument', 'article', 'documents')->paginate(20);
		$instrument = true;
		return view('admin.courses.index', compact('courses', 'instrument'));
	}

	public function documents($id)
	{
		$course = Course::with(['users' => function($query){ $query->where('level', 1);}, 'manager'])->find($id);

		if(empty($course))
		{
			Flash::error('Ce cours n\'existe pas.');
			return abort(404);
		}

		if(Auth::user()->level_id <= 3 && !($course->users->contains(Auth::user())))
		{
			Flash::error('Vous n\'avez pas les droits suffisants.');
			return Redirect::back();
		}

		$documents = Document::where('course_id', $id)->with('author')->paginate(15);
		return view('admin.courses.documents', compact('documents', 'course'));
	}

	public function documentsValidated($id, $value)
	{
		$course = Course::with(['users' => function($query){ $query->where('level', 1);}, 'manager'])->find($id);

		if(empty($course))
		{
			Flash::error('Ce cours n\'existe pas.');
			return abort(404);
		}

		if(Auth::user()->level_id <= 3 && !$course->users->contains(Auth::user()))
		{
			Flash::error('Vous n\'avez pas les droits suffisants.');
			return Redirect::back();
		}

		if($value != 0 && $value != 1)
		{
			Flash::error('Requête invalide.');
			return Redirect::back();
		}
		$documents  = Document::where('course_id', $id)->where('validated', $value)->with('author')->paginate(15);

		$filter = $value == 0 ? 'invalidés' : 'validés';

		return view('admin.courses.documents', compact('documents', 'filter', 'course'));
	}

	/**
	* Display the specified resource.
	*
	* @param  str $slug
	* @return Response
	*/
	public function show($slug)
	{
		$course = Course::where('slug', $slug)
						->with(['manager', 
								'instrument',
								'article' => function($query){ $query->with(['images' => function($query){ $query->limit(6);}]); },
								'users' => function($query){ $query->where('level', 0)->where('validated', 1)->orderBy('last_name')->limit(15); },	
								'teachers'	=> function($query){ $query->where('level', 1)->where('validated', 1)->orderBy('last_name')->limit(15); },	
							])
						->first();

		if(empty($course))
		{
			Flash::error('Ce cours n\'existe pas.');
			return abort(404);
		}

						
		if(Auth::check())
		{
			if($course->users->contains(Auth::user()) || $course->teachers->contains(Auth::user()) || Auth::user()->level_id > 3)
			{		
				$course->load(['documents' => function($query){ $query->orderBy('created_at', 'desc')->limit(3); }]);
				$course->load(['modifications' => function($query) { $query->with('user', 'author')->orderBy('created_at')->limit(10); }]);
			}		
		}				
		
		return view('courses.show', compact('course'));
	}

	/**
	* Display the specified resource.
	*
	* @param  str $slug
	* @return Response
	*/
	public function members($slug)
	{
		$course = Course::where('slug', $slug)->with('manager', 'instrument', 'article', 'documents')->first();

		if(empty($course))
		{
			Flash::error('Ce cours n\'existe pas.');
			return abort(404);
		}

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
		$course = Course::where('id', $id)->with('manager', 'users', 'instrument', 'article', 'documents')->first();

		if(empty($course))
		{
			Flash::error('Ce cours n\'existe pas.');
			return abort(404);
		}

		if(Auth::user()->id != $course->user_id && Auth::user()->level->level < 3)
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
			'category_id'	=> 2
			]);

		if(!isset($article))
		{
			Flash::errors("Erreur lors de la création de l'article concernant ce cours.");
			return Redirect::back();
		}

		$slug = $article->slug;

		$infos = $request->infos;
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

		if(Auth::user()->id != $course->user_id && Auth::user()->level->level < 3)
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