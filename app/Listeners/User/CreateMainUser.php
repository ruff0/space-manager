<?php

namespace App\Listeners\User;

use App\Events\Space\Contracts\MemberInterface;

class CreateMainUser
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

		return $member->users()->create([
			"email"    => $member->email,
			"password" => bcrypt(str_random(16))
		]);
	}
}
