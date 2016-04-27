<?php

namespace App\Http\Controllers\Api\Bookings;

use App\Bookables\Bookable;
use App\Bookables\BookableType;
use App\Http\Requests\Bookings\CreateBookingForm;
use App\Invoices\Models\Invoice;
use App\Invoices\Models\Line;
use App\Invoices\QuoteInvoice;
use App\Invoices\QuoteLine;
use App\Resources\Models\Resource;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class BookingsController extends Controller
{
	public function index(Request $request)
	{
		$bookableTypes = [];

		if ($request->has('date') && $request->has('type')) {
			$timeFrom = Carbon::parse($request->get('date') . " " . $request->get('time_from'));
			$timeTo = Carbon::parse($request->get('date') . " " . $request->get('time_to'));
			$bookables = BookableType::find($request->get('type'))->bookables;

			foreach ($bookables as $bookable) {
				$rooms = [];

				foreach ($bookable->resources as $resource) {
					$settings = $resource->settings;
					$roomsIds = $resource->ofType('room')->lists('id');
				}
//				 dd($roomsIds);

				$bookings = $bookable->bookings()
//           ->where(function ($q) use ($roomsIds) {
//             $q->whereIn('bookings.resource_id', $roomsIds);
//           })
           ->where(function ($q) use ($timeFrom, $timeTo) {
             $q->where(function ($q) use ($timeFrom, $timeTo) {
               $q->where('time_from', '>=', $timeFrom)
                 ->where('time_to', '<=', $timeTo);
             })
						 ->orWhere(function ($q) use ($timeFrom, $timeTo) {
							 $q->where('time_from', '<', $timeTo)
							   ->where('time_to', '>', $timeTo);
						 })
						 ->orWhere(function ($q) use ($timeFrom, $timeTo) {
							 $q->where('time_from', '<', $timeFrom)
							   ->where('time_to', '>', $timeFrom);
						 });
           });
				if ($bookings->count() == 0) {
					array_push($bookableTypes, $bookable);
					continue;
				}
			}
		}

		return [
			'bookableTypes' => collect($bookableTypes)
		];
	}

	/**
	 *
	 * @param CreateBookingForm $request
	 *
	 * @return string
	 */
	public function store(CreateBookingForm $request)
	{
		if (!auth()->user()->member->hasStripeId()) {
			return response()->json($data = [
				'error' => [
					'needsPaymentMethod' => true,
					'messages'           => [
						'No tienes ningún metodo de pago definido',
					]
				]
			], 422);
		}

		$bookable = Bookable::findOrFail($request->get('bookable'));
		$resources = ['rooms' => []];

		foreach ($bookable->resources as $resource) {
			$settings = $resource->settings;
			if ($resource->ofType('room')) {
				$resources['rooms'][] = $resource->resourceable;
			}
		}

		$member = Auth::user()->member;


		$invoice = Invoice::create(['paid' => 0]);
		$invoice->toMember($member);
		$line = new Line([
			'price'       => $settings['price'],
			'name'        => $bookable->name,
			'description' => $bookable->description,
			'amount'      => 1
		]);

		$invoice->addLine($line);
//
		if ($member) {
			// Discountline
			// $discountLine = ?¿?¿?
			// $invoice-addLine($discountLine);
		}
		$invoice->save();

		// Make Stripe Charge
		$member->charge($invoice->getTotalForStripe(), [
			"currency" => $member->getCurrency(),
			"customer" => $member->id
		]);

		$rooms = collect($resources['rooms']);

		$rooms->first();

		$timeFrom = Carbon::parse($request->get('date') . " " . $request->get('time_from'));
		$timeTo = Carbon::parse($request->get('date') . " " . $request->get('timeto'));


		$booking = $member->bookings()->create([
			'time_from' => $timeFrom,
			'time_to'   => $timeTo
		]);


		$booking->bookable()->associate($bookable);
		$booking->resource()->associate($rooms->first());
		$booking->save();

		return response()->json([
			'success' => [
				'messages' => [
					'Tu reserva se ha realizado correctamente. Gracias! Te hemos enviado un email con los detalles.',
				]
			]
		], 200);
	}


	/**
	 * Returns the row for the billing
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function calculate(Request $request)
	{
		$timeFrom = Carbon::parse($request->get('date') . " " . $request->get('time_from'));
		$timeTo = Carbon::parse($request->get('date') . " " . $request->get('time_to'));

		$bookable = Bookable::findOrFail($request->get('bookable'));

		$resources = [
			'rooms' => []
		];

		foreach ($bookable->resources as $resource) {
			$settings = $resource->settings;
			if ($resource->ofType('room')) {
				$resources['rooms'][] = $resource->resourceable;
			}
		}

		$invoice = new QuoteInvoice();

		$line = new QuoteLine([
			'price'       => (int) $settings['price'],
			'name'        => $bookable->name,
			'description' => $bookable->description
		]);

		$invoice->addLine($line);


		if (Auth::user()) {
			// Discountline
			// $discountLine = ?¿?¿?
			// $invoice-addLine($discountLine);
		}

//		dd($invoice);
		return $invoice->toJson();
	}
}
