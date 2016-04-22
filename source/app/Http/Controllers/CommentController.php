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
		$validator = Validator::make($request->all(), [
			'comment_content'	=> 'required|min:6',
			]);

		if($validator->fails())
		{
			Flash::error('Impossible d\'ajouter le commentaire.');
			return Redirect::back()->withErrors($validator->errors());
		}

		$content = $request->comment_content;
		
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
		$comment = Comment::find($id);
		return view('announcements.comment-edit', compact('comment'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update(Request $request, $id)
	{
		$comment = Comment::with('announcement')->find($request->id);
		if($comment->user_id != Auth::user()->id && Auth::user()->level->level < 4)
		{
			Flash::error("Vous ne disposez pas des droits suffisants pour effectuer ceci !");
			return Redirect::back();
		}

		$content = $request->content;

		$comment->update(['content'	=> $content]);

		Flash::success('Votre commentaire a bien été modifié !');

		return redirect('announcements/view/'.$comment->announcement->slug);
	}

	public function destroy(Request $request)
	{
		$model = Comment::find($request->id);
		if(empty($model) || ($model->user_id != Auth::user()->id && Auth::user()->level_id < 3))
		{
			Flash::error('Impossible de supprimer ce commentaire.');
			return Redirect::back();
		}

		$model->delete();

		Flash::success('Votre commentaire a bien été supprimé.');
		return Redirect::back();
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