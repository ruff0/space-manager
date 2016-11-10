<?php

namespace App\Events\User;

use App\Events\Event;
use App\User\User;

class UserRegistered extends Event
{
	/**
	 * @var User
	 */
	private $user;


	/**
	 * Create a new event instance.
	 *
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}
}
