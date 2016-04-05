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
Route::get('/home', 'HomeController@index');

Route::auth();

Route::group(['middleware' => ['auth'], 'namespace' => 'User'], function () {
	Route::resource('users.profiles', 'ProfilesController', [
		'except' => ['index', 'show', 'create', 'destroy']
	]);
});

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
	Route::get('/', ['as' => 'admin.index', 'uses' => 'DashboardController@index']);
});
