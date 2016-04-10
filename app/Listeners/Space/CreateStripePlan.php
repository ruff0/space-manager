<?php

namespace App\Listeners\Space;

use App\Events\Space\PlanWasCreated;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Stripe\Plan as StripePlan;
use Stripe\Stripe;

class CreateStripePlan
{
	/**
	 * The Stripe API key.
	 *
	 * @var string
	 */
	protected static $stripeKey;

	/**
	 * @var StripePlan
	 */
	private $stripePlan;

	/**
	 * Create the event listener.
	 *
	 * @param StripePlan $stripePlan
	 */
	public function __construct(StripePlan $stripePlan)
	{
		$this->stripePlan = $stripePlan;

		Stripe::setApiKey($this->getStripeKey());
	}

	/**
	 * Returns Stripe Api Key
	 * @return string
	 */
	protected function getStripeKey()
	{
		return static::$stripeKey ?: Config::get('services.stripe.secret');
	}

	/**
	 * Handle the event.
	 *
	 * @param  PlanWasCreated $event
	 *
	 * @return StripePlan
	 */
	public function handle(PlanWasCreated $event)
	{

		$plan = $this->stripePlan->create([
			"id"                   => $event->plan->slug,
			"amount"               => $event->plan->priceForStripe(),
			"currency"             => "eur", // User always €
			"interval"             => "month",
			"name"                 => $event->plan->name,
			"statement_descriptor" => Str::limit("Ulab - {$event->plan->name}", 22, '')
		]);

		return $plan;
	}
}
