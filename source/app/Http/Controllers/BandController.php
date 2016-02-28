<?php namespace App\Http\Controllers;

use App\Band;
use App\Article;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;

class BandController extends Controller {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function index()
	{
		$bands = Band::validated()->orderBy('name')->paginate(10);
		return view('admin.bands.index', compact('bands'));
	}

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function adminIndex()
	{
		$bands = Band::orderBy('name')->paginate(20);
		return view('admin.bands.index', compact('bands'));
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create()
	{
		return view('bands.create');
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
			Flash::error('Impossible de créer le groupe. Veuillez vérifier les informations reneignées.');
			return Redirect::back()->withErrors($validator->errors());
		}

		$name = $request->name;
		$infos = $request->infos;
		$manager = Auth::user()->id;

		$band = Band::createWithSlug([
			'name'	=> $name,
			'infos'	=> $infos,
			'manager' => $manager,
			]);
		
		$article = Article::createWithSlug([
			'title'	=> $name,
			'user_id'	=> $manager,
			'category_id'	=> 2
			]);

		makeModification('bands', 'band '.ucfirst($name).' has been created. Waiting for validation.');

		Flash::success('Votre groupe a bien été créé !');
		Flash::info('Vous êtes maintenant le Manager du groupe '.$name.'.');

		return redirect('articles/edit/'.$article->slug);
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($slug)
	{
		$band = Band::where('slug', $slug)->first();
		return view('bands.show', compact('band'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id)
	{
		$band = Band::find($id);
		if(Auth::user()->id != $band->manager() && Auth::user()->level_id < 3)
		{
			Flash::error('Vous n\'avez pas les droits suffisants pour modifier ce groupe.');
			return redirect('bands');
		}

		return view('bands.edit', compact('bands'));
	}

	public function manage($id)
	{
		$band = Band::find($id);
		if($band->manager() != Auth::user()->id && Auth::user()->level < 2)
		{
			Flash::error("Vous ne disposez pas des droits suffisant gérer ce groupe.");
			return Redirect::back();
		}

		return view('band.manage', compact('band'));
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update(Request $request, $id)
	{
		$band = Band::find($id);

		$validator =  $this->validator($request->all());

		if($validator->fails())
		{
			Flash::error('Impossible de modifier le groupe. Veuillez vérifier les informations renseignées.');
			return Redirect::back()->withErrors($validator->errors());
		}

		$slug = str_slug($request->name).'-'.$band->id;

		$band = $band->update([
			'name'		=> $request->name,
			'infos'		=> $request->infos,
			'user_id'	=> $request->user_id,
			'slug'		=> $slug,
			'validated' => isset($request->validated)
			]);

		makeModification('bands', 'Modified band '.ucfirst($request->name));

		Flash::success('Les informations du groupe ont bien été modifiées');
		// return redirect('bands/show/'.$slug);
		return Redirect::back();

	}

	public function addMember(Request $request, $id)
	{
		$band = Band::find($id);

		$band->members()->sync($request->user_id, ['instrument_id' => $request->instrument_id]);

		Flash::success('Le membre a bien été ajouté au groupe ! ');
		return Redirect::back();
	}

	public function removeMember(Request $request, $id)
	{
		$band = Band::find($id);

		$band->members()->detach($request->user_id);

		Flash::success('Le membre a bien été retiré du groupe ! ');
		return Redirect::back();
	}
	/**
	* Remove the specified resource from storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		$band = Band::find($id);
		$band->delete();

		Flash::success('Le groupe a bien été supprimé.');
		return redirect('bands');
	}

	protected function validator($data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255'
			]);
	}
  
}

?>