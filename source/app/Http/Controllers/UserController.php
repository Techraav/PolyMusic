<?php namespace App\Http\Controllers;

use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\File;
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

		$clientName = '';
		if($request->file('profil_picture') != null)
		{
			$file = $request->file('profil_picture');
			$clientName = $file->getClientOriginalName();
		}

		if($clientName != '' && isset($request->check))
		{
			$ext = $file->getClientOriginalExtension();
			$destPath = public_path().'/img/profil_pictures';
			$fileName = strtolower($user->slug.'.'.$ext);

			File::delete($fileName);
			if($file->move($destPath, $fileName))
			{
				$user->update(['profil_picture'=> $fileName]);
			}
			else{
				Flash::error('Une erreur est survenue lors du chargement de votre photo de profil.');
			}
		}

		$user->update([
			'phone' 		=> $request->phone,
			'description'	=> $request->description,
			'school_year'	=> $request->school_year,
			'department_id'	=> $request->department_id,
			]);

		Flash::success('Les informations ont bien été modifiées.');

		makeModification('users', ucfirst($user->first_name).' '.ucfirst($user->last_name).' updated his information');

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
			'profil_picture' => 'mimes:png,jpeg'
			]);
	}
  
}

?>