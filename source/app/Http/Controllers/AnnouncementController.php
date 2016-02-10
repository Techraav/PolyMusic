<?php namespace App\Http\Controllers;

use App\Announcement;
use App\Comment;
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
  public function index()
  {
    $announcements = Announcement::where('validated', 1)->get();
    return view('announcements.index', compact('announcements'));
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
    $announcement = Announcement::where('slug', $slug)->where('validated', 1)->first();
    if(empty($announcement))
    {
      Flash::error('Cette annonce n\'existe pas !');
      return view('errors.404');
    }

    $comments = Comment::where('announcement_id', $announcement->id)->get();
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
    $announcement = Announcement::where('slug', $slug)->first();
    if(empty($announcement))
    {
      Flash::error('Cette annonce n\'existe pas !');
      return view('errors.404');
    }

    return view('announcements.edit', compact('announcement'));
  }

  public function delete($slug)
  {
    $announcement = Announcement::where('slug', $slug)->first();
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

    $announcement = Announcement::createWithSlug([
      'user_id'   => Auth::user()->id,
      'title'     => $request->title,
      'content'   => $request->content,
      'subject'   => $Request->subject,
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

    $slug = str_slug($request->title . '-' . $news->id);

    $annonce->update([
      'title'   => $request->title,
      'content' => $request->content,
      'subject'   => $Request->subject,
      'user_id' => Auth::user()->id,
      'slug' => $slug,
      ]);

    Flash::success('L\'annonce a bien été modifiée ! ');
    return redirect('announcements/view/' . $slug);  
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($slug)
  {
    Announcement::where('slug', $slug)->first()->delete();
    Flash::success('L\'annonce a bien été supprimée.');
    return redirect('announcements');
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