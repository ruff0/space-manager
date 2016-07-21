<?php

namespace App\Http\Controllers\Webhooks;

use App\Invoices\Models\Invoice;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Stripe\Event as StripeEvent;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
	/**
	 * Handle a Stripe webhook call.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function handleWebhook(Request $request)
	{
		$payload = json_decode($request->getContent(), true);

		if (!$this->isInTestingEnvironment() && !$this->eventExistsOnStripe($payload['id'])) {
			return;
		}

		$method = 'handle' . studly_case(str_replace('.', '_', $payload['type']));

		if (method_exists($this, $method)) {
			return $this->{$method}($payload);
		} else {
			return $this->missingMethod();
		}
	}

	/**
	 * @param array $payload
	 */
	public function handleChargeSucceeded(array $payload)
	{
		$member = $this->getMemberByStripeId(
			$payload['data']['object']['customer']
		);

		$invoice = Invoice::findInvoiceByStripeCharge($payload['data']['object']['id']);

		if($invoice)
		{
			$latestNumber = Invoice::select('number')
				->where('paid', true )
				->where('id', '<>', $invoice->id)
				->max('number');

			if($latestNumber)
			{
				$latestNumber = explode("-", $latestNumber);

				$latestNumber[1] = sprintf('%05d', ($latestNumber[1] + 1) );

				if($latestNumber[0] != date("Y")) // Whe have new year
				{
					$latestNumber[1] = sprintf('%05d', 1); // First Invoice of the year
					$latestNumber[0] = date("Y");
				}

			}
			else
			{
				$latestNumber[1] = sprintf('%05d', 1); // First Invoice of the year
				$latestNumber[0] = date("Y");
			}

			$number = $latestNumber[0]. "-". $latestNumber[1];
			$invoice->number = $number;
			$invoice->paid = true;
			$invoice->save();
		}
		 // Trigger some event
	}

	/**
	 * Get the billable entity instance by Stripe ID.
	 *
	 * @param  string $stripeId
	 *
	 * @return \Laravel\Cashier\Billable
	 */
	protected function getMemberByStripeId($stripeId)
	{
		$model = getenv('STRIPE_MODEL') ?: config('services.stripe.model');

		return (new $model)->where('stripe_id', $stripeId)->first();
	}

	/**
	 * Verify with Stripe that the event is genuine.
	 *
	 * @param  string $id
	 *
	 * @return bool
	 */
	protected function eventExistsOnStripe($id)
	{
		try {
			return !is_null(StripeEvent::retrieve($id, config('services.stripe.secret')));
		} catch (Exception $e) {
			return false;
		}
	}

	/**
	 * Verify if cashier is in the testing environment.
	 *
	 * @return bool
	 */
	protected function isInTestingEnvironment()
	{
		return getenv('CASHIER_ENV') === 'testing';
	}

	/**
	 * Handle calls to missing methods on the controller.
	 *
	 * @param  array $parameters
	 *
	 * @return mixed
	 */
	public function missingMethod($parameters = [])
	{
		return new Response;
	}
}
