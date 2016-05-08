<?php namespace App\Space\Services;


use Illuminate\Contracts\Auth\Guard;

class CurrentMember
{
	/**
	 * @var Guard
	 */
	protected $auth;

	/**
	 * CurrentMember constructor.
	 *
	 * @param Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	public function loadMember()
	{
		return $this->auth->user()->member;
	}

}
