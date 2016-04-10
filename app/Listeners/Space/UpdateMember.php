<?php

namespace App\Listeners\Space;

use App\Events\User\UserCreatedProfile;

class UpdateMember
{

	/**
	 * Create the event listener.
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * Handle the event.
	 *
	 * @param  UserCreatedProfile $event
	 *
	 * @return void
	 */
	public function handle(UserCreatedProfile $event)
	{
		$event->profile->user->member->update(
			array_merge(
				$event->profile->toArray(),
				$event->company
			)
		);
	}
}
