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
//                         					COURSES ROUTES
// ____________________________________________________________________________________________________

Route::get('courses', 'CourseController@index')			->name('course.index');
Route::get('courses/{slug}', 'CourseController@show')	->name('course.show');

Route::post('courses/{slug}' 'CourseController@toggleSignUp')	->name('course.togglesignup');


//====================================================================================================================================


// ____________________________________________________________________________________________________
//
//                         				TEACHER BACKOFFICE ROUTES
// ____________________________________________________________________________________________________

Route::group(['prefix' => 'teacher', 'middleware' => 'level:1'], function(){

	// NEWS : GET
	Route::get('news/edit/{slug}', 		'NewsController@edit')		->name('news.edit');
	Route::get('news/create', 			'NewsController@create')	->name('news.create');
	Route::get('news/delete/{slug}', 	'NewsController@delete')	->name('news.delete');
	
	// NEWS : POST
	Route::post('news/create', 			'NewsController@store')		->name('news.store');
	Route::post('news/edit/{slug}', 	'NewsController@update')	->name('news.update');
	Route::post('news/delete/{slug}', 	'NewsController@destroy')	->name('news.destroy');

// _____________________________________________________________________________________________________________


	// ARTICLES : GET
	Route::get('articles/create', 			'ArticleController@create')	->name('articles.create');
	Route::get('articles/edit/{slug}', 		'ArticleController@edit')	->name('articles.edit');
	Route::get('articles/delete{slug}', 	'ArticleController@delete') ->name('articles.delete');

	// ARTICLES : POST
	Route::post('articles/create', 			'ArticleController@store')	->name('articles.store');
	Route::post('articles/edit/{slug}', 	'ArticleController@update')	->name('articles.update');
	Route::post('articles/delete{slug}', 	'ArticleController@destroy')->name('articles.destroy');

// _____________________________________________________________________________________________________________


	// COURSES : GET
	Route::get('courses/{slug}/members',		'CourseController@members')	->name('courses.members');
	Route::get('courses/{slug}/members/add',	'CourseController@members')	->name('courses.addmember');
	Route::get('courses/{slug}/members/remove',	'CourseController@members')	->name('courses.removemember');

	//	COURSES : POST
	Route::post('courses/{slug}/members/add',	'CourseController@addMember')		->name('courses.addmembers');
	Route::post('courses/{slug}/members/remove','CourseController@removeMember')	->name('courses.removemembers');


});


// ____________________________________________________________________________________________________
//
//                         				ADMIN BACKOFFICE ROUTES
// ____________________________________________________________________________________________________


Route::group(['prefix' => 'admin', 'middleware' => 'level:2'], function(){

	// LEVELS : GET
	Route::get('levels', 					'LevelController@index')	->name('levels.index');
	Route::get('levels/create', 			'LevelController@create')	->name('levels.create');
	Route::get('levels/edit/{level}', 		'LevelController@edit')		->name('levels.edit');
	Route::get('levels/delete/{level}', 	'LevelController@delete')	->name('levels.delete');
	Route::get('levels/{level}/list', 		'LevelController@list')		->name('levels.list');


	// LEVELS : POST
	Route::post('levels/create', 			'LevelController@store')	->name('levels.store');
	Route::post('levels/edit/{level}', 		'LevelController@update')	->name('levels.update');
	Route::post('levels/delete/{level}', 	'LevelController@destroy')	->name('levels.destoy');

// _____________________________________________________________________________________________________________

	// COURSES : GET
	Route::get('courses', 						'CourseController@index')	->name('courses.index');
	Route::get('courses/create', 				'CourseController@create')	->name('courses.create');
	Route::get('courses/edit/{slug}', 			'CourseController@edit')	->name('courses.edit');
	Route::get('courses/delete/{slug}', 		'CourseController@delete')	->name('courses.delete');

	// COURSES : POST
	Route::post('courses/create', 			'CourseController@store')		->name('courses.create');
	Route::post('courses/edit/{slug}', 		'CourseController@update')		->name('courses.edit');
	Route::post('courses/delete/{slug}', 	'CourseController@destroy')		->name('courses.delete');

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

	// DEPARTEMENTS : GET
	Route::get('departements', 'DepartementController@index')	-			->name('departements.index');
	Route::get('departements/create', 'DepartementController@create')		->name('departements.create');
	Route::get('departements/edit/{id}', 'DepartementController@edit')		->name('departements.edit');
	Route::get('departements/delete/{id}', 'DepartementController@delete')	->name('departements.delete');

	// DEPARTEMENTS : POST
	Route::post('departements/create', 'DepartementController@store')			->name('departements.store');
	Route::post('departements/edit/{id}', 'DepartementController@update')		->name('departements.update');
	Route::post('departements/delete/{id}', 'DepartementController@destroy')	->name('departements.destroy');


	// BLACKLIST : GET

});
