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
Route::get('news/view/{slug}', 'NewsController@show')			->name('news.show');
Route::get('news/edit/{slug}', 'NewsController@edit')			->name('news.edit') 	->middleware('level');
Route::get('news/create', 'NewsController@create')				->name('news.create')	->middleware('level');
Route::get('news/delete/{slug}', 'NewsController@delete')		->name('news.delete')	->middleware('level');

Route::post('news/create', 'NewsController@store')				->name('news.store')	->middleware('level');
Route::post('news/edit/{slug}', 'NewsController@update')		->name('news.update')	->middleware('level');
Route::post('news/delete/{slug}', 'NewsController@destroy')		->name('news.destroy')	->middleware('level');



