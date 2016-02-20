<?php

namespace App\Http\Controllers;

use App\Instrument;
use App\User;
use App\BandUser;
use App\Course;
use App\Modification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;
class InstrumentController extends Controller
{

// ________________________________________________________________
//
//                           GET FUNCTIONS 
// ________________________________________________________________  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instruments = Instrument::orderBy('name')->paginate(30);
        return view('admin.instruments.index', compact('instruments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $instruments = Instrument::orderBy('name')->paginate(30);
        $instruToEdit = Instrument::find($id);

        return view('admin.instruments.edit', compact('instruments', 'instruToEdit'));
    }

// ________________________________________________________________
//
//                          POST FUNCTIONS 
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
            Flash::error('Impossible d\'ajouter cet instrument.');
            Return Redirect::back()->withErrors($validator->errors());
        }

        $instru = Instrument::create([
            'name'      => $request->name,
            ]);

        Modification::create([
            'table'     => 'instruments',
            'user_id'   => Auth::user()->id,
            'message'   => 'added instrument "'.$request->name.'"'
            ]);

        Flash::success('L\'instrument a bien été créé !');
        return Redirect::back(); 
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request, $id)
    {
        $instrument = Instrument::where('id', $id)->first();
        $name = $instrument->name;
        $instrument->update(['name' => $request->name]);

        Modification::create([
            'table'     => 'instruments',
            'user_id'   => Auth::user()->id,
            'message'   => 'updated instrument "'.$name.'" to "'.$request->name.'".'
            ]);

        Flash::success('Instrument modifié avec succès !');
        return redirect('admin/instruments');

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        $instrument = Instrument::where('id', $id)->first();
        if(empty($instrument))
        {
            Flash::error('Cet instrument n\'a pas l\'air d\'exister. Si vous pensez qu\' s\'agit d\'un bug, merci de contacter le webmaster');
            return Redirect::back();
        }
        $name = $instrument->name;

        // Suppression des membres de groupes + cours de cet instrument
        $bms = BandUser::where('instrument_id', $id)->get();
        $cs = Course::where('instrument_id', $id)->get();
        if(!empty($bms))
        {
            foreach ($bms as $bm) {
                $bm->setDefaultInstrument();
            }      
        }
        if(!empty($cs))
        {
            foreach ($cs as $c) {
                $c->setDefaultInstrument();
            }
        }  


        $instrument->delete();

        $test = Instrument::where('id', $id)->first();
        if(empty($test))
        {
            Flash::success('Instrument supprimé avec succès.');

            Modification::create([
                'table'     => 'instruments',
                'user_id'   => Auth::user()->id,
                'message'   => 'removed instrument "'.$name.'".']);
        }
        else
            Flash::error('Impossible de supprimer cet instrument.');

        return redirect('admin/instruments');
    }

// ________________________________________________________________
//
//                            HELPERS 
// ________________________________________________________________  

    protected function validator($data)
    {
        return Validator::make($data, [
            'name'  => 'required|unique:instruments,name|max:255|min:2'
            ]);
    }
}
