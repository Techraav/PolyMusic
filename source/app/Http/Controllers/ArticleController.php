<?php namespace App\Http\Controllers;

use App\Article;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class ArticleController extends Controller {

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
		$articles = Article::orderBy('id', 'desc')->with('author', 'category')->paginate(20);
		return view('articles.index', compact('articles'));    
	}

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function adminIndex($category = false)
	{
		if($category != false)
		{
		    $articles = Article::where('category_id', $category)->with('author', 'category')->orderBy('id', 'desc')->paginate(15);
		    $category = Category::find($category)->name;
		}
		else
		{
		    $articles = Article::orderBy('id', 'desc')->with('author', 'category')->paginate(15);
		}
		return view('admin.articles.index', compact('articles', 'category'));    
	}

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	public function adminIndexValidated($value)
	{
		if($value != 0 && $value != 1)
		{
			Flash::error('Valeur incorrecte, impossible de charger les articles validés/invalidés.');
			return redirect('admin/articles');
		}
		$articles = Article::where('validated', $value)->with('author', 'category')->paginate(15);
		return view('admin.articles.index', compact('articles'));    
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return Response
	*/
	public function create()
	{
		return view('admin.articles.create');
	}

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($slug)
	{
		$article = Article::where('slug', $slug)->with('author', 'category')->first();
		if(empty($article) || ($article->validated == 0 && (Auth::guest() || Auth::user()->level_id < 3)))
		{
		  Flash::error('Cet article n\'existe pas.');
		  return view('errors.404');
		}

		return view('articles.show', compact('article'));
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($slug)
	{
		$article = Article::where('slug', $slug)->with('author', 'category')->first();
		if(Auth::user()->id != $article->user_id && Auth::user()->level->level < 3)
		{
		  Flash::error("Vous n'avez pas le droit de modifier cet article !");
		  return view('errors.404');
		}
		return view('admin.articles.edit', compact('article'));
	}

	/**
	* Display news removing form
	* @param $slug news' slug
	* @return news.delete view
	*/
	public function delete($slug)
	{
		$article = Article::where('slug', $slug)->with('author', 'category')->first();
		if(empty($article))
		{
		  Flash::error('Cet article n\'existe pas ou a déjà été supprimé.');
		  return view('errors.404');
		}

		return view('admin.articles.delete', compact('article'));
	}


	// ________________________________________________________________
	//
	//                         POST REQUESTS
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
		  Flash::error('Impossible de créer l\'article. Veuillez vérifier les champs renseignés.');
		  return Redirect::back()->withErrors($validator->errors());
		}

		$article = createWithSlug(Article::class, [
		  'user_id'   => Auth::user()->id,
		  'title'     => $request->title,
		  'subtitle'  => $request->subtitle,
		  'content'   => $request->content,
		  ]);

		Flash::success('Votre article a bien été créé');
		return redirect('articles/view/'.$article->slug);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($slug)
	{
		$validation = $this->validator($request->all());

		if($validation->fails())
		{
		  Flash::error('Impossible de modifier l\'article. Veuillez vérifier les champs renseignés.');
		  return Redirect::back()->withErrors($validation->errors());
		}

		$article = Article::where('slug', $slug)->first();

		if(Auth::user()->id != $article->user_id && Auth::user()->level->level < 3)
		{
		  Flash::error("Vous n'avez pas le droit de modifier cet article !");
		  return redirect('admin/articles');
		}

		$oldName = $article->name;

		$slug = str_slug($request->name).'-'.$article->id;

		$article->update([
		  'user_id'   => Auth::user()->id,
		  'slug'      => $slug,
		  'title'     => $request->title,
		  'subtitle'  => $request->subtitle,
		  'content'   => $request->content,
		  ]);

		Modification::create([
		  'table'   => 'articles',
		  'user_id' => Auth::user()->id,
		  'message' => 'Created article "'.$request->name.'".',
		  ]);
	}

    public function toggle(Request $request)   
    {
        $model = Article::find($request->id);
        $model->validated = $model->validated == 0 ? 1 : 0;
        $model->save();
        Flash::success('L\'article a bien été '.( $model->validated == 1 ? 'validé' : 'invalidé').'.');
        return Redirect::back();
    }

	public function destroy(Request $request)
	{
		$model = Article::find($request->id);
		if(empty($model))
		{
			Flash::error('Impossible de supprimer cet article.');
			return Redirect::back();
		}

		$title = $model->title;
		$model->delete();

		makeModification('articles', 'The article &laquo '.$title.' &raquo has been removed.');
		Flash::success('L\'article a bien été supprimé.');
		return Redirect::back();
	}

	/** 
	* Check if $data respects the rules
	* @param $data inputs
	* @return true/false
	*/
	protected function validator($data)
	{
		return Validator::make($data, [
		  'title'     => 'required|min:6|max:255',
		  'subtitle'  => 'required|min:6|max:255',
		  'content'   => 'required|min:15',
		  ]);
	}

}

?>