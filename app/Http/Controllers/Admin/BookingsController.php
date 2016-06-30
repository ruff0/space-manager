<?php

namespace App\Http\Controllers\Admin;

use App\Bookables\Bookable;
use App\Bookings\Booking;
use App\Http\Controllers\AdminController;
use App\Invoices\Models\Invoice;
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
		$bookings = Booking::orderBy('time_from', 'desc')->get();

		return view('admin.bookings.index', [
			'current'  => $this->current,
			'bookings' => $bookings
		]);
	}

	/**
	 *
	 */
	public function create()
	{
		$booking = new Booking();
		return view('admin.bookings.create', [
			'booking' => $booking
		]);
	}

	/**
	 *
	 */
	public function edit(Booking $bookings)
	{
		return view('admin.bookings.edit', [
			'booking' => $bookings,
			'invoice' => json_encode([])
		]);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function calendar()
	{
		$this->current['action'] = 'Calendario';
		$bookings = Booking::all();

		$resources = Resource::with(['bookables', 'bookables.types'])->ofType('room')->get();
		$finalResources = [];
		$finalBookings = [];

		foreach ($resources as $resource) {
			$bookable = $resource->bookables->first();

			if ($bookable) {
				$type = $bookable->types->first();
				if ($type) {
					$res = new \stdClass();
					$res->id = $resource->resourceable_type . $resource->resourceable->id;
					$res->name = $resource->resourceable->name;
					$res->type = $bookable->name;
					$finalResources[] = $res;
				}
			}
		}

		foreach ($bookings as $booking) {
			$invoice = Invoice::where('payable_id', $booking->id)->where('type', 'booking')->first();
			$paid = $invoice && $invoice->paid;

			$book = new \stdClass();
			$book->id = $booking->id;
			$book->resourceId = $booking->resource->resourceable_type . $booking->resource->resourceable->id;
			$book->start = $booking->time_from->format("Y-m-d H:i");
			$book->end = $booking->time_to->format("Y-m-d H:i");
			$book->color = $paid ? '#00BCD4' : '#FF5722';
			$book->title = $booking->member->fullname() . ' (' . $booking->time_from->diffInHours($booking->time_to) . 'hrs.)';

			array_push($finalBookings, $book);
		}

		return view('admin.bookings.calendar', [
			'current'   => $this->current,
			'bookings'  => collect($finalBookings),
			'resources' => collect($finalResources),
		]);
	}
}
