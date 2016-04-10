<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'App\Events\Plan\PlanWasCreated' => [
			'App\Listeners\Plan\CreateStripePlan',
		],
		'App\Events\Plan\PlanWasDeleted' => [
			'App\Listeners\Plan\DeleteStripePlan',
		],
		'App\Events\Plan\PlanWasUpdated' => [
			'App\Listeners\Plan\UpdateStripePlan',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher $events
	 *
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
	}
}
