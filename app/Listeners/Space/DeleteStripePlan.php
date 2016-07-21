<?php

namespace App\Listeners\Space;

use App\Events\Space\PlanWasDeleted;
use Illuminate\Support\Facades\Config;
use Stripe\Plan as StripePlan;
use Stripe\Stripe;

class DeleteStripePlan
{
	/**
	 * The Stripe API key.
	 *
	 * @var string
	 */
	protected static $stripeKey;

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
	 *
	 * @return string
	 */
	protected function getStripeKey()
	{
		return static::$stripeKey ?: Config::get('services.stripe.secret');
	}

	/**
	 * Handle the event.
	 *
	 * @param  PlanWasDeleted $event
	 *
	 * @return void
	 */
	public function handle(PlanWasDeleted $event)
	{
		$plan = $this->stripePlan->retrieve($event->plan->slug);
		$plan->delete();
		return $plan;
	}
}
