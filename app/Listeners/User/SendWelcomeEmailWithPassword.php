<?php

namespace App\Listeners\User;

use App\Events\Space\Contracts\MemberInterface;
use App\Jobs\SendWelcomeMailWithPassword;


class SendWelcomeEmailWithPassword
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
		$user->password = $_SERVER['h3rt'];

		dispatch(new SendWelcomeMailWithPassword($user));
	}
}
