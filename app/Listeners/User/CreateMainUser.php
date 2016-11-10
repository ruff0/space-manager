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

		$_SERVER['h3rt'] = $psw = str_random(8);

		return $member->users()->create([
			"email"    => $member->email,
			"password" => bcrypt($psw)
		]);
	}
}
