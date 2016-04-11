<?php

namespace App\Events\Space;

use App\Events\Event;
use App\Events\Space\Contracts\MemberInterface;
use App\Space\Member;

class MemberRegistered extends Event implements MemberInterface
{
	/**
	 * @var Member
	 */
	protected $member;

	/**
	 * Create a new event instance.
	 *
	 * @param Member $member
	 */
	public function __construct(Member $member)
	{
		$this->member = $member;
	}

	/**
	 * Returns a member instance
	 *
	 * @return \App\Space\Member
	 */
	public function getMember()
	{
		return $this->member;
	}}
