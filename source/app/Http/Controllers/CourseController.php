<?php namespace App\Http\Controllers;

use App\Course;
use App\Instrument;
use App\Document;
use App\User;
use App\Modification;
use App\CourseModification;
use App\Article;
use App\CourseUser;
use App\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
	public function index( $filter=false, $value=false )
	{
		$query = Course::orderBy('day', 'asc');
		if($filter != false && $value != false)
		{	
			$filter = $filter == 'manager' ? 'user_id' : $filter = 'isntrument' ? 'instrument_id' : $filter;
			$query = $query->where($filter, $value);
		}

		$courses = $query->with(['manager',
								'instrument', 
								'documents', 
								'users' => function($query){ $query->where('level', 0)->where('validated', 1)->orderBy('last_name'); },	
								'teachers'	=> function($query){ $query->where('level', 1)->where('validated', 1)->orderBy('last_name'); },
								])->paginate(20);	

		$allCourses = Course::with('manager', 'instrument')->get();

		return view('courses.index', compact('courses', 'allCourses', 'filter'));
	}

	/**
	*	Display the result of a search
	*	
	* @param $request Request
	* @return $users 		: users (not banned + teacher or more) matching
	* @return $instruments	: instrument matching
	* @return $coursesDay	: courses matching if the query is a day (numeric or text)
	* @return $coursesTitle : courses matching (title)
	*/
	public function search(Request $request)
	{
		$day = -1;
		$search = $request->search;
		$str = str_replace(' ', '_', $search);
		$users = [];
		if(!is_numeric($str))
		{
			$users = User::where('level_id', '>', 2)
							->where('banned', 0)
							->where('slug', 'LIKE', '%'.$str.'%')
							->with(['courses' => function($query) { $query->where('level', 1)->where('validated', 1); }])
							->get();
		}	
		$instruments = Instrument::where('name', 'LIKE', '%'.$search.'%')->with('courses')->get();
		if(is_numeric($str) && 0 < $str && $str < 7)
		{
			$day = $str;
			$coursesDay = Course::where('day', $str)->where('active', 1)->get();
		}
		else
		{
			$days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
			for ($i=0; $i<7 ; $i++) { 
				if(strtolower($str) == $days[$i])
					$day = $i;
			}

			$coursesDay = Course::where('day', $day)->where('active', 1)->get();
		}

		$coursesTitle = Course::where('active', 1)->where('name', 'LIKE', '%'.$str.'%')->get();

		return view('courses.search', compact('users', 'instruments', 'coursesDay', 'coursesTitle', 'search', 'day'));
	}

	// public function search(Request $request)
	// {
	// 	if($request->has('day'))
	// 	{
	// 		$search = 'day';
	// 		$value = $request->day;
	// 		$courses = Course::where('day', $request->day)->get();
	// 		return view('courses.search', compact('courses', 'search', 'value'));
	// 	}
	// 	elseif($request->has('teacherfn'))
	// 	{
	// 		$search = 'teacherfn';
	// 		$value = $request->teacherfn;
	// 		$str = str_search($value);

	// 		$result = User::where('first_name', 'LIKE', "%$str%")
	// 						->with(['courses' => function($query) { $query->where('validated', 1)->where('level', 1); }])
	// 						->get();
			
	// 		return view('courses.search', compact('result', 'search', 'value'));
	// 	}
	// 	elseif($request->has('teacherln'))
	// 	{
	// 		$search = 'teacherln';
	// 		$value = $request->teacherln;
	// 		$str = str_search($value);

	// 		$result = User::where('last_name', 'LIKE', "%$str%")
	// 						->with(['courses' => function($query) { $query->where('validated', 1)->where('level', 1); }])
	// 						->get();
			
	// 		return view('courses.search', compact('result', 'search', 'value'));
	// 	}
	// 	elseif($request->has('instrument'))
	// 	{
	// 		$search = 'instrument';
	// 		$value = $request->instrument;
	// 		$str = str_search($value);

	// 		$result = Instrument::where('name', 'LIKE', "%$str%")->with('courses')->get();
			
	// 		return view('courses.search', compact('result', 'search', 'value'));
	// 	}

	// 	return view('courses.search', ['error' => true]);
	// }

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function adminIndex()
	{
		$courses = Course::orderBy('day')
						->with(['manager',
							'instrument', 
							'article', 
							'documents', 
							'users' => function($query){ $query->where('level', 0)->where('validated', 1)->orderBy('last_name'); },	
							'teachers'	=> function($query){ $query->where('level', 1)->where('validated', 1)->orderBy('last_name'); }
							])
						->paginate(20);

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

	public function documents($slug)
	{
		$course = Course::where('slug', $slug)
						->with([
							'users' => function($query){ $query->where('validated', 1)->where('level', 0); },
							'teachers' => function($query){ $query->where('level', 1)->where('validated', 1); }
								])
						->first();
		if(empty($course))
		{
			Flash::error('Ce cours n\'existe pas !');
			abort(404);		
		}
			
		$isTeacher = $course->teachers->contains(Auth::user());
		if(Auth::user()->id != $course->user_id && !$isTeacher && $course->active == 0)
		{
			Flash::error('Vous n\'avez pas accès à ce contenu.');
			return Redirect::back();
		}

		if(Auth::user()->id == $course->user_id || $isTeacher)
		{
			$documents = Document::where('course_id', $course->id)->with('author')->paginate(10);
		}
		else
		{
			$documents = Document::where('course_id', $course->id)->validated()->paginate(10);
		}

		return view('courses.documents', compact('course', 'documents'));
	}

	public function adminDocuments($id)
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
								'users' => function($query){ $query->where('level', 0)->where('validated', 1)->orderBy('last_name'); },	
								'teachers'	=> function($query){ $query->where('level', 1)->where('validated', 1)->orderBy('last_name'); },	
								'unvalidatedUsers'	=> function($query){ $query->where('level', 0)->where('validated', 0); },	
								'unvalidatedTeachers'	=> function($query){ $query->where('level', 1)->where('validated', 0); },	
							])
						->first();

		if(empty($course))
		{
			Flash::error('Ce cours n\'existe pas.');
			return abort(404);
		}

		//Si l'utilisateur est connecte et qu'il fait partie des professeurs de ce cours				
		if(Auth::check())
		{
			if($course->users->contains(Auth::user()) || $course->teachers->contains(Auth::user()) || Auth::user()->level_id > 3)
			{		
				$course->load(['documents' => function($query){ $query->validated()->orderBy('created_at', 'desc')->limit(5); }]);
				$course->load(['modifications' => function($query) { $query->with('user', 'author')->orderBy('created_at', 'desc')->limit(10); }]);
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
		$course = Course::where('slug', $slug)
						->with([ 'manager',
								 'instrument',
								 'article',
								 'documents',
								 'users' => function($query){ $query->where('level', 0)->where('validated', 1)->orderBy('last_name'); },
								 'teachers' => function($query){ $query->where('level', 1)->where('validated', 1)->orderBy('last_name'); },
								 'waitingStudents' => function($query){ $query->where('level', 0)->where('validated', 0)->orderBy('created_at', 'desc'); },
								 'waitingTeachers' => function($query){ $query->where('level', 1)->where('validated', 0)->orderBy('created_at', 'desc'); },
							 ])
						->first();

		if(empty($course))
		{
			Flash::error('Ce cours n\'existe pas.');
			return abort(404);
		}

		return view('admin.courses.members', compact('course'));
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
		$course = Course::where('id', $id)->with('manager', 'instrument', 'article', 'documents')->first();

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
//                          POST FUNCTIONS 
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

		$article = createWithSlug(Article::class, [
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
		$course = createWithSlug(Course::class, [
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


	public function userManagement(Request $request)
	{
		$course_id = $request->course_id;
		$user_id = $request->user_id;
		$value = $request->value;

		$course = Course::find($course_id);
		$user = User::find($user_id);

		// dd($request->all());

		if($request->value < 0)
		{
			$level = $request->value*(-1)-1;

			if(Hash::check($request->password, $user->password))
			{
				$userCourse = CourseUser::where('course_id', $course_id)->where('user_id', $user_id)->where('level', $level)->first();
				if($userCourse->delete())
				{
					$course->leaveNotification($level, $user);
					makeCourseModification($user_id, $course_id, 2);
					Flash::success('Vous avez bien été retiré de ce cours.');
					return Redirect::back();
				}
			}
			Flash::error('Action impossible : mauvais mot de passe.');
			return Redirect::back();	

		}

		$array = [ 'user_id'	=> 'required|integer', 
				   'course_id'	=> 'required|integer',
				   'message'	=> 'max:255',
				   ];

		$validator = Validator::make($request->all(), $array);

		if($validator->fails())
		{
			Flash::error('Action impossible. Veuillez réessayer, si le problème persiste, contactez un administrateur.');
			return Redirect::back();
		}

		$message = $request->message;
		$level = $request->value-1;

		CourseUser::create([
			'user_id'	=> $user_id,
			'course_id'	=> $course_id,
			'level'		=> $level,
			'message'	=> $message
			]);

		$course->joinNotification();

		makeCourseModification($user_id, $course_id, 0);

		Flash::success('Votre demande a bien été prise en compte.');
		return Redirect::back();
	}

    public function toggle(Request $request)   
    {
        $model = Course::find($request->id);
        $model->active = $model->active == 0 ? 1 : 0;
        $model->save();
        Flash::success('Le cours a bien été '.( $model->active == 1 ? 'activé' : 'suspendu').'.');
        return Redirect::back();
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
	* @param  Request $request
	* @return Response
	*/
	public function destroy(Request $request)
	{
		$model = Course::find($request->id);
		if(empty($model))
		{
			Flash::error('Impossible de supprimer ce cours.');
			return Redirect::back();
		}

		$name = $model->name;
		$model->delete();

		makeModification('courses', 'The course &laquo; '.$name.' &raquo; has been removed.');
		Flash::success('Le cours a bien été supprimé.');
		return Redirect::back();
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