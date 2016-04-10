<?php

namespace App\Listeners\Space;

use App\Events\Space\PlanWasUpdated;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Stripe\Plan as StripePlan;
use Stripe\Stripe;

class UpdateStripePlan
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
	 * @param  PlanWasUpdated $event
	 *
	 * @return void
	 */
	public function handle(PlanWasUpdated $event)
	{
		$plan = $this->stripePlan->retrieve($event->plan->slug);
		$plan->name = $event->plan->name;
		$plan->statement_descriptor = Str::limit("Ulab - {$event->plan->name}", 22, '');
		
		return $plan->save();
	}
}
