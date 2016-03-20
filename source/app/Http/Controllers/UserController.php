<?php namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index(Request $request)
	{
		
		$users = User::orderBy('last_name')->with('department', 'level', 'courses')->paginate(20);
	 	return view('admin.users.index', compact('users'));
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($slug)
	{
		$user = User::where('slug', $slug)->with('level', 'department', 'courses')->first();
		if(empty($user))
		{
			Flash::error('Cet utilisateur n\'existe pas.');
			return view('error.404');
		}

		return view('users.show', compact('user'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($slug)
	{
		if(Auth::user()->slug != $slug && Auth::user()->level->level < 3)
		{
			Flash::error('Vous ne pouvez pas modifier ce profil.');
			return Redirect::back();
		}

		$user = User::where('slug', $slug)->with('department', 'level', 'courses')->first();

		if(empty($user))
		{
			Flash::error('Cet utilisateur n\'existe pas.');
			return view('error.404');
		}

	  return view('users.edit', compact('user'));	
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update(Request $request)
	{
		$user = User::find($request->id);

		$validation = $this->validator($request->all());

		if($validation->fails())
		{
			Flash::error('Impossible de mettre à jour les informations. Veuillez vérifier les données renseignées.');
			return Redirect::back();
		}

		$file = $request->file('profil_picture');
		$ext = $file->getClientOriginalExtension();
		$clientName = $file->getClientOriginalName();
		$destPath = public_path().'/img/profil_pictures';
		$fileName = $request->id.Auth::user()->first_name.Auth::user()->last_name;

		if($file->move($destPath, $fileName))
		{
			$user->update([
			'phone' 		=> $request->phone,
			'profil_picture'=> $request->profil_picture,
			'description'	=> $request->description,
			'school_year'	=> $request->school_year,
			'department_id'	=> $request->department_id,
			]);

			makeModification('users', ucfirst(Auth::user()->first_name).' '.ucfirst(Auth::user()->last_name).' updated his information');

			Flash::success('Les informations ont bien été modifiées.');
		}
		else{
			Flash::error('Une erreur est survenue.');
		}

		return redirect('users/'.$user->slug);
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		$user = User::find($id)->first();
		$user->banish();
		return redirect('admin.users');
	}

	public function validator($data)
	{
		return Validator::make($data, [
			'phone'	=> ["regex:/(\(\+33\)|0|\+33|0033)[1-9]([0-9]{8}|([0-9\- ]){12})/"],
			'description'	=> 'max:1000',
			'profil_picture' => 'mimes:jpg,png,jpeg'
			]);
	}
  
}

?>