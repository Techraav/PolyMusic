<?php namespace App\Http\Controllers;

use App\Announcement;
use App\Comment;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;


class AnnouncementController extends Controller {



// ____________________________________________________________________________________________________
//
//                                             GET
// ____________________________________________________________________________________________________

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
                return redirect('announcements/list');
            }
            if(Auth::check() && Auth::user()->level_id > 2)        
                $announcements = Announcement::ofCategory($category)->with('author', 'category', 'comments')->paginate(5);
            else
                $announcements = Announcement::where('validated', 1)->ofCategory($category)->with('author', 'category', 'comments')->paginate(5);

        }
        else{
            if(Auth::check() && Auth::user()->level_id > 2) 
                $announcements = Announcement::with('author', 'category', 'comments')->paginate(5);
            else
                $announcements = Announcement::where('validated', 1)->with('author', 'category', 'comments')->paginate(5);
        }
            
        return view('announcements.index', compact('announcements', 'category'));
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
            $announcements = Announcement::where('title', 'LIKE', '%'.$str.'%')->get();
        }
        else
        {
            $announcements = Announcement::where('validated', 1)->where('title', 'LIKE', '%'.$str.'%')->get();
        }

        return view('announcements.search', compact('users', 'announcements', 'search'));
    }

    public function adminIndex($category = false)
    {
        if($category !== false)
        {
            if($category == 0)
            {
                return redirect('admin/announcements');
            } 
            $announcements = Announcement::where('category_id', $category)->with('author', 'category')->orderBy('id', 'desc')->paginate(15);
        }
        else
        {
            $announcements = Announcement::orderBy('id', 'desc')->with('author', 'category')->paginate(15);
        }

        return view('admin.announcements.index', compact('announcements'));
    }

    public function adminIndexValidated($value)
    {
        if($value != 0 && $value != 1)
        {
            Flash::error('Valeur incorrecte, impossible de charger les annonces validés/invalidés.');
            return redirect('admin/announcements');
        }
        $announcements = Announcement::where('validated', $value)->with('author', 'category')->orderBy('id', 'desc')->paginate(15);
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function create()
    {
        return view('announcements.create');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $slug
    * @return Response
    */
    public function show($slug)
    {
        $announcement = Announcement::where('slug', $slug)->with('author', 'category')->first();
        if(empty($announcement) || ($announcement->validated == 0 && (Auth::guest() || (Auth::user()->id != $announcement->user_id && Auth::user()->level_id < 3))) )
        {
          Flash::error('Cette annonce n\'existe pas !');
          return view('errors.404');
        }

        $comments = Comment::where('announcement_id', $announcement->id)->orderBy('created_at', 'desc')->with('author')->paginate(10);
        return view('announcements.show', compact('announcement', 'comments'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $slug
    * @return Response
    */
    public function edit($slug)
    {
        $announcement = Announcement::where('slug', $slug)->with('author', 'category')->first();
        if(empty($announcement))
        {
          Flash::error('Cette annonce n\'existe pas !');
          return view('errors.404');
        }

        return view('announcements.edit', compact('announcement'));
    }

    public function delete($slug)
    {
        $announcement = Announcement::where('slug', $slug)->with('author', 'category')->first();
        if(empty($announcement))
        {
          Flash::error('Cette annonce n\'existe pas !');
          return view('errors.404');
        }

        return view('announcements.delete', compact('announcement'));
    }


    // ____________________________________________________________________________________________________
    //
    //                                             POST
    // ____________________________________________________________________________________________________


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
          Flash::error('Impossible de créer l\'annonce');
          return Redirect::back()->withErrors($validation->errors());
        }

        $content = $request->content;

        $validated = isset($request->validated) ? 1 : 0;

        $announcement = createWithSlug(Announcement::class, [
          'user_id'   => Auth::user()->id,
          'title'     => $request->title,
          'content'   => $content,
          'subject'   => $request->subject,
          'validated' => $validated,
          'category_id' => $request->category
          ]);

        Flash::success('Votre annonce a bien été créée');
        return redirect('announcements/view/'.$announcement->slug);

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
          Flash::error('Impossible de modifier l\'annonce. Veuillez vérifier les champs renseignés.');
          return Redirect::back()->withErrors($validation->errors());
        }
        $annonce = Announcement::where('slug', $slug)->first();

        $slug = str_slug($request->title . '-' . $annonce->id);

        $content = $request->content;

        $annonce->update([
          'title'   => $request->title,
          'content' => $content,
          'subject' => $request->subject,
          'user_id' => Auth::user()->id,
          'slug'    => $slug,
          ]);

        Flash::success('L\'annonce a bien été modifiée ! ');
        return redirect('announcements/view/' . $slug);  
    }

    public function toggle(Request $request)   
    {
        $model = Announcement::find($request->id);
        $model->validated = $model->validated == 0 ? 1 : 0;
        $model->save();
        Flash::success('L\'annonce a bien été '.( $model->validated == 1 ? 'validée' : 'invalidée').'.');
        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $model = Announcement::find($request->id);
        if(empty($model))
        {
            Flash::error('Impossible de supprimer cette annonce.');
            return Redirect::back();
        }

        $model->delete();
        Flash::success('L\'annonce a bien été supprimée.');
        return redirect('announcements/list');
    }

    // ____________________________________________________________________________________________________
    //
    //                                             HELPERS
    // ____________________________________________________________________________________________________

    protected function validator($data)
    {
    return Validator::make($data, [
            'title'   => 'required|min:6|max:255',
            'content' => 'required|min:6',
            'subject' => 'required|min:6|max:255',
        ]);
    }

  
}

?>