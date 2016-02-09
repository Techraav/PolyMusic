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
		$levels = Level::orderBy('level', 'asc')->get();
		$values = [];
		foreach ($levels as $k) {
			$values[] = $k->level;
		}
		$levelNotUsed = [];
		$levelMax = Level::where('name', 'webmaster')->first()->level;
		for ($i=0; $i <= $levelMax; $i++) { 
			if(!in_array($i, $values)){
				$levelNotUsed[] = $i;
			}
		}

		return view('admin.levels.index', compact('levels', 'levelNotUsed'));
	}

	/**
	* Display members list
	* 
	* @param $name of the level
	* @return list of members
	*/
	public function members($name)
	{	
		$level = Level::where('name', $name)->first()->level;
		if(!isset($level))
		{
			Flash::error('Ce niveau n\'existe pas.');
			return view('admin.errors.404');
		}
		$users = User::where('level', $level)->orderBy('last_name')->get();

		return view('admin.levels.members', compact('name', 'level', 'users'));
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
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($level)
	{

	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($level)
	{

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
			Flash::error('Impossible d\'ajouter ce level.');
			Return Redirect::back()->withErrors($validator->errors());
		}

		$level = Level::create([
			'level'	=> $request->level,
			'name'	=> $request->name,
			'infos'	=> $request->infos,
			]);

		Flash::success('Le level a bien été créé !');
		return Redirect::back(); 
	}

	public function removeMember(Request $request, $name)
	{	
		$user = User::where('id', $request->user_id)->first();
		$user->update([	'level'	=> 0 ]);

		Modification::create([
			'table'		=> 'levels',
			'user_id'	=> Auth::user()->id,
			'message'	=> 'remove '.$user->first_name.' '.$user->last_name.' from '.ucfirst($name).'s']);

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

	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($level)
	{

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