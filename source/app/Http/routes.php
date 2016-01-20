<?php 

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


Route::resource('user', 'UserController');
Route::resource('level', 'LevelController');
Route::resource('department', 'DepartmentController');
Route::resource('course', 'CourseController');
Route::resource('event', 'EventController');
Route::resource('band', 'BandController');
Route::resource('news', 'NewsController');
Route::resource('article', 'ArticleController');
Route::resource('teacher', 'TeacherController');
Route::resource('student', 'StudentController');
Route::resource('bandmember', 'BandMemberController');
Route::resource('bandevent', 'BandEventController');
