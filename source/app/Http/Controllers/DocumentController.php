<?php

namespace App\Http\Controllers;

use App\Course;
use App\User;
use App\Modification;
use App\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class DocumentController extends Controller
{
    public function index()
    {
    	$documents = Document::orderBy('created_at', 'desc')->with('author', 'course')->paginate(15);
    	return view('admin.documents.index', compact('documents'));
    }

    public function fromUser($id)
    {
    	$documents = Document::where('user_id', $id)->with('author', 'course')->orderBy('created_at', 'desc')->paginate(15);
    	$filter = 'utilisateurs';
    	return view('admin.documents.index', compact('documents', 'filter', 'id'));
    }

    public function forCourse($id)
    {
    	$documents = Document::where('course_id', $id)->with('author', 'course')->orderBy('created_at', 'desc')->paginate(15);
    	$filter = 'cours';
    	return view('admin.documents.index', compact('documents', 'filter', 'id'));
    }

    public function toggle(Request $request)   
    {
        $doc = Document::find($request->id);
        $doc->validated = $doc->validated == 0 ? 1 : 0;
        $doc->save();
        Flash::success('Le document a bien été '.( $doc->validated == 1 ? 'validé' : 'invalidé').'.');
        return Redirect::back();
    }

    public function destroy(Request $request)
    {
        $doc = Document::find($request->id);
        $doc->delete();
        Flash::success('Le document a bien été supprimé.');
        return Redirect::back();
    }

    public function edit($id)   
    {
        $document = Document::with('author', 'course')->find($id);
        if(empty($document))
        {
            Flash::error('Ce document n\'existe pas.');
            return Redirect::back();
        }
        return view('admin.documents.edit', compact('document'));
    }

    public function update(Request $request)
    {   
        $validator = $this->validator($request->all());

        if($validator->fails())
        {
            Flash::error('Impossible de modifier le document. Veuillez vérifier les champs renseignés.');
            return Redirect::back()->withErrors($validator->errors());
        }

        $doc = Document::find($request->id);
        $doc->title = $request->title;
        $doc->description = $request->description;
        $doc->save();

        Flash::success('Le document a bien été modifié !');
        return redirect('admin/documents');
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails() || !isset($request->check))
        {
            Flash::error('Impossible d\'ajouter le document, veuillez vérifier les champs renseignés, ainsi que le format de votre document.');
            return Redirect::back()->withErrors($validator->errors());
        }

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $clientName = $file->getClientOriginalName();
        $destPath = public_path().'/files/documents';
        $fileName = $request->course_id.Auth::user()->id.date('dmYHis').rand(10000, 99999).'.'.$ext;

        if($file->move($destPath, $fileName))
        {
            $title = $request->title;
            $description = $request->description;
            $user_id = Auth::user()->id;
            $course_id = $request->course_id;
            $validated = isset($request->validated) ? 1 : 0;

            Document::create([
                'title'         => $title,
                'name'          => $fileName,
                'description'   => $description,
                'course_id'     => $course_id,
                'user_id'       => $user_id,
                'validated'     => $validated
                ]);

            Flash::success('Le document a bien été ajouté.');
        }
        else{
            Flash::error('Une erreur est survenur. Veuillez réessayer. Si le problème persiste, contactez un administrateur.');
        }

        return Redirect::back();
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'title'         => 'required|min:5|max:100',
            'description'   => 'max:255',
            'file'          => 'required|mimes:pdf'
            ]);
    }


}
