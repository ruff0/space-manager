<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
	return view('welcome');
});


Route::auth();

Route::group(['middleware' => ['auth'] ], function (){
	Route::get('/home', 'HomeController@index');

	Route::group(['namespace' => 'User'], function () {
		Route::resource('users.profiles', 'ProfilesController', [
			'except' => ['index', 'show', 'create', 'destroy']
		]);
	});
	
	Route::group(['namespace' => 'Space' ], function () {
		Route::resource('members', 'MembersController', [
			'except' => ['index', 'show', 'create', 'destroy']
		]);
	});

	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
		Route::get('/', ['as' => 'admin.index', 'uses' => 'DashboardController@index']);
		Route::resource('plans', 'PlansController');
		Route::resource('members', 'MembersController');
	});
});