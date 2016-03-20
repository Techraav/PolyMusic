<?php namespace App\Http\Controllers;

use App\CourseUser;
use App\User;
use App\Modification;
use App\CourseModification;
use App\Band;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class StudentController extends Controller {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{

	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{

	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id)
	{

	}

	public function downgrade(Request $request, $course_id)
	{
		$course = Course::find($course_id);
		$user = User::find($request->user_id);
		$user_id = $request->user_id;

		$user->courses()->updateExistingPivot($course_id, ['level' => 0]);
		$test = CourseUser::where('user_id', $user_id)->where('level', 1)->count();
		if($test == 0 && $user->level->level == 2)
		{
			if(!empty(Band::where('user_id', $user_id)->first()))
			{
				$user->level_id = 2;
			}
			else
			{
				$user->level_id = 1;
			}

			makeModification('users', printUserLinkV2($user).' is no longer a teacher.');
			$user->save();
		}

		CourseModification::create([
			'author_id'	=> Auth::user()->id,
			'user_id'	=> $user_id,
			'course_id'	=> $id,
			'value'		=> 5,
			]);

		Flash::success("$user->first_name $user->last_name est maintenant un élève du cours ucfirst($course->name)");
		return redirect('admin/courses/'.$course->slug.'/members');
	}

	public function accept(Request $request, $id)
	{
		$course = Course::find($id);
		$manager = $course->user_id;
		if(Auth::user()->id != $manager && Auth::user()->level->level < 3)
		{
			Flash::error("Vous n'avez pas l'autorisation pour ça !");
			return Redirect::back();
		}

		$user_id = $request->user_id;
		$pivot = CourseUser::where('user_id', $user_id)->where('course_id', $id)->where('validated', 0)->where('level', 0)->first();
		$pivot->validated = 1;
		$pivot->save();

		// $course->users()->updateExistingPivot($user_id, ['validated' => 1]);

		CourseModification::create([
			'author_id'	=> Auth::user()->id,
			'user_id'	=> $user_id,
			'course_id'	=> $id,
			'value'		=> 3,
			]);

		$user = User::find($user_id);
		$user->sendNotification('Votre demande d\'inscription au cours &laquo; '.ucfirst($course->name).' &raquo; à été <b>acceptée</b> !', 'courses/show/'.$course->slug);

		return Redirect::back();
	}

	public function remove(Request $request, $id)
	{
		$course  = Course::find($id);
		$manager = $course->user_id;

		if(Auth::user()->id != $manager && Auth::user()->level->level < 3)
		{
			Flash::error("Vous n'avez pas l'autorisation pour ça !");
			return Redirect::back();
		}

		$user_id = $request->user_id;
		$pivot = CourseUser::where('user_id', $user_id)->where('course_id', $id)->where('level', 0)->first();

		if(!empty($pivot))
		{	
			$pivot->delete();
		}

		CourseModification::create([
			'author_id'	=> Auth::user()->id,
			'user_id'	=> $user_id,
			'course_id'	=> $id,
			'value'		=> 2,
			]);

		$user = User::find($user_id);
		$user->sendNotification('Vous avez été retiré du cours &laquo; '.ucfirst($course->name).' &raquo;.', 'courses/show/'.$course->slug);

		return Redirect::back();
	}

	public function cancel(Request $request, $course_id)
	{
		$course = Course::find($course_id);
		$user 	= User::find($request->user_id);

		$pivot = CourseUser::where('user_id', $user->id)->where('course_id', $course_id)->where('level', 0)->first();
		if(!empty($pivot))
		{	
			$pivot->delete();
		}

		CourseModification::create([
			'author_id'	=> Auth::user()->id,
			'user_id'	=> $user->id,
			'course_id'	=> $course_id,
			'value'		=> 2,
			]);

		$user->sendNotification('Votre de demande d\'inscription au cours &laquo; '.ucfirst($course->name).' &raquo; a été <b>refusée</b>.', 'courses/show/'.$course->slug);

		return Redirect::back();
	}

	/**
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store(Request $request, $course_id)
	{

	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{

	}

	public function signUp($course_id)
	{
		$course = Course::find($course_id);
		$user_id = Auth::user()->id;
		$course->users()->sync($user_id);

		CourseModification::create([
			'author_id' => Auth::user()->id,
			'user_id'	=> $user_id,
			'course_id'	=> $course_id,
			'value'		=> 0
			]);

		Flash::success('Votre demande d\'inscription au cours '.ucfirst($course->name).' a bien été enregistrée. Elle devrait être traitée rapidement.');
		return Redirect::back();
	}

	public function postCancel($course_id)
	{
		$course = Course::find($course_id);
		$user_id = Auth::user()->id;
		$course->users()->detach($user_id);

		CourseModification::create([
			'author_id' => Auth::user()->id,
			'user_id'	=> $user_id,
			'course_id'	=> $course_id,
			'value'		=> 1
			]);

		Flash::success("L'annulation de votre inscription au cours ucfirst($course->name) à bien été prise en compte.");
		return redirect('courses');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($course_id)
	{

	}
  
}

?>