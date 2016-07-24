<?php

namespace App\Http\Controllers\Api\Bookings;

use App\Bookables\Bookable;
use App\Bookables\BookableType;
use App\Bookings\Booking;
use App\Http\Requests\Api\BookingsSearchRequest;
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
	/**
	 * @param BookingsSearchRequest $request
	 *
	 * @return array
	 */
	public function index(BookingsSearchRequest $request)
	{
		$available = [];
		$persons = $request->has('persons') ? $request->get('persons') : 0;
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
								if($persons > 0)
								{
									if($bookable->max_occupants >= $persons)
									{
										$available[] = $bookable->id;
									}
								}
								else {
									$available[] = $bookable->id;
								}


							}
						}
					}
				}
			}
		}

		$hours = $timeFrom->diffInHours($timeTo);

		return [
			'available' => BookableType::find($request->get('type'))->bookables()
				->availableWithIn($hours, $available, $timeFrom, $timeTo),
			'notavailable' => BookableType::find($request->get('type'))->bookables()->notAvailableWithIn($available)
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
		if ($request->exists('member') && $request->has('member'))
		{
			$member = Member::findOrFail($request->get('member'));
		}
		else
		{
			$member = Auth::user()->member;
		}

		$paymentMethod = 'card';

		if($request->has('payment'))
		{
			$paymentMethod = $request->get('payment');
		}

		$persons = $request->has('persons') ? $request->get('persons') : null;
		$distribution = $request->has('distribution') ? $request->get('distribution') : null;

		if ($paymentMethod == 'card' && !$member->hasStripeId()) {
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
		$timeFrom = Carbon::parse($request->get('date') . " " . $request->get('time_from'));
		$timeTo = Carbon::parse($request->get('date') . " " . $request->get('time_to'));
		$hours = $timeFrom->diffInHours($timeTo);

		$resource = $bookable->firstWithoutBookings($hours, $timeFrom, $timeTo);
		$invoice = Invoice::create(['paid' => 0, 'type' => 'booking']);
		$invoice->toMember($member);
		$description = '';

		if($persons){
			$description .= "Un total de " . $persons. '<br>';
		}
		if($distribution) {

			switch($distribution){
				case 'u': $text =  'en forma de U.';
					break;
				case 'line': $text = 'en linea.';
					break;
				case 'chairs': $text = 'solo sillas en fila.';
			}

			$description .= "y la distribución " . $text;
		}


		$line = new Line([
			'price'       => (int) $bookable->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true),
			'name'        => $bookable->name,
			'description' => $bookable->description,
			'amount'      => 1
		]);
		$invoice->addLine($line);

		$passHours = 0;

		if ($member) {
			$discount = $member->appliedDiscounts('bookings');

			if ($pass = $member->hasPassForType($bookable->id, $timeFrom)) {
				if (!$bookable->isPartTime($hours, $timeFrom, $timeTo) && $hours < 6 && $pass->hours) {

					if ($pass->hours < $hours) {
						$passHours = $pass->hours;
					} else {
						$passHours = $hours;
					}

					$price = $bookable->calculatePriceForTimeFrame($passHours, $timeFrom, $timeTo, true);
					$percentage = 100;
					$total = ($price / 100) * $percentage;
					$line = new Line([
						'price'       => -$total,
						'name'        => "Bono por horas ({$passHours} hrs.)",
						'description' => "Descuento aplicado por bono de horas ({$passHours} hrs.)",
						'amount'      => 1
					]);
					$invoice->addLine($line);
				}
			}
			
			if ((($pass && $pass->hours < $hours) || (!$pass)) &&
			    $discount && Carbon::parse($discount['date_to'])->gte(Carbon::now())) {
				$price = $bookable->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true);

				$percentage = $discount['percentage'];
				if ($percentage) {
					$total = ($price / 100) * $percentage;
					$discountLine = new Line([
						'price'       => (int)-$total,
						'name'        => 'Descuento',
						'description' => "Descuento aplicado $percentage%",
						'amount'      => 1
					]);

					$invoice->addLine($discountLine);
				}
			}
		}

		$invoice->save();

		// Make Stripe Charge
		if($paymentMethod == 'card' && !$passHours && $invoice->getTotalForStripe() )
		{
			$invoice->pay();
		}

		$member->decrementPassFor($bookable->id, $passHours);
		$booking = $member->bookings()->create([
			'time_from' => $timeFrom,
			'time_to'   => $timeTo,
			'persons'   => $persons,
			'distribution'  => $distribution
		]);

		$booking->bookable()->associate($bookable->id);
		$booking->resource()->associate($resource->id);
		$booking->save();

		$invoice->payable_id = $booking->id;
		$invoice->save();

		return response()->json([
			'success' => [
				'messages' => [
					'Tu reserva se ha realizado correctamente. Gracias! Te hemos enviado un email con los detalles.',
				]
			]
		], 200);
	}

	/**
	 * @param Booking $bookings
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(Booking $bookings, Request $request)
	{
		
		if($request->has('action'))
		{
			$action = $request->get('action');
			$bookings->$action($request->all());
		}

		return response()->json([
			'success' => [
				'messages' => [
					'La reserva se ha marcado como pagada',
				]
			]
		], 200);

	}
	
	/**
	 * @param Booking $bookings
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(Booking $bookings)
	{
		if(!$bookings->paid) {
			$bookings->delete();

			return response()->json($bookings);
		}

		return response()->json(
			[
				'data'=> [
					'errors' => [
						'booking' => 'No se ha podido borrar'
					]
				]
			], 421);
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
		if($request->exists('member') && $request->has('member'))
		{
			$member = Member::findOrFail($request->get('member'));
		}
		else
		{
			$member = Auth::user()->member;
		}


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

		$description = '';
		$persons = $request->has('persons') ? $request->get('persons') : null;
		$distribution = $request->has('distribution') ? $request->get('distribution') : null;
		if ($persons) {
			$description .= "Un total de " . $persons . ' personas <br>';
		}
		if ($distribution) {

			switch ($distribution) {
				case 'u':
					$text = 'en forma de U.';
					break;
				case 'line':
					$text = 'en linea.';
					break;
				case 'chairs':
					$text = 'solo con sillas en fila.';
			}

			$description .= "Con una distribución " . $text;
		}

		$line = new QuoteLine([
			'price'       => (int) $bookable->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true),
			'name'        => $bookable->name,
			'description' => $bookable->description .
			                 $description.
			                 "<br/> <small>Reserva el dia {$timeFrom->format('d/m/Y')}</small>".
			                 "<br/> <small>Desde {$timeFrom->format('H:i')} - Hasta {$timeTo->format('H:i')} • ({$hours} hrs.)  "
		]);
		$invoice->addLine($line);

		$discount = $member->appliedDiscounts('bookings');

		if($pass = $member->hasPassForType($bookable->id, $timeFrom))
		{
			if (!$bookable->isPartTime($hours, $timeFrom, $timeTo) &&  $hours < 6 && $pass->hours) {
				if ($pass->hours < $hours)	$passHours = $pass->hours;
				else $passHours = $hours;

				$price = $bookable->calculatePriceForTimeFrame($passHours, $timeFrom, $timeTo, true);
				$percentage = 100;
				$total = ($price / 100) * $percentage;
				$line = new QuoteLine([
					'price'       => -$total,
					'name'        => "Bono por horas ({$passHours} hrs.)",
					'description' => "Descuento aplicado por bono de horas ({$passHours} hrs.)"
				]);
				$invoice->addLine($line);
			}
		}

		if( (($pass && $pass->hours < $hours ) || (!$pass)) &&
			$discount && Carbon::parse($discount['date_to'])->gte(Carbon::now())
		)
		{
			$price = $bookable->calculatePriceForTimeFrame($hours, $timeFrom, $timeTo, true);
			$percentage = $discount['percentage'];
		  if($percentage)
		  {
			  $total = ($price / 100) * $percentage;
			  $line = new QuoteLine([
				  'price'       => -$total,
				  'name'        => "Descuento $percentage%",
				  'description' => "Descuento aplicado $percentage%"
			  ]);
			  $invoice->addLine($line);
		  }
		}

		return $invoice->toJson();
	}
}
