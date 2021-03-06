<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Category;
use App\Modification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use Laracasts\Flash\Flash;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('name')->with('articles', 'announcements')->paginate(30);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails())
        {
            Flash::error('Impossible d\'ajouter cette catégorie.');
            Return Redirect::back()->withErrors($validator->errors());
        }

        $cat = Category::create([
            'name'      => $request->name,
            ]);

        makeModification('categories', 'category '.ucfirst($request->name).' created');

        Flash::success('L\'instrument a bien été créé !');
        return Redirect::back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $category = Category::find($request->category_id);

        if($category->name != $request->name)
        {
            $oldName = $category->name;

            $category->name = $request->name;
            $category->save();

            makeModification('categories', 'Category '.$category->id.': renamed category "'.$oldName.'" -> "'.$request->name.'".');

            Flash::success('Modification effectuée avec succès !');
        }

        return redirect('admin/categories');
    }

    public function destroy(Request $request)
    {
        $model = Category::with('articles', 'announcements')->find($request->id);
        if(empty($model))
        {
            Flash::error('Impossible de supprimer cette catégorie.');
            return Redirect::back();
        }

        $announcements = $model->announcements();
        $articles = $model->articles();
        if(!empty($announcements))
        {
            foreach ($announcements as $a) {
                $a->update(['category_id' => 1]);
            }
        } 
        if(!empty($articles))
        {
            foreach ($articles as $a) {
                $a->update(['category_id' => 1]);
            }
        } 

        $name = $model->name;
        $model->delete();

        makeModification('categories', 'The category &laquo; '.$name.' &raquo; has been removed.');
        Flash::success('La catégorie a bien été supprimé.');
        return Redirect::back();
    }
}
