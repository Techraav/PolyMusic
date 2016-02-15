<?php namespace App\Http\Controllers;

use App\Department;
use App\User;
use App\Modification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;


class DepartmentController extends Controller {


// ________________________________________________________________
//
//                          GET FUNCTIONS 
// ________________________________________________________________  

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$departments = Department::orderBy('name')->paginate(20);
		return view('admin.departments.index', compact('departments'));
	}

	public function members($id)
	{
		$department = Department::where('id', $id)->first();
		if(empty($department))
		{
			Flash::error('Ce département n\'existe pas.');
			return view('admin.errors.404');
		}
		$users = User::where('department_id', $id)->orderBy('last_name')->paginate(30);

		return view('admin.departments.members', compact('department', 'users'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id)
	{
		if($id == 1)
		{
			Flash::error('Il est interdit de modifier ce département.');
			return Redirect::back();
		}
		$departments = Department::orderBy('name')->paginate(20);
		$depToEdit = Department::where('id', $id)->first();

		return view('admin.departments.edit', compact('departments', 'depToEdit'));
	}

// ________________________________________________________________
//
//                          POST FUNCTIONS 
// ________________________________________________________________  

	public function removeMember(Request $request, $id)
	{	
		$dep = Department::where('id', $id)->first();

		$user = User::where('id', $request->user_id)->first();
		$user->update([	'department_id'	=> 1 ]);

		Modification::create([
			'table'		=> 'departments',
			'user_id'	=> Auth::user()->id,
			'message'	=> 'removed '.$user->first_name.' '.$user->last_name.' from department '.$dep->name.' ('.$dep->short_name.')']);

		Flash::success($user->first_name.' '.$user->last_name.' a bien été retiré du '.$dep->name.' ('.$dep->short_name.')');
		return Redirect::back();
	}
	

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
			Flash::error('Impossible d\'ajouter ce département.');
			Return Redirect::back()->withErrors($validator->errors());
		}

		$dep = Department::create([
			'name'		=> $request->name,
			'short_name'=> $request->short_name,
			]);

		Modification::create([
			'table'		=> 'departments',
			'user_id'	=> Auth::user()->id,
			'message'	=> 'added department '.$request->name.' ('.$request->short_name.')']);

		Flash::success('Le département a bien été créé !');
		return redirect('admin/departments'); 
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update(Request $request, $id)
	{
		if($id == 1)
		{
			Flash::error('Il est interdit de modifier ce département.');
			return Redirect::back();
		}
		$department = Department::where('id', $id)->first();
		$name = $department->name;
		$short_name = $department->short_name;
		$department->update(['name'	=> $request->name,	'short_name'	=> $request->short_name]);

		Modification::create([
			'table'		=> 'departments',
			'user_id'	=> Auth::user()->id,
			'message'	=> 'updated department '.$name.' ('.$short_name.') to '.$request->name .' ('.$request->short_name.')'
			]);

		Flash::success('Départment modifié avec succès !');
		return redirect('admin/departments'); 

	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		$dep = Department::where('id', $id)->first();
		$name = $dep->name;
		$short_name = $dep->short_name;

		$users = User::where('department_id', $id)->get();
		if(!empty($users))
		{
			foreach($users as $u)
			{
				$u->update(['department_id' => 1]);
			}
		}

		Department::where('id', $id)->delete();
		$test = Department::where('id', $id)->first();
		if(empty($test))
		{
			Flash::success('Département supprimé avec succès.');

			Modification::create([
				'table'		=> 'departments',
				'user_id'	=> Auth::user()->id,
				'message'	=> 'removed department '.$name.' ('.$short_name.')']);
		}
		else
			Flash::error('Impossible de supprimer ce département.');

		return redirect('admin/departments'); 

	}

// ________________________________________________________________
//
//                          	HELPERS 
// ________________________________________________________________  

	protected function validator($data)
	{
		return Validator::make($data, [
			'name'			=> 'required|unique:departments,name',
			'short_name'	=> 'required|unique:departments,short_name'
			]);
	}
  
}

?>