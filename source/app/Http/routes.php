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

Route::get('auth/login', ['as' => 'login', 'uses' => 'Auth/AuthController@getLogin'])->middleware('guest');
Route::get('auth/register', ['as' => 'register', 'uses' => 'Auth/AuthController@getRegister'])->middleware('guest');
Route::get('auth/logout', ['as' => 'logout', 'uses' => 'Auth/AuthController@logout'])->middleware('auth');

Route::post('auth/login', ['as' => 'login', 'uses' => 'Auth/AuthController@login'])->middleware('guest');
Route::post('auth/register', ['as' => 'register', 'uses' => 'Auth/AuthController@register'])->middleware('guest');
