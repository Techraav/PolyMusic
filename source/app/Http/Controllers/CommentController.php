<?php namespace App\Http\Controllers;

use App\Announcement;
use App\Comment;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{

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
	public function store(Request $request)
	{
		$validator = $this->validator($request->all());
		if($validator->fails())
		{
			Flash::error('Impossible d\'ajouter le commentaire.');
			return Redirect::back()->withErrors($validator->errors());
		}

		$content = $request->content;
		
		Comment::create([
			'announcement_id'	=> $request->announcement_id,
			'user_id'			=> Auth::user()->id,
			'content'			=> $content,
			]);

		Flash::success('Votre commentaire a bien été ajouté.');
		return Redirect::back();
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

// ____________________________________________________________________________________________________
//
//                                             HELPERS
// ____________________________________________________________________________________________________

	protected function validator($data) 
	{
		return Validator::make($data, [
			'content'	=> 'required|min:6',
			]);
	}
}

?>