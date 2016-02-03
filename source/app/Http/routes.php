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
Route::get('news/edit/{slug}', 'NewsController@edit')			->name('news.edit') 	->middleware('level');
Route::get('news/create', 'NewsController@create')				->name('news.create')	->middleware('level');
Route::get('news/delete/{slug}', 'NewsController@delete')		->name('news.delete')	->middleware('level');

Route::post('news/create', 'NewsController@store')				->name('news.store')	->middleware('level');
Route::post('news/edit/{slug}', 'NewsController@update')		->name('news.update')	->middleware('level');
Route::post('news/delete/{slug}', 'NewsController@destroy')		->name('news.destroy')	->middleware('level');


// ____________________________________________________________________________________________________
//
//                         					ANNOUCEMENT ROUTES
// ____________________________________________________________________________________________________

Route::get('announcements', 'AnnouncementController@index')					->name('announcement.index');
Route::get('announcements/create', 'AnnouncementController@create')			->name('announcement.create')		->middleware('auth');
Route::get('announcements/edit/{slug}', 'AnnouncementController@edit')		->name('announcement.edit')			->middleware('auth');
Route::get('announcements/view/{slug}', 'AnnouncementController@show')		->name('announcement.view');
Route::get('announcements/delete/{slug}', 'AnnouncementController@delete')	->name('announcement.delete')		->middleware('auth');


Route::post('announcements/create', 'AnnouncementController@store')			->name('announcement.create')		->middleware('auth');
Route::post('announcements/edit/{slug}', 'AnnouncementController@update')	->name('announcement.edit')			->middleware('auth');
Route::post('announcements/delete/{slug}', 'AnnouncementController@destroy')->name('announcement.delete')		->middleware('auth');



// ____________________________________________________________________________________________________
//
//                         				ADMIN BACKOFFICE ROUTES
// ____________________________________________________________________________________________________

Route::group(['prefix' => 'admin', 'middleware' => 'level:1'], function(){
	Route::get('test', function()
	{
		return 'coucou';
	});
});
