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

Route::get('test', function()
{
	return view('test');
});

Route::get('/', function()
{
	return View::make('welcome');
});

// ____________________________________________________________________________________________________
//
//                         					AUTH ROUTES
// ____________________________________________________________________________________________________

Route::get('auth/login', 'Auth\AuthController@getLogin')		->name('login')			->middleware('guest');
Route::get('auth/register', 'Auth\AuthController@getRegister')  ->name('register')		->middleware('guest');
Route::get('auth/logout', 'Auth\AuthController@logout')			->name('logout')		->middleware('auth');

Route::post('auth/login', 'Auth\AuthController@login')			->name('login')			->middleware('guest');
Route::post('auth/register', 'Auth\AuthController@register')	->name('register')		->middleware('guest');


// ____________________________________________________________________________________________________
//
//                         					NEWS ROUTES
// ____________________________________________________________________________________________________

Route::get('news', 'NewsController@index')						->name('news.index');
Route::get('news/view/{slug}', 'NewsController@show')			->name('news.view');


// ____________________________________________________________________________________________________
//
//                         					ANNOUCEMENT ROUTES
// ____________________________________________________________________________________________________

Route::get('announcements', 'AnnouncementController@index')					->name('announcements.index');
Route::get('announcements/create', 'AnnouncementController@create')			->name('announcements.create')		->middleware('auth');
Route::get('announcements/edit/{slug}', 'AnnouncementController@edit')		->name('announcements.edit')		->middleware('auth');
Route::get('announcements/view/{slug}', 'AnnouncementController@show')		->name('announcements.view');
Route::get('announcements/delete/{slug}', 'AnnouncementController@delete')	->name('announcements.delete')		->middleware('auth');


Route::post('announcements/create', 'AnnouncementController@store')			->name('announcements.create')		->middleware('auth');
Route::post('announcements/edit/{slug}', 'AnnouncementController@update')	->name('announcements.edit')		->middleware('auth');
Route::post('announcements/delete/{slug}', 'AnnouncementController@destroy')->name('announcements.delete')		->middleware('auth');


// ____________________________________________________________________________________________________
//
//                         					COMMENTS ROUTES
// ____________________________________________________________________________________________________

Route::post('announcements/comment/create', 'CommentController@store')	->name('comments.create')	->middleware('auth');
Route::get('comment/edit/{id}', 'CommentController@edit')	->name('comments.edit')	->middleware('auth');


// ____________________________________________________________________________________________________
//
//                         					COURSES ROUTES
// ____________________________________________________________________________________________________

Route::get('courses', 'CourseController@index')			->name('course.index');
Route::get('courses/{slug}', 'CourseController@show')	->name('course.show');

Route::post('courses/{slug}', 'CourseController@toggleSignUp')	->name('course.togglesignup');


//====================================================================================================================================


// ____________________________________________________________________________________________________
//
//                         				ADMIN BACKOFFICE ROUTES
// ____________________________________________________________________________________________________

Route::group(['prefix' => 'admin', 'middleware' => 'level:1'], function(){

	Route::get('/', function(){
		return view('admin.index');
	});

	Route::get('users', 'UserController@index')	->name('users.index');


	// _____________________________________________________________________________________________________________

	// ANNOUNCEMENTS : GET
	Route::get('announcements', 	'AnnouncementController@adminIndex')	->name('announcements.adminindex');

	// NEWS : GET
	Route::get('news',					'NewsController@adminIndex')->name('news.adminindex');
	Route::get('news/edit/{slug}', 		'NewsController@edit')		->name('news.edit');
	Route::get('news/create', 			'NewsController@create')	->name('news.create');
	Route::get('news/delete/{slug}', 	'NewsController@delete')	->name('news.delete');
	
	// NEWS : POST
	Route::post('news/create', 			'NewsController@store')		->name('news.store');
	Route::post('news/edit/{slug}', 	'NewsController@update')	->name('news.update');
	Route::post('news/delete/{slug}', 	'NewsController@destroy')	->name('news.destroy');

// _____________________________________________________________________________________________________________


	// ARTICLES : GET
	Route::get('articles',					'ArticleController@adminIndex')	->name('articles.adminindex');
	Route::get('articles/create', 			'ArticleController@create')		->name('articles.create');
	Route::get('articles/edit/{slug}', 		'ArticleController@edit')		->name('articles.edit');
	Route::get('articles/delete{slug}', 	'ArticleController@delete') 	->name('articles.delete');

	// ARTICLES : POST
	Route::post('articles/create', 			'ArticleController@store')	->name('articles.store');
	Route::post('articles/edit/{slug}', 	'ArticleController@update')	->name('articles.update');
	Route::post('articles/delete{slug}', 	'ArticleController@destroy')->name('articles.destroy');


// _____________________________________________________________________________________________________________

	// INSTRUMENTS : GET
	Route::get('instruments', 'InstrumentController@index')				->name('instruments.index');
	Route::get('instruments/edit/{id}', 'InstrumentController@edit') 	->name('instruments.edit');
	Route::get('instruments/create', 'InstrumentController@create')		->name('instruments.create');

	// INSTRUMENTS : POST
	Route::post('instruments/create', 'InstrumentController@store') 		->name('instruments.store');
	Route::post('instruments/edit/{id}', 'InstrumentController@update')		->name('instruments.update');
	Route::post('instruments/delete/{id}', 'InstrumentController@destroy')	->name('instruments.destroy');


// _____________________________________________________________________________________________________________

	// COURSES : GET
	Route::get('courses', 					'CourseController@index')			->name('courses.index');
	Route::get('courses/create', 			'CourseController@create')			->name('courses.create');
	Route::get('courses/edit/{slug}', 		'CourseController@edit')			->name('courses.edit');
	Route::get('courses/delete/{slug}', 	'CourseController@delete')			->name('courses.delete');
	Route::get('courses/{slug}/members',	'CourseController@members')			->name('courses.members');

	// COURSES : POST
	Route::post('courses/create', 			'CourseController@store')			->name('courses.create');
	Route::post('courses/edit/{slug}', 		'CourseController@update')			->name('courses.edit');
	Route::post('courses/delete/{slug}', 	'CourseController@destroy')			->name('courses.delete');
	Route::post('courses/{slug}/members/remove','CourseController@removeMember')->name('courses.removemember');


// ____________________________________________________________________________________________________
//
//                         				ADMIN BACKOFFICE ROUTES
// ____________________________________________________________________________________________________

	// LEVELS : GET
	Route::get('levels', 					'LevelController@index')	->name('levels.index')		->middleware('level:2');
	Route::get('levels/create', 			'LevelController@create')	->name('levels.create')		->middleware('level:2');
	Route::get('levels/edit/{level}', 		'LevelController@edit')		->name('levels.edit')		->middleware('level:2');
	Route::get('levels/delete/{level}', 	'LevelController@delete')	->name('levels.delete')		->middleware('level:2');
	Route::get('levels/{name}/members', 	'LevelController@members')	->name('levels.members')	->middleware('level:2');


	// LEVELS : POST
	Route::post('levels/create', 			'LevelController@store')	->name('levels.store')		->middleware('level:2');
	Route::post('levels/edit/{level}', 		'LevelController@update')	->name('levels.update')		->middleware('level:2');
	Route::post('levels/delete/{level}', 	'LevelController@destroy')	->name('levels.destoy')		->middleware('level:2');
	Route::post('levels/{name}/members/remove', 'LevelController@removeMember')->name('levels.removemember')->middleware('level:2');


// _____________________________________________________________________________________________________________

	// DEPARTEMENTS : GET
	Route::get('departments', 'DepartmentController@index')					->name('departments.index')		->middleware('level:2');
	Route::get('departments/create', 'DepartmentController@create')			->name('departments.create')	->middleware('level:2');
	Route::get('departments/edit/{id}', 'DepartmentController@edit')		->name('departments.edit')		->middleware('level:2');
	Route::get('departments/delete/{id}', 'DepartmentController@delete')	->name('departments.delete')	->middleware('level:2');
	Route::get('departments/{id}/members', 'DepartmentController@members')	->name('departments.members')	->middleware('level:2');

	// DEPARTEMENTS : POST
	Route::post('departments/create', 'DepartmentController@store')			->name('departments.store')		->middleware('level:2');
	Route::post('departments/edit/{id}', 'DepartmentController@update')		->name('departments.update')	->middleware('level:2');
	Route::post('departments/delete/{id}', 'DepartmentController@destroy')	->name('departments.destroy')	->middleware('level:2');
	Route::post('departments/{id}/members/remove', 'DepartmentController@removemember')->name('departments.removemember')->middleware('level:2');


	// BLACKLIST : GET
});


// ____________________________________________________________________________________________________
//
//                         				ADMIN BACKOFFICE ROUTES
// ____________________________________________________________________________________________________

