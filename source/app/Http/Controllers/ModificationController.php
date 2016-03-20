<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modification;
use App\Course;
use Laracasts\Flash\Flash;
use App\CourseModification;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ModificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modifs = Modification::orderBy('id', 'desc')->with('user')->paginate(30);
        return view('admin.modifications.index', compact('modifs'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function courses()
    {
        $modifs = CourseModification::orderBy('id', 'desc')->with('course', 'author', 'user')->paginate(20);
        $concerned = "Tous";
        return view('admin.modifications.courses', compact('modifs', 'concerned'));
    }

    public function oneCourse($id)
    {
        $modifs = CourseModification::where('course_id', $id)->orderBy('id', 'desc')->with('course', 'author', 'user')->paginate(20);
        $course = Course::where('id', $id)->first();
        if(empty($course))
        {
            Flash::error('Ce cours n\'existe pas.');
            return abort(404);
        }
        $url = url('admin/modifications/courses/'.$course->slug);
        $name = $course->name;
        $concerned = '<a href="'.$url.'">'.$name.'</a>';
        return view('admin.modifications.courses', compact('modifs', 'concerned'));
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
