<?php

namespace App\Events\Space\Contracts;

interface MemberInterface {

	/**
	 * Returns a member instance
	 * @return \App\Space\Member
	 */
	public function getMember();
}