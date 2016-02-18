<?php namespace App\Http\Controllers;

use App\Article;
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
    $articles = Article::orderBy('id', 'desc')->paginate(20);
    return view('articles.index', compact('articles'));    
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function adminIndex()
  {
    $articles = Article::orderBy('id', 'desc')->paginate(20);
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
    $articles = Article::where('slug', $slug)->first();
    if(empty($articles))
    {
      Flash::error('Cet article n\'existe pas.');
      return redirect('articles');
    }

    return view('articles.show', compact('articles'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    $article = Article::where('id', $id)->first();
    if(Auth::user()->id != $article->user_id && Auth::user()->level < 2)
    {
      Flash::error("Vous n'avez pas le droit de modifier cet article !");
      return redirect('admin/articles');
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
    $article = Article::where('slug', $slug)->first();
    if(empty($article))
    {
      Flash::error('Cet article n\'existe pas ou a déjà été supprimé.');
      return redirect('articles');
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

    $article = Article::createWithSlug([
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
  public function update($id)
  {
    $validation = $this->validator($request->all());

    if($validation->fails())
    {
      Flash::error('Impossible de modifier l\'article. Veuillez vérifier les champs renseignés.');
      return Redirect::back()->withErrors($validation->errors());
    }

    $article = Article::where('slug', $slug)->first();

    if(Auth::user()->id != $article->user_id && Auth::user()->level < 2)
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