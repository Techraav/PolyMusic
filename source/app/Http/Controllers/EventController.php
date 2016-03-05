<?php namespace App\Http\Controllers;

use App\Event;
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
  
}

?>