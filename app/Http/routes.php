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


Route::auth();
Route::group(['middleware' => ['auth'], 'prefix' => 'api', 'namespace' => 'Api'], function () {
	/**
	 * Bookables Routes
	 */
	Route::group(['namespace' => 'Space'], function () {
		Route::post('/members/{members}/payment-methods', [
			'as'   => 'api.members.payment-methods.create',
			'uses' => 'PaymentMethodsController@store'
		]);
		
		Route::post('/members/{members}/discounts', [
			'as'   => 'api.members.discounts.store',
			'uses' => 'MemberDiscountsController@store'
		]);
		
		Route::resource('members.passes','MemberPassesController', [
			'except' => ['show', 'create', 'edit']
		]);

		Route::resource('members','MembersController', [
			'only' => ['index']
		]);
		
		Route::get('/subscriptions', 'SubscriptionsController@index');
		Route::post('/subscriptions', 'SubscriptionsController@store');
		Route::post('/subscriptions/calculate', 'SubscriptionsController@calculate');
		Route::post('/subscriptions/rooms', 'SubscriptionsController@rooms');
	});



	Route::group(['namespace' => 'Bookings'], function () {
		Route::get('/bookings', 'BookingsController@index');
		Route::post('/bookings', 'BookingsController@store');
		Route::patch('/bookings/{bookings}', 'BookingsController@update');
		Route::delete('/bookings/{bookings}', 'BookingsController@destroy');
		Route::post('/bookings/calculate', 'BookingsController@calculate');
	});

	Route::group(['namespace' => 'Bookables'], function () {

		Route::resource('bookable-types', 'BookableTypesController', [
			'onlyt' => ['index']
		]);

		Route::get('/bookables', 'BookablesController@index');
		Route::get('/bookables/{bookables}', 'BookablesController@show');
	});
});


Route::group(['middleware' => ['auth']], function () {
	Route::get('/', 'HomeController@index');
	Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

	/**
	 * Bookables Routes
	 */
	Route::group(['namespace' => 'Bookings'], function () {
		Route::get('/bookings', 'BookingsController@index');
		Route::get('/bookings/create', 'BookingsController@create');
	});

	Route::group(['namespace' => 'Subscriptions'], function () {
		Route::resource('subscriptions', 'SubscriptionsController', [
			'only' => ['create']
		]);

		Route::post('subscriptions/{subscriptions}/cancel', [
			'as' => 'subscriptions.cancel',
			'uses' => 'SubscriptionsController@cancel'
		]);
	});

	Route::group(['namespace' => 'Invoices'], function () {
		Route::resource('invoices', 'InvoicesController', [
			'only' => ['index', 'show']
		]);

		Route::get('invoices/{invoices}/download', [
			'as' => 'invoices.download',
			'uses' =>	'InvoicesController@download'
		]);
	});

	/**
	 * Users Routes
	 */
	Route::group(['namespace' => 'User'], function () {
		Route::resource('users.profiles', 'ProfilesController', [
			'except' => ['index', 'show', 'create', 'destroy']
		]);
	});

	/**
	 * Spaces Routes
	 */
	Route::group(['namespace' => 'Space'], function () {
		Route::resource('members', 'MembersController', [
			'except' => ['index', 'show', 'create', 'destroy']
		]);
	});

	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
		Route::get('/', ['as' => 'admin.index', 'uses' => 'DashboardController@index']);

		Route::resource('plans', 'PlansController');
		Route::resource('members', 'MembersController');
		Route::resource('bookables', 'BookablesController');
	
		Route::get('bookings/calendar', [
			'as'  => 'admin.bookings.calendar',
			'uses' => 'BookingsController@calendar'
		]);
		Route::resource('bookings', 'BookingsController');

		// Resources
		Route::resource('meetingrooms', 'MeetingRoomsController');
		Route::resource('classrooms', 'ClassRoomsController');
		Route::resource('spots', 'SpotsController');
		Route::resource('virtuals', 'VirtualsController');
		Route::resource('offices', 'OfficesController');

		// Configs
		Route::resource('bookabletypes', 'BookableTypesController');
		Route::resource('plantypes', 'PlanTypesController');
		// File uploads
		Route::resource('files', 'FilesController');

	});
});
