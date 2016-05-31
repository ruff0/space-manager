<?php

namespace App\Http\Controllers\Api\Space;

use App\Http\Requests\Space\CreateSubscriptionForm;
use App\Invoices\Models\Invoice;
use App\Invoices\Models\Line;
use App\Invoices\QuoteInvoice;
use App\Invoices\QuoteLine;
use App\Space\Plan;
use App\Space\PlanType;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class SubscriptionsController extends Controller
{
	public function index(Request $request)
	{
		$available = [];
		if ($request->has('date_from') && $request->has('type')) {
			$dateFrom = Carbon::parse(Carbon::now());
			$dateTo = $request->has('date_to')? Carbon::parse($request->get('date_to')) : Carbon::parse("20991231");
			$plans = PlanType::find($request->get('type'))->plans()->get();
			foreach ($plans as $plan)
			{
				foreach ($plan->roomResources() as $resource)
				{
					$settings = $resource->settings;
					$subscriptions = $resource->subscriptions()->where(function ($q) use ($dateFrom, $dateTo) {
						$q->where(function ($q) use ($dateFrom, $dateTo) {
							$q->where('date_from', '>=', $dateFrom)
								->where('date_to', '<=', $dateTo);
						});
//						  ->orWhere(function ($q) use ($dateFrom, $dateTo) {
//							  $q->where('date_from', '<', $dateTo)
//							    ->where('date_to', '>', $dateTo);
//						  })
//						  ->orWhere(function ($q) use ($dateFrom, $dateTo) {
//							  $q->where('date_from', '<', $dateFrom)
//							    ->where('date_to', '>', $dateFrom);
//						  });
					});

					if($subscriptions->count() == 0)
					{
						foreach ($resource->plans as $plan) {
							if(!in_array($plan->id, $available))
							{
								$available[] = $plan->id;
							}
						}
					}
				}
			}
		}

		return [
			'available' => PlanType::find($request->get('type'))->plans()->whereIn('id', $available)->get(),
			'notavailable' => PlanType::find($request->get('type'))->plans()->whereNotIn('id', $available)->get()
		];
	}


	public function rooms(Request $request)
	{
		$available = [];
		$notAvailable = [];

		if ($request->has('date_from') && $request->has('type')) {
			$dateFrom = Carbon::parse($request->get('date_from'));
			$dateTo = $request->has('date_to')? Carbon::parse($request->get('date_to')) : Carbon::parse("20991231");
			$plans = PlanType::find($request->get('type'))->plans()->get();
			foreach ($plans as $plan)
			{
				foreach ($plan->roomResources() as $resource)
				{
					$settings = $resource->settings;
					$subscriptions = $resource->subscriptions()->where(function ($q) use ($dateFrom, $dateTo) {
						$q->where(function ($q) use ($dateFrom, $dateTo) {
							$q->where('date_from', '>=', $dateFrom);
//							  ->where('date_to', '<=', $dateTo);
						});
//						  ->orWhere(function ($q) use ($dateFrom, $dateTo) {
//							  $q->where('date_from', '<', $dateTo)
//							    ->where('date_to', '>', $dateTo);
//						  })
//						  ->orWhere(function ($q) use ($dateFrom, $dateTo) {
//							  $q->where('date_from', '<', $dateFrom)
//							    ->where('date_to', '>', $dateFrom);
//						  });
					})->get();


					if($plan->id == $request->get('plan'))
					{
						if ($subscriptions->count() === 0) {
							if (!array_key_exists($resource->resourceable->id, $available)) {
								$available[$resource->resourceable->id] = $resource->resourceable;
							}
						} else {
							if (!array_key_exists($resource->resourceable->id, $notAvailable)) {
								$notAvailable[$resource->resourceable->id] = $resource->resourceable;
							}
						}
					}

				}
			}
		}

		return [
			'available'    => collect($available),
			'notavailable' => collect($notAvailable)
		];
	}

	/**
	 *
	 * @param CreateSubscriptionForm $request
	 *
	 * @return string
	 */
	public function store(CreateSubscriptionForm $request)
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

		$dateFrom = Carbon::parse($request->get('date_from'));
		$dateTo = $request->has('date_to') ? Carbon::parse($request->get('date_to')) : Carbon::parse("20991231");


		$plan = Plan::findOrFail($request->get('plan'));
		$room = $plan->resources()->where('resources.resourceable_id', $request->get('room'))->first();
//		dd($room);
		$isBooked = $room->subscriptions()->where(function ($q) use ($dateFrom, $dateTo) {
			$q->where(function ($q) use ($dateFrom, $dateTo) {
				$q->where('date_from', '>=', $dateFrom);
//				  ->where('date_to', '<=', $dateTo);
			});
//			  ->orWhere(function ($q) use ($dateFrom, $dateTo) {
//				  $q->where('date_from', '<', $dateTo)
//				    ->where('date_to', '>', $dateTo);
//			  })
//			  ->orWhere(function ($q) use ($dateFrom, $dateTo) {
//				  $q->where('date_from', '<', $dateFrom)
//				    ->where('date_to', '>', $dateFrom);
//			  });
		})->first();

		if($isBooked)
		{
			return response()->json([
				'error' => [
					'messages' => [
						"Lo sentimos pero ya esta alquilado, intenta volver atras y alquilar otro puesto o sala ",
					]
				]
			], 422);
		}

		$member = Auth::user()->member;


		$invoice = Invoice::create(['paid' => 0, 'type' => 'plan']);
		$invoice->toMember($member);

		// Default price
		$price = $plan->priceForStripe();

		// If necessary only charge the partial
		if ($dateFrom->copy()->firstOfMonth() != $dateFrom && $dateFrom->copy()->lastOfMonth() != $dateFrom) {
			$daysToCharge = $dateFrom->diffInDays($dateFrom->copy()->lastOfMonth());
			$price = ($plan->priceForStripe() / 30) * $daysToCharge;
		}


		$line = new Line([
			'price'       => $price,
			'name'        => $plan->name,
			'description' => $plan->description,
			'amount'      => 1
		]);

		$invoice->addLine($line);

		if ($member) {
			$discount = $member->appliedDiscounts('plans');

			if ($discount['percentage'] && Carbon::parse($discount['date_to'])->gte(Carbon::now())) {
				$percentage = $discount['percentage'];
				$total = ($price / 100) * $percentage;

				$discountLine = new Line([
					'price'       => (int) - $total,
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

		foreach($plan->discounts as $type => $discount)
		{
			if(!$member->hasDiscount($type))
			{
				$member->discounts()->create([
					'percentage' => $discount,
					'date_from'  => Carbon::now(),
					'date_to'    => Carbon::parse("2099-12-31 00:00:00"),
					'type'       => $type
				]);
			}
		}

		$invoice->charge_id = $charge->id;
		$invoice->save();

		$subscription = $member->subscriptions()->create([
			'date_from' => $dateFrom,
			'date_to'   => $dateTo
		]);

		$subscription->plan()->associate($plan);
		$subscription->resource()->associate($room);
		$subscription->save();

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
		$dateFrom = Carbon::parse($request->get('date_from'));
		$dateTo = $request->has('date_to') ? Carbon::parse($request->get('date_to')) : Carbon::parse("20991231");

		$plan = Plan::findOrFail($request->get('plan'));


		$room = null;
		foreach ($plan->resources as $resource) {
			if ($resource->ofType('room') && $resource->resourceable->id == $request->get('room')) {
				$room = $resource->resourceable;
			}
		}

		$invoice = new QuoteInvoice();

		// Default price
		$price = $plan->priceForStripe();

		// If necessary only charge the partial
		if ($dateFrom->copy()->firstOfMonth() != $dateFrom && $dateFrom->copy()->lastOfMonth() != $dateFrom) {
			$daysToCharge = $dateFrom->diffInDays($dateFrom->copy()->lastOfMonth());
			$price = ($plan->priceForStripe() / 30) * $daysToCharge;
		}

		$line = new QuoteLine([
			'price'       => (int) $price,
			'name'        => $plan->name,
			'description' => $plan->description .
			                 "<br/> " . $room->name . " - {$room->floor}m<sup>2</sup> ({$room->max_occupants} pers.)  ".
			                 "<br/> <small>reserva apartir del {$dateFrom->format('d/m/Y')}</small>"
		]);

		$invoice->addLine($line);


		if (Auth::user()) {
			$member = Auth::user()->member;
			$discount = $member->appliedDiscounts('plans');

			if ($discount['percentage'] && Carbon::parse($discount['date_to'])->gte(Carbon::now())) {
				$price = $plan->priceForStripe();
				$percentage = $discount['percentage'];
				$total = ($price / 100 )* $percentage;
				$line = new QuoteLine([
					'price'       => - $total,
					'name' => "Descuento",
					'description' => "Descuento aplicado $percentage%"
				]);
				$invoice->addLine($line);
			}
		}

		return $invoice->toJson();
	}
}
