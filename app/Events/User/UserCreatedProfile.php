<?php

namespace App\Events\User;

use App\Events\Event;
use App\User\Profile;

class UserCreatedProfile extends Event
{
	/**
	 * @var Profile
	 */
	public $profile;

	/**
	 * @var array
	 */
	public $company;

	/**
	 * Create a new event instance.
	 *
	 * @param \App\User\Profile $profile
	 * @param array             $company
	 */
	public function __construct(Profile $profile, $company = [])
	{
		$this->profile = $profile;
		$this->company = $company;
	}
}
