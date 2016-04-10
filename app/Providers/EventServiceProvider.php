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
		'App\Events\Space\PlanWasCreated' => [
			'App\Listeners\Space\CreateStripePlan',
		],
		'App\Events\Space\PlanWasDeleted' => [
			'App\Listeners\Space\DeleteStripePlan',
		],
		'App\Events\Space\PlanWasUpdated' => [
			'App\Listeners\Space\UpdateStripePlan',
		],

		'App\Events\User\UserCreatedProfile' => [
			'App\Listeners\Space\UpdateMember',
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
