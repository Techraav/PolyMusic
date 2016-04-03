<?php namespace App\Http\Controllers;
use App\Level;
use App\User;
use App\Modification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class LevelController extends Controller {


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
		$levels = Level::orderBy('level', 'asc')->with('users')->paginate(20);

		return view('admin.levels.index', compact('levels'));
	}

	/**
	* Display members list
	* 
	* @param $name of the level
	* @return list of members
	*/
	public function members($id)
	{	
		$level = Level::where('id', $id)->with('users')->first();
		$name = $level->name;
		if(!isset($level))
		{
			Flash::error('Ce level n\'existe pas.');
			return view('admin.errors.404');
		}
		$users = User::where('level_id', $id)->orderBy('last_name')->paginate(30);
		return view('admin.levels.members', compact('level', 'name', 'users'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($level)
	{
		$levels = Level::orderBy('level', 'asc')->with('users')->paginate(20);
		$levelToEdit = Level::where('level', $level)->first();
	
		return view('admin.levels.edit', compact('levels', 'levelToEdit'));
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
		/*$validator = $this->validator($request->all());
		if($validator->fails())
		{
			Flash::error('Impossible d\'ajouter ce level.');
			Return Redirect::back()->withErrors($validator->errors());
		}

		$level = Level::create([
			'level'	=> $request->level,
			'name'	=> $request->name,
			'infos'	=> $request->infos,
			]);

		Modification::create([
			'table'		=> 'levels',
			'user_id'	=> Auth::user()->id,
			'message'	=> 'added level '.$request->name.' (level: '.$request->level.')']);

		Flash::success('Le level a bien été créé !');
		return redirect('admin/levels'); */
	}

	public function removeMember(Request $request, $id)
	{	
		$user = User::find($request->id);
		$user->update([	'level_id'	=> 1 ]);
		$user->sendNotification('Vous êtes maintenant <b>Membre</b>.');

		$name = Level::find($id)->name;

		Modification::create([
			'table'		=> 'levels',
			'user_id'	=> Auth::user()->id,
			'message'	=> 'removed '.$user->first_name.' '.$user->last_name.' from level '.ucfirst($name).'s']);

		Flash::success($user->first_name.' '.$user->last_name.' a bien été retiré des '.ucfirst($name).'s');
		return Redirect::back();
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update(Request $request, $level)
	{
		$name = Level::where('level', $level)->first()->name;
		$level = Level::where('level', $request->level)->first();

		$msg = 'Level '.$level->level.': ';
		$msg .= $level->name != $request->name ? 'Renamed  "'.$name.'" -> "'.$request->name.'". ' : '';
		$msg .= $level->infos != $request->infos ? 'Modified information' : '';


		$level->update(['name'	=> $request->name,	'infos'	=> $request->infos]);

		makeModification('levels', $msg);

		Flash::success('Level modifié avec succès !');
		return redirect('admin/levels');
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($level)
	{
		/*$name = Level::where('level', $level)->first()->name;
		$users = User::where('level', $level)->get();
		if(!empty($users))
		{
			foreach($users as $u)
			{
				$u->update(['level', 0]);
			}
		}
		Level::where('level', $level)->delete();
		$test = Level::where('level', $level)->first();
		if(empty($test))
		{
			Flash::success('Level supprimé avec succès.');

			Modification::create([
				'table'		=> 'levels',
				'user_id'	=> Auth::user()->id,
				'message'	=> 'removed level '.$name.' (level: '.$level.')']);
		}
		else
			Flash::error('Impossible de supprimer ce level.');

		return redirect('admin/levels'); */
	}

// ________________________________________________________________
//
//                          	HELPERS 
// ________________________________________________________________  

	protected function validator($data)
	{
		return Validator::make($data, [
			'level'		=> 'required|unique:levels',
			'name'		=> 'required|unique:levels'
			]);
	}
}

?>