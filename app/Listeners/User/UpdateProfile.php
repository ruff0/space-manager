<?php

namespace App\Listeners\User;

use App\Events\Space\Contracts\MemberInterface;
use App\Events\Space\MemberFilledData;
use App\User\Profile;

class UpdateProfile
{

	/**
	 * Handle the event.
	 *
	 * @param MemberInterface $event
	 *
	 */
	public function handle(MemberInterface $event)
	{
		$member = $event->getMember();

		$profile =  $member->mainUser()->profile()->create(
			$member->toArray()
		);

		return $profile;
	}
}
