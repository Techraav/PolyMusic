<?php namespace App\Http\Controllers;

use App\User;
use App\Level;
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

	public function updateLevel(Request $request)
	{
		$user = User::with(['level', 'courses' => function($query){ $query->where('level', '1')->where('validated', 1); }])->where('id', $request->id)->first();
		$oldLevel = ucfirst($user->level->name);

		if(Auth::check())
		{	
			if(Auth::user()->id != $user->id)
			{
				if(Auth::user()->level_id == 5 || (Auth::user()->level_id == 4 && $user->level_id < 4 ))
				{
					if($request->level < 3 && $user->courses->count() > 0)
					{
						Flash::error('Impossible de rétrograder cet utilisateur à ce level car il est professeur de '. $user->courses->count() .' cours.');
						return Redirect::back();
					}

					$newLevel = ucfirst(Level::find($request->level)->name);
					$modif = $user->level_id > $request->level ? 'downgraded' : 'upgraded';
					$user->level_id = $request->level;
					$user->save();
					Flash::success('Le changement a été effectué avec succès.');
					makeModification('users', printUserLinkV2($user).' as been '.$modif.' from '.$oldLevel.' to '.$newLevel.'.');
					return Redirect::back();
				}
			}
		}

		Flash::error('Vous n\'avez pas les droits nécéssaires pour cela.');
		return Redirect::back();
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

		if($clientName != '')
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
		return redirect('users/'.$user->slug);
	}

	public function removeImage(Request $request)
	{
		$user = User::find($request->id);

        if(empty($user->profil_picture))
        {
            Flash::error('Cette image n\'existe pas.');
            return Redirect::back();
        }

        $name = $user->profil_picture;
        $path = public_path().'/img/profil_pictures/'.$name;

        if(!File::delete($path))
        {
            Flash::error('Cette image n\'a pas été supprimée.');
            return Redirect::back();
        }

        $image = User::$defaultImage;
        $user->update(['profil_picture'=> $image]);

        Flash::success('La photo de profil a bien été supprimée.');
        return Redirect::back();


	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy(Request $request)
	{
		$user = User::find($request->id);
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