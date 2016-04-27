<?php

namespace App\Http\Controllers\Bookings;

use App\Bookables\BookableType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BookingsController extends Controller
{
	public function create(){
		$bookableTypes = BookableType::with('bookables')->get();

		return view('bookings.index', [
			'bookableTypes' => $bookableTypes
		]);
	}
}
