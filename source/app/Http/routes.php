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

Route::group(['prefix' => '/', 'middleware' => 'banned'], function(){


	Route::get('test', function()
	{	
		return view('test');
	});

	Route::post('test', 'TestController@test');



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

	Route::get('announcements/list', 'AnnouncementController@index')					->name('announcements.index');
	Route::get('announcements', function(){ return redirect('announcements/list');})->name('announcements.index');
	Route::get('announcements/list/category/{category}', 'AnnouncementController@index')->name('announcements.indexOfCategory');
	Route::get('announcements/create', 'AnnouncementController@create')			->name('announcements.create')		->middleware('auth');
	Route::get('announcements/edit/{slug}', 'AnnouncementController@edit')		->name('announcements.edit')		->middleware('auth');
	Route::get('announcements/view/{slug}', 'AnnouncementController@show')		->name('announcements.view');
	Route::get('announcements/delete/{slug}', 'AnnouncementController@delete')	->name('announcements.delete')		->middleware('auth');
	Route::get('comment/edit/{id}', 'CommentController@edit')->name('comment.edit')->middleware('auth');


	Route::post('announcements/create', 'AnnouncementController@store')			->name('announcements.create')		->middleware('auth');
	Route::post('announcements/edit/{slug}', 'AnnouncementController@update')	->name('announcements.edit')		->middleware('auth');
	Route::post('announcements/delete', 'AnnouncementController@destroy')		->name('announcements.delete')		->middleware('auth');
	Route::post('announcements/toggle', 'AnnouncementController@toggle')	->name('announcements.toggle')			->middleware('auth');


	// ____________________________________________________________________________________________________
	//
	//                         					COMMENT ROUTES
	// ____________________________________________________________________________________________________

	Route::post('announcements/comment/create', 'CommentController@store')	->name('comments.create')	->middleware('auth');
	Route::post('comment/edit/{id}', 'CommentController@update')	->name('comments.update')	->middleware('auth');
	Route::post('comment/delete', 'CommentController@destroy')	->name('comments.destroy')	->middleware('auth');


	// ____________________________________________________________________________________________________
	//
	//                         					COURSE ROUTES
	// ____________________________________________________________________________________________________
	Route::get('courses', function()
	{
		return redirect(route('course.index'));
	});
	Route::get('courses/list', 'CourseController@index')			->name('course.index');
	Route::get('courses/list/{filter}/{value}', 'CourseController@index')			->name('course.indexFiltered');
	Route::get('courses/show/{slug}', 'CourseController@show')	->name('course.show');
	Route::get('courses/{slug}/documents', 'CourseController@documents')	->name('course.documents') ->middleware('auth');

	Route::post('courses/{slug}', 'CourseController@toggleSignUp')	->name('course.togglesignup');
	Route::post('courses/user/management', 'CourseController@userManagement')->name('course.userManagement');



	Route::get('notifications', 'NotificationController@index')->name('notification.index')->middleware('auth');

	// ____________________________________________________________________________________________________
	//
	//                         					USER ROUTES
	// ____________________________________________________________________________________________________

	Route::get('users/{slug}', 'UserController@show')	->name('user.show');
	Route::get('users/edit/{slug}', 'UserController@edit')		->name('user.edit')->middleware('auth');
	Route::post('users/edit/{slug}', 'UserController@update')	->name('user.update');
	Route::post('users/image/remove', 'UserController@removeImage')->name('user.removeImage');
	Route::post('users/updatelevel', 'UserController@updateLevel')->name('user.updatelevel')->middleware('level:4');


	// ____________________________________________________________________________________________________
	//
	//                         					ARTICLES ROUTES
	// ____________________________________________________________________________________________________

	Route::get('articles/view/{slug}', 'ArticleController@show') ->name('article.show');
	Route::get('articles/view/{slug}/gallery', 'ArticleController@gallery') ->name('article.gallery');
	Route::get('articles/list', 'ArticleController@index')->name('article.index');
	Route::get('articles/list/category/{value}', 'ArticleController@index')->name('article.index');
	Route::get('articles', function(){
		return redirect('articles/list');
	});



	// ____________________________________________________________________________________________________
	//
	//                         					BAND ROUTES
	// ____________________________________________________________________________________________________

	Route::group(['prefix' => 'bands', 'middleware' => 'incoming'], function(){
		Route::get('/', 'BandController@index')->name('bands.index');
		Route::get('show/{slug}', 'BandController@show')	->name('bands.show');
	});

	// ____________________________________________________________________________________________________
	//
	//                         					EVENT ROUTES
	// ____________________________________________________________________________________________________

	Route::group(['prefix' => 'events', 'middleware' => 'incoming'], function(){
		Route::get('/', 'EventController@index')->name('events.index');
		Route::get('edit/{id}', 'EventController@edit')->name('events.edit')->middleware('level:2');
		// Route::get('show/{slug}')
		Route::get('manage/{id}', 'EventController@manage')->name('events.manage')->middleware('level:2');

		Route::post('delete', 'EventController@destroy')->name('events.destroy')->middleware('level:2');
		Route::post('edit/{id}', 'EventController@update')->name('events.update')->middleware('level:2');
	});


	//====================================================================================================================================


	// ____________________________________________________________________________________________________
	//
	//                         				ADMIN BACKOFFICE ROUTES
	// ____________________________________________________________________________________________________

	Route::group(['prefix' => 'admin', 'middleware' => 'level:3'], function(){

		Route::get('/', function(){
			return view('admin.index');
		});

		Route::get('categories', 'CategoryController@index')	->name('category.index');
		Route::get('categories/edit/{id}', 'CategoryController@edit')	->name('category.edit');

		Route::post('categories/edit', 'CategoryController@update')	->name('category.update');
		Route::post('categories/delete', 'CategoryController@destroy')	->name('category.destroy');

		Route::get('modifications', 'ModificationController@index')			   ->name('modifs.index');
		Route::get('modifications/courses', 'ModificationController@courses')  ->name('modifs.courses');
		Route::get('modifications/courses/{id}', 'ModificationController@oneCourse')  ->name('modifs.onecourses');

	// _____________________________________________________________________________________________________________

		// ANNOUNCEMENTS : GET
		Route::get('announcements', 	'AnnouncementController@adminIndex')	->name('announcements.adminindex');
		Route::get('announcements/{category}', 	'AnnouncementController@adminIndex')	->name('announcements.adminindexcategory');
		Route::get('announcements/validated/{value}', 	'AnnouncementController@adminIndexValidated')	->name('announcements.adminindexvalidated');
		Route::get('announcements/validate/{id}', 'AnnouncementController@validatePost')->name('announcements.validate');

	// _____________________________________________________________________________________________________________

		// NEWS : GET
		Route::get('news',					'NewsController@adminIndex')->name('news.adminindex');
		Route::get('news/edit/{slug}', 		'NewsController@edit')		->name('news.edit');
		Route::get('news/create', 			'NewsController@create')	->name('news.create');
		Route::get('news/delete/{slug}', 	'NewsController@delete')	->name('news.delete');
		Route::get('news/validated/{value}','NewsController@validated')	->name('news.validated');
		
		// NEWS : POST
		Route::post('news/create', 		'NewsController@store')		->name('news.store');
		Route::post('news/edit/{slug}', 'NewsController@update')	->name('news.update');
		Route::post('news/delete', 		'NewsController@destroy')	->name('news.destroy');
		Route::post('news/activate/{value}', 	'NewsController@toggle')	->name('news.active');

	// _____________________________________________________________________________________________________________

		Route::get('bands', 'BandController@adminIndex')	->name('bands.adminindex');
		Route::get('bands/edit/{id}', 'BandController@edit')	->name('bands.edit');
		Route::get('bands/manage/{id}', 'BandController@manage')	->name('bands.manage');

		Route::post('bands/edit/{id}', 'BandController@update')	->name('bands.update');

	// _____________________________________________________________________________________________________________



		// ARTICLES : GET
		Route::get('articles',					'ArticleController@adminIndex')	->name('articles.adminindex');
		Route::get('articles/category/{category}',		'ArticleController@adminIndex')	->name('articles.adminIndexCategory');
		Route::get('articles/validated/{value}','ArticleController@adminIndexValidated')->name('articles.adminIndexValidated');
		Route::get('articles/create', 			'ArticleController@create')		->name('articles.create');
		Route::get('articles/edit/{slug}', 		'ArticleController@edit')		->name('articles.edit');
		Route::get('articles/delete/{slug}', 	'ArticleController@delete') 	->name('articles.delete');

		// ARTICLES : POST
		Route::post('articles/validate/{value}','ArticleController@validatePost')	->name('articles.validate');
		Route::post('articles/create', 			'ArticleController@store')	->name('articles.store');
		Route::post('articles/edit/{slug}', 	'ArticleController@update')	->name('articles.update');
		Route::post('articles/delete', 			'ArticleController@destroy')->name('articles.destroy');
		Route::post('articles/gallery/add', 	'ArticleController@addPictures')->name('articles.addPictures');


	// _____________________________________________________________________________________________________________

		// INSTRUMENTS : GET
		Route::get('instruments', 'InstrumentController@index')				->name('instruments.index');
		Route::get('instruments/edit/{id}', 'InstrumentController@edit') 	->name('instruments.edit');
		Route::get('instruments/create', 'InstrumentController@create')		->name('instruments.create');

		// INSTRUMENTS : POST
		Route::post('instruments/create', 'InstrumentController@store') 		->name('instruments.store');
		Route::post('instruments/edit', 'InstrumentController@update')		->name('instruments.update');
		Route::post('instruments/delete', 'InstrumentController@destroy')	->name('instruments.destroy');


	// _____________________________________________________________________________________________________________

		// COURSES : GET
		Route::get('courses', 					'CourseController@adminIndex')	->name('courses.adminindex');
		Route::get('courses/create', 			'CourseController@create')		->name('courses.create');
		Route::get('courses/edit/{id}', 		'CourseController@edit')		->name('courses.edit');
		Route::get('courses/delete/{slug}', 	'CourseController@delete')		->name('courses.delete');
		Route::get('courses/{slug}/members',	'CourseController@members')		->name('courses.members');
		Route::get('courses/instrument/{id}', 	'CourseController@instrument')	->name('courses.ofInstrument');
		Route::get('courses/{id}/documents', 	'CourseController@adminDocuments')	->name('courses.documents');
		Route::get('courses/{id}/documents/validation/{value}', 	'CourseController@documentsValidated')	->name('courses.docsValidated');

		// COURSES : POST
		Route::post('courses/create', 		'CourseController@store')		->name('courses.create');
		Route::post('courses/edit/{id}', 	'CourseController@update')		->name('courses.edit');
		Route::post('courses/delete', 		'CourseController@destroy')		->name('courses.delete');
		
		Route::post('courses/{id}/student/remove','StudentController@remove')	->name('courses.removestudent');
		Route::post('courses/{id}/teacher/remove','TeacherController@remove')	->name('courses.removeteacher');
		Route::post('courses/{id}/student/accept','StudentController@accept')	->name('courses.acceptstudent');
		Route::post('courses/{id}/teacher/accept','TeacherController@accept')	->name('courses.acceptteacher');
		Route::post('courses/{id}/student/cancel','StudentController@cancel')	->name('courses.cancelstudent');
		Route::post('courses/{id}/teacher/cancel','TeacherController@cancel')	->name('courses.cancelteacher');


	// _____________________________________________________________________________________________________________

		Route::get('events', 'EventController@adminIndex')									->name('events.adminindex');
		Route::post('events/{event_id}/removeband/{band_id}', 'EventController@removeBand')	->name('events.removeBand');
		Route::post('events/{event_id}/addband/{band_id}', 'EventController@addband')		->name('events.addband');
		Route::get('events', 'EventController@adminIndex')									->name('events.adminindex');
	// _____________________________________________________________________________________________________________


		// USERS : GET
		Route::get('users',	'UserController@index')					->name('users.index');
		Route::post('users/bannish', 'UserController@destroy')		->name('users.bannish');
		Route::post('users/unbannish', 'UserController@unbannish')		->name('users.unbannish');

	// _____________________________________________________________________________________________________________

		Route::get('documents', 'DocumentController@index')->name('documents.index');
		Route::get('documents/user/{id}', 'DocumentController@fromUser')->name('documents.fromuser');
		Route::get('documents/course/{id}', 'DocumentController@forCourse')->name('documents.forcourse');
		Route::get('documents/edit/{id}', 'DocumentController@edit')->name('documents.edit');

		Route::post('documents/validate/{value}', 'DocumentController@toggle')->name('documents.validate');
		Route::post('documents/delete', 'DocumentController@destroy')->name('documents.destroy');
		Route::post('documents/update', 'DocumentController@update')->name('documents.update');
		Route::post('documents/store', 'DocumentController@store')->name('documents.store');


	// ____________________________________________________________________________________________________
	//
	//                         				ADMIN BACKOFFICE ROUTES
	// ____________________________________________________________________________________________________

		// LEVELS : GET
		Route::get('levels', 					'LevelController@index')	->name('levels.index')		->middleware('level:4');
		Route::get('levels/create', 			'LevelController@create')	->name('levels.create')		->middleware('level:4');
		Route::get('levels/edit/{level}', 		'LevelController@edit')		->name('levels.edit')		->middleware('level:4');
		Route::get('levels/delete/{level}', 	'LevelController@delete')	->name('levels.delete')		->middleware('level:4');
		Route::get('levels/{name}/members', 	'LevelController@members')	->name('levels.members')	->middleware('level:4');


		// LEVELS : POST
		Route::post('levels/create', 			'LevelController@store')	->name('levels.store')		->middleware('level:4');
		Route::post('levels/edit/{level}', 		'LevelController@update')	->name('levels.update')		->middleware('level:4');
		// Route::post('levels/delete/{level}', 	'LevelController@destroy')	->name('levels.destoy')		->middleware('level:4');
		Route::post('levels/{id}/members/remove', 'LevelController@removeMember')->name('levels.removemember')->middleware('level:4');


	// _____________________________________________________________________________________________________________

		// DEPARTEMENTS : GET
		Route::get('departments', 'DepartmentController@index')					->name('departments.index');
		Route::get('departments/create', 'DepartmentController@create')			->name('departments.create');
		Route::get('departments/edit/{id}', 'DepartmentController@edit')		->name('departments.edit');
		Route::get('departments/delete/{id}', 'DepartmentController@delete')	->name('departments.delete');
		Route::get('departments/{id}/members', 'DepartmentController@members')	->name('departments.members');

		// DEPARTEMENTS : POST
		Route::post('departments/create', 'DepartmentController@store')			->name('departments.store');
		Route::post('departments/edit/{id}', 'DepartmentController@update')		->name('departments.update');
		Route::post('departments/delete', 'DepartmentController@destroy')		->name('departments.destroy');
		Route::post('departments/{id}/members/remove', 'DepartmentController@removemember')->name('departments.removemember');


		// BLACKLIST : GET
	});


	// ____________________________________________________________________________________________________
	//
	//                         				SEARCH ROUTES
	// ____________________________________________________________________________________________________

	Route::get('courses/search', 'CourseController@search')				->name('course.search');
	Route::get('articles/search', 'ArticleController@search')			->name('articles.search');
	Route::get('announcements/search', 'AnnouncementController@search')	->name('announcements.search');
	Route::get('news/search', 'NewsController@search')					->name('news.search');
	Route::get('admin/users/search', 'UserController@search')			->name('users.search');
});