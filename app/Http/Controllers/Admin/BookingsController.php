<?php

namespace App\Http\Controllers\Admin;

use App\Bookings\Booking;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

use App\Http\Requests;

class BookingsController extends AdminController
{
	/**
	 * BookablesController constructor.
	 */
	public function __construct()
	{
		$this->current['model'] = 'Alquileres';
		view()->share('current', $this->current);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->current['action'] = 'Listado';
		$bookings = Booking::all();

		return view('admin.bookings.index', [
			'current'   => $this->current,
			'bookings' => $bookings
		]);
	}


	public function calendar()
	{
		$this->current['action'] = 'Calendario';
		$bookings = Booking::all();

		return view('admin.bookings.calendar', [
			'current'  => $this->current,
			'bookings' => $bookings
		]);
	}
}
