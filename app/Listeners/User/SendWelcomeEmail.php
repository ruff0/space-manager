<?php

namespace App\Listeners\User;

use App\Events\Space\Contracts\MemberInterface;
use App\Jobs\SendWelcomeMail;

class SendWelcomeEmail
{

	/**
	 * Handle the event.
	 *
	 *
	 * @param MemberInterface $event
	 *
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function handle(MemberInterface $event)
	{
		$member = $event->getMember();

		$user = new \stdClass();
		$user->name = $member->fullName();
		$user->email = $member->email;
		dispatch(new SendWelcomeMail($user));
	}
}
