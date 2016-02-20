<?php namespace App\Http\Controllers;

use App\CourseUser;
use App\User;
use App\CourseModification;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class TeacherController extends Controller {
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

	public function upgrade(Request $request, $course_id)
	{
		$course = Course::find($course_id);
		$user = User::find($request->user_id);
		$user_id = $request->user_id;

		$user->courses()->updateExistingPivot($course_id, ['level' => 1]);

		if($user->level < 2)
		{
			$user->level = 2;
			$user->save();
		}

		CourseModification::create([
			'author_id'	=> Auth::user()->id,
			'user_id'	=> $user_id,
			'course_id'	=> $id,
			'value'		=> 4,
			]);

		Flash::success("$user->first_name $user->last_name est maintenant un élève du cours ucfirst($course->name)");
		return redirect('admin/courses/'.$course->slug.'/members');
	}

	public function accept(Request $request, $id)
	{
		$course = Course::find($id);
		$manager = $course->user_id;
		if(Auth::user()->id != $manager && Auth::user()->level < 3)
		{
			Flash::error("Vous n'avez pas l'autorisation pour ça !");
			return Redirect::back();
		}

		$user_id = $request->user_id;
		$course->users()->updateExistingPivot($user_id, ['validated' => 1]);

		$user = User::find($user_id);
		if($user->level < 2)
		{
			$user->level = 2;
			$user->save();
		}

		CourseModification::create([
			'author_id'	=> Auth::user()->id,
			'user_id'	=> $user_id,
			'course_id'	=> $id,
			'value'		=> 3,
			]);

		return Redirect::back();
	}

	public function remove(Request $request, $id)
	{
		$course  = Course::find($id);
		$manager = $course->user_id;

		if(Auth::user()->id != $manager && Auth::user()->level < 3)
		{
			Flash::error("Vous n'avez pas l'autorisation pour ça !");
			return Redirect::back();
		}

		$user_id = $request->user_id;
		$course->users()->detach($user_id);

		CourseModification::create([
			'author_id'	=> Auth::user()->id,
			'user_id'	=> $user_id,
			'course_id'	=> $id,
			'value'		=> 2,
			]);

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

		Flash::success('Votre demande d\'inscription au cours '.ucfirst($course->name).' en tant que professeur a bien été enregistrée. Elle devrait être traitée rapidement.');
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

		Flash::success("L'annulation de votre demande de devenir un professeur du cours ucfirst($course->name) à bien été prise en compte.");
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