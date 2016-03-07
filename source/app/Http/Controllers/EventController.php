<?php namespace App\Http\Controllers;

use App\Event;
use App\Band;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller {

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {

    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function adminIndex()
    {
        $events = Event::orderBy('name')->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function removeBand($event_id, $band_id)
    {
        $event = Event::find($event_id);
        $event->bands()->detach([$band_id]);
        Flash::success('Le groupe a bien été retiré de l\'événement.');
        return Redirect::back();
    }

    public function addBand($event_id, $band_id)
    {
        $band = Band::find($band_id);
        $band->events()->sync([$event_id]);
        Flash::success('Le groupe a bien été ajouté de l\'événement.');
        return Redirect::back();
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
    * Display the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function manage($id)
    {
        $event = Event::find($id);
        if(Auth::user()->id != $event->user_id && Auth::user()->level_id < 3)
        {
            Flash::error("Vous n'avez pas les droits suffisants pour ceci.");
            return Redirect::back();
        }

        $bands = Band::orderBy('name')->paginate(15);

        return view('events.manage', compact('event', 'bands'));

    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return Response
    */
    public function edit($id)
    {
        $event = Event::find($id);
        if(empty($event))
        {
            Flash::error('Cet événement n\'existe pas.');
            abort(404);
        }

        return view('events.edit', compact('event'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if(empty($event))
        {
            Flash::error('Cet événement n\'existe pas.');
            abort(404);
        }

        $validator = $this->validator($request->all());

        if($validator->fails())
        {
            Flash::error('Impossibe de modifier l\'événement. Vérifiez les informations renseignées.');
            return Redirect::back()->withErrors($validator->errors());
        }

        $oldName = $event->name;
        $newName = $request->name;
        
        $slug = str_slug($request->name).'-'.$event->id;
        $day = date('N', strtotime($request->date))-1;
        $event->update([
            'name' => $newName,
            'location' => $request->location,
            'date' => $request->date,
            'start' => $request->start,
            'day' => $day,
            'end' => $request->end,
            'infos' => $request->infos,
            ]);

        makeModification('events', $request->date."'s event has been updated");

        Flash::success("L'événement a bien été créé !");
        return redirect('events/show/'.$event->slug);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        Flash::success("L'événement a bien été supprimé.");
        return Redirect::back();
    }

    public function validator($data)
    {
        return Validator::make($data, [
            'name' => 'required|min:5|max:255',
            'location' => 'required|min:5|max:255',
            'date' => 'required|min:today',
            'start' => 'required',
            'end' => 'required',
            ]);
    }
  
}

?>