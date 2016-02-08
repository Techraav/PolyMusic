<?php namespace App\Http\Controllers;
use App\Level;

class LevelController extends Controller {

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
		for ($i=0; $i < 11; $i++) { 
			if(!in_array($i, $values)){
				$levelNotUsed[] = $i;
			}
		}

		return view('admin.levels.index', compact('levels', 'levelNotUsed'));
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
	* Store a newly created resource in storage.
	*
	* @return Response
	*/
	public function store()
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

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{

	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{

	}
  
}

?>