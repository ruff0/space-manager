<?php

namespace App\Events\Space;

use App\Events\Event;
use App\Space\Plan;


class PlanWasCreated extends Event
{
	/**
	 * @var Plan
	 */
	public $plan;

	/**
	 * Create a new event instance.
	 *
	 * @param Plan $plan
	 */
	public function __construct(Plan $plan)
	{
		$this->plan = $plan;
	}
}
