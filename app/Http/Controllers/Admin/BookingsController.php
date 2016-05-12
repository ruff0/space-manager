<?php

namespace App\Http\Controllers\Admin;

use App\Bookings\Booking;
use App\Http\Controllers\AdminController;
use App\Resources\Models\Resource;
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

		$resources = Resource::with(['bookables', 'bookables.types'])->ofType('room')->get();
		$finalResources = [];
		$finalBookings = [];

		foreach ($resources as $resource)
		{
			$res = new \stdClass();
			$res->id = $resource->id;
			$res->name = $resource->bookables->first()->name;
			$res->type = $resource->bookables->first()->types->first()->name;

			array_push($finalResources, $res);
		}

		foreach ($bookings as $booking)
		{
			$book = new \stdClass();
			$book->id = $booking->id;
		  $book->resourceId = $booking->resource->id;
		  $book->start = $booking->time_from->format("Y-m-d H:i");
		  $book->end = $booking->time_to->format("Y-m-d H:i");
		  $book->title = $booking->member->fullname() . ' (' . $booking->time_from->diffInHours($booking->time_to) .'hrs.)';

			array_push($finalBookings, $book);
		}

		return view('admin.bookings.calendar', [
			'current'  => $this->current,
			'bookings' => collect($finalBookings),
			'resources' => collect($finalResources),
		]);
	}
}
