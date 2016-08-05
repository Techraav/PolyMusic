<?php namespace App\Http\Controllers;

use App\Article;
use App\Image;
use App\Modification;
use App\Category;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\File;
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
	public function index($category=false)
    {
        if($category !== false)
        {
            if($category == 0)
            {
                return redirect('articles/list');
            }
            if(Auth::check() && Auth::user()->level_id > 2)        
            	$articles = Article::ofCategory($category)->with('author', 'category')->paginate(5);
            else
            	$articles = Article::where('validated', 1)->ofCategory($category)->with('author', 'category')->paginate(5);

        }
        else{
            if(Auth::check() && Auth::user()->level_id > 2) 
            	$articles = Article::with('author', 'category')->paginate(5);
            else
            	$articles = Article::where('validated', 1)->with('author', 'category')->paginate(5);
        }
            
        return view('articles.index', compact('articles', 'category'));
    }

	public function search(Request $request)
	{
		$search = $request->search;
		$str = str_replace(' ', '_', $search);
		$users = [];
		if(!is_numeric($str))
		{
			$users = User::where('level_id', '>', 2)
							->where('banned', 0)
							->where('slug', 'LIKE', '%'.$str.'%')
							->with('articles')
							->get();
		}	

		if(Auth::check() && Auth::user()->level_id > 3){
			$articles = Article::where('title', 'LIKE', '%'.$str.'%')->get();
		}
		else
		{
			$articles = Article::where('validated', 1)->where('title', 'LIKE', '%'.$str.'%')->get();
		}

		return view('articles.search', compact('users', 'articles', 'search'));
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
		    $articles = Article::where('category_id', $category)->with('author', 'category')->orderBy('id', 'desc')->paginate(5);
		    $category = Category::find($category)->name;
		}
		else
		{
		    $articles = Article::orderBy('id', 'desc')->with('author', 'category')->paginate(5);
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
		$article = Article::where('slug', $slug)
						  ->with(['author', 
						  		  'category', 
						  		  'images' => function($query) { $query->orderBy('created_at', 'desc')->limit(4)->get(); }, 
						  		  'course', 
						  		  'band'])
						  ->first();

		if(empty($article) || ($article->validated == 0 && (Auth::guest() || Auth::user()->level_id < 3)))
		{
		  Flash::error('Cet article n\'existe pas.');
		  return view('errors.404');
		}

		$nbImages = Image::where('article_id', $article->id)->count();

		return view('articles.show', compact('article', 'nbImages'));
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

	public function gallery($slug)
	{
		$article = Article::where('slug', $slug)->with('author')->first();
		$images = Image::where('article_id', $article->id)->orderBy('created_at', 'desc')->paginate(15);

		return view('articles.gallery', compact('article', 'images'));
	}

	public function addPictures(Request $request)
	{
		$article = Article::with('images')->find($request->id);

		$array = ['pictures'	=>  'mimes:png,jpeg'];

		$validator = Validator::make($request->all(), $array);

		foreach ($request->pictures as $picture) {

			$clientName = '';
			if($picture != null)
			{
				$clientName = $picture->getClientOriginalName();
			}


			if($clientName != '')
			{
				$ext = $picture->getClientOriginalExtension();
				$destPath = public_path().'/img/article_pictures';

				$list = $article->images;
				$ok = true;
				do{
					$fileName = $article->id.Auth::user()->id.date('dmyHis').rand(1111,9999).'.'.$ext;
					foreach($article->images as $image)
					{
						if($image->name == $fileName)
						{
							$ok = false;
							break;
						}
					}
				}while($ok == false);

				File::delete($fileName);
				if($picture->move($destPath, $fileName))
				{
					Image::create(['name' => $fileName, 'article_id' => $article->id]);
				}
				else{
					Flash::error('Une erreur est survenue lors du chargement d\'une image.');
				}
			}
		}

		// return redirect('articles/view/'.$article->slug.'/gallery');
		return Redirect::back();

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
	public function update(Request $request, $slug)
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


		$article->update([
		  'user_id'   => Auth::user()->id,
		  'title'     => $request->title,
		  'subtitle'  => $request->subtitle,
		  'content'   => $request->content,
		  ]);

		Modification::create([
		  'table'   => 'articles',
		  'user_id' => Auth::user()->id,
		  'message' => 'Created article "'.$request->name.'".',
		  ]);

		Flash::success('Votre article a bien été modifié !');
		return redirect('articles/view/'.$article->slug);
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
		  'subtitle'  => 'max:255',
		  'content'   => 'required|min:15',
		  ]);
	}

}

?>