<?php namespace App\Http\Controllers;

use DB;
use App\News;
use App\user;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class NewsController extends Controller {



// ________________________________________________________________
//
//                          GET REQUESTS 
// ________________________________________________________________

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    if(Auth::check() && Auth::user()->level_id > 2){
      $news = News::orderBy('published_at', 'desc')->with('author')->paginate(10);
    }
    else
    {
      $news = News::published()->orderBy('published_at', 'desc')->with('author')->paginate(10);
    }
    return view('news.index', compact('news'));
  }

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function adminIndex()
  {
    $news = News::orderBy('published_at', 'desc')->with('author')->paginate(5);
    return view('admin.news.index', compact('news'));
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
          $news = News::where('title', 'LIKE', '%'.$str.'%')->get();
      }
      else
      {
          $news = News::published()->where('title', 'LIKE', '%'.$str.'%')->get();
      }

      return view('news.search', compact('users', 'news', 'search'));
  }


  public function validated($value)
  {
    if($value != 0 && $value != 1)
    {
        Flash::error('Valeur incorrecte, impossible de charger les news validés/invalidés.');
        return redirect('admin/news');
    }

    $news = News::where('active', $value)->with('author')->orderBy('published_at', 'desc')->paginate(15);
    if(empty($news[0]))
    {
      Flash::error('Aucune news ne correspond à votre demande.');
      return redirect('admin/news');
    }
    return view('admin.news.index', compact('news'));
  }

    public function toggle(Request $request)   
    {
        $model = News::find($request->id);
        $model->active = $model->active == 0 ? 1 : 0;
        $model->save();
        Flash::success('La news a bien été '.( $model->active == 1 ? 'activée' : 'suspendue').'.');
        return Redirect::back();
    }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    return view('admin.news.create');
  }

   /**
  * Display news removing form
  * @param $slug news' slug
  * @return news.delete view
  */
  public function delete($slug)
  {
    $news = News::where('slug', $slug)->with('author')->first();
    if(empty($news) || $news->active == 0)
    {
      Flash::error('Cette news n\'existe pas ou a déjà été supprimée.');
      return redirect('news');
    }

    return view('admin.news.delete', compact('news'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $slug
   * @return Response
   */
  public function show($slug)
  {
    $news = News::where('slug', $slug)->with('author')->first();
    $active = true;
    if(empty($news))
    {
      Flash::error('Cette news n\'existe pas.');
      return redirect('news');
    }
    else
    {
      if(Auth::check() && Auth::user()->level_id > 2 && $news->active == 0)
      {
        $active = false;
        return view('news.show', compact('news', 'active'));
      }  
    }
    return view('news.show', compact('news', 'active'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $slug
   * @return Response
   */
  public function edit($slug)
  {
    $news = News::where('slug', $slug)->with('author')->first();
    if(empty($news))
    {
      Flash::error('Cette news n\'existe pas.');
      return redirect('news/index');
    }
    return view('admin.news.edit', compact('news'));
  }




// ________________________________________________________________
//
//                         POST REQUESTS
// ________________________________________________________________

  /** 
  * Check if $data respects the rules
  * @param $data inputs
  * @return true/false
  */
  protected function validator($data)
  {
    return Validator::make($data, [
      'title'   => 'required|min:6|max:255',
      'content' => 'required|min:15',
      ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    $validation = $this->validator($request->all());
    if($validation->fails())
    {
      Flash::error('Impossible de créer la news. Veuillez vérifier les champs renseignés.');
      return Redirect::back()->withErrors($validation->errors());
    }

    $content = $request->content;

    $news = createWithSlug(News::class, [
      'title'   => $request->title,
      'content' => $content,
      'user_id' => Auth::user()->id,
      'published_at'  => $request->date,
      'active'  => isset($request->active) ? 1 : 0,
      ]);

    $slug = $news->slug;

    Flash::success('La news a bien été créée ! ');
    return redirect('news/view/' . $slug);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $slug
   * @return Response
   */
  public function update(Request $request, $slug)
  {
    $validation = $this->validator($request->all());
    if($validation->fails())
    {
      Flash::error('Impossible de modifier la news. Veuillez vérifier les champs renseignés.');
      return Redirect::back()->withErrors($validation->errors());
    }
    $news = News::where('slug', $slug)->first();

    $slug = str_slug($request->title . '-' . $news->id);

    $content = $request->content;

    $news->update([
      'title'   => $request->title,
      'content' => $content,
      'user_id' => Auth::user()->id,
      'slug' => $slug,
      'published_at'  => $request->date,
      'active'  => isset($request->active) ? 1 : 0,
      ]);

    Flash::success('La news a bien été modifiée ! ');
    $news = News::where('id', $news->id)->where('active', 1)->where('published_at', '<=', DB::raw('NOW()'))->first();
    if(!empty($news))
    {
      return redirect('news/view/' . $news->slug);  
    }

    return redirect('admin/news');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $slug
   * @return Response
   */
  public function destroy(Request $request)
  {
    $model = News::find($request->id);
    if(empty($model))
    {
      Flash::error('Impossible de supprimer cette news.');
      return Redirect::back();
    }

    $title = $model->title;
    $model->delete();

    makeModification('news', 'The news &laquo; '.$title.' &raquo; has been removed.');
    Flash::success('La news a bien été supprimé.');
    return Redirect::back();
  }

}

?>

