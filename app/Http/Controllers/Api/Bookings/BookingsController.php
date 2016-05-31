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
use App\Space\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class BookingsController extends Controller
{
	public function index(Request $request)
	{
		$available = [];

		if ($request->has('date') && $request->has('type')) {
			$timeFrom = Carbon::parse($request->get('date') . " " . $request->get('time_from'));
			$timeTo = Carbon::parse($request->get('date') . " " . $request->get('time_to'));
			$bookables = BookableType::find($request->get('type'))->bookables()->get();


			foreach ($bookables as $bookable)
			{
				foreach ($bookable->roomResources() as $resource)
				{
					$settings = $resource->settings;
					$bookings = $resource->bookings()->where(function ($q) use ($timeFrom, $timeTo) {
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
					if($bookings->count() == 0)
					{
						foreach ($resource->bookables as $bookable) {
							if(!in_array($bookable->id, $available))
							{
								$available[] = $bookable->id;
							}
						}
					}
				}
			}
		}

		$hours = $timeFrom->diffInHours($timeTo);

		return [
			'available' => BookableType::find($request->get('type'))->bookables()
				->getWithHours($hours, $available, $timeFrom, $timeTo),
			'notavailable' => BookableType::find($request->get('type'))->bookables()->whereNotIn('id', $available)->get()
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

		$timeFrom = Carbon::parse($request->get('date') . " " . $request->get('time_from'));
		$timeTo = Carbon::parse($request->get('date') . " " . $request->get('time_to'));
		$hours = $timeFrom->diffInHours($timeTo);


		$invoice = Invoice::create(['paid' => 0]);
		$invoice->toMember($member);
		$line = new Line([
			'price'       => (int) $bookable->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true),
			'name'        => $bookable->name,
			'description' => $bookable->description,
			'amount'      => 1
		]);

		$invoice->addLine($line);


		if ($member) {
			$discount = $member->appliedDiscounts('bookings');

			if (Carbon::parse($discount['date_to'])->gte(Carbon::now())) {
				$price = $bookable->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true);
				$percentage = $discount['percentage'];
				$total = ($price / $percentage);

				$discountLine = new Line([
					'price'       => (int) - ($total * 10),
					'name'        => 'Descuento',
					'description' => "Descuento aplicado $percentage%",
					'amount'      => 1
				]);

				$invoice->addLine($discountLine);
			}
		}

		$invoice->save();

		// Make Stripe Charge
		$charge = $member->charge($invoice->getTotalForStripe(), [
			"currency" => $member->getCurrency(),
			"customer" => $member->id
		]);

		$invoice->charge_id = $charge->id;
		$invoice->save();

		$rooms = collect($resources['rooms']);

		$rooms->first();

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
		$hours  = $timeFrom->diffInHours($timeTo);

		$bookable = Bookable::findOrFail($request->get('bookable'));

		$resources = [
			'rooms' => []
		];


		$bookable->calculatePrice($hours, $timeFrom, $timeTo);

		foreach ($bookable->resources as $resource)
		{
			$settings = $resource->settings;
			if ($resource->ofType('room')) {
				$resources['rooms'][] = $resource->resourceable;
			}
		}
		
		$invoice = new QuoteInvoice();
		
		$line = new QuoteLine([
			'price'       => (int) $bookable->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true),
			'name'        => $bookable->name,
			'description' => $bookable->description
		]);
		$invoice->addLine($line);

		$member = Auth::user()->member;
		$discount = $member->appliedDiscounts('bookings');

		if(Carbon::parse($discount['date_to'])->gte(Carbon::now())) {
			$price = $bookable->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true);
			$percentage = $discount['percentage'];
			$total = ($price  / $percentage);
			$line = new QuoteLine([
				'price' => - ($total * 10),
				'name'  => "Descuento $percentage%",
				'description' => "Descuento aplicado $percentage%"
			]);
			$invoice->addLine($line);
		}



		if (Auth::user()) {
			// Discountline
			// $discountLine = ?¿?¿?
			// $invoice-addLine($discountLine);
		}

//		dd($invoice);
		return $invoice->toJson();
	}
}
