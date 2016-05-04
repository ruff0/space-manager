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
							$q->where('date_from', '>=', $dateFrom)
							  ->where('date_to', '<=', $dateTo);
						})
						  ->orWhere(function ($q) use ($dateFrom, $dateTo) {
							  $q->where('date_from', '<', $dateTo)
							    ->where('date_to', '>', $dateTo);
						  })
						  ->orWhere(function ($q) use ($dateFrom, $dateTo) {
							  $q->where('date_from', '<', $dateFrom)
							    ->where('date_to', '>', $dateFrom);
						  });
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

		$plan = Plan::findOrFail($request->get('plan'));
		$resources = ['rooms' => []];

		foreach ($plan->resources as $resource) {
			$settings = $resource->settings;
			if ($resource->ofType('room')) {
				$resources['rooms'][] = $resource->resourceable;
			}
		}

		$member = Auth::user()->member;


		$invoice = Invoice::create(['paid' => 0]);
		$invoice->toMember($member);
		$line = new Line([
			'price'       => $plan->priceForStripe(),
			'name'        => $plan->name,
			'description' => $plan->description,
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
		$charge = $member->charge($invoice->getTotalForStripe(), [
			"currency" => $member->getCurrency(),
			"customer" => $member->id
		]);

		$invoice->charge_id = $charge->id;
		$invoice->save();

		$rooms = collect($resources['rooms']);

		$rooms->first();

		$dateFrom = Carbon::parse($request->get('date_from'));
		$dateTo = $request->has('date_to') ? Carbon::parse($request->get('date_to')) : Carbon::parse("20991231");

		$subscription = $member->subscriptions()->create([
			'date_from' => $dateFrom,
			'date_to'   => $dateTo
		]);

		$subscription->plan()->associate($plan);
		$subscription->resource()->associate($rooms->first());
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

		$resources = [
			'rooms' => []
		];

		foreach ($plan->resources as $resource) {
			$settings = $resource->settings;
			if ($resource->ofType('room')) {
				$resources['rooms'][] = $resource->resourceable;
			}
		}

		$invoice = new QuoteInvoice();

		$line = new QuoteLine([
			'price'       => (int) $plan->priceForStripe(),
			'name'        => $plan->name,
			'description' => $plan->description
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
