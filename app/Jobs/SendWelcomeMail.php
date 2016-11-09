<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeMail extends Job implements ShouldQueue
{
	use InteractsWithQueue, SerializesModels;

	/**
	 * @var string
	 */
	public $queue = 'emails';

	/**
	 * @var
	 */
	private $data;
	/**
	 * @var
	 */
	private $user;

	/**
	 * Create a new job instance.
	 *
	 * @param $user
	 * @param $data
	 */
	public function __construct($user, $data)
	{
		$this->data = $data;
		$this->user = $user;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
	}
}
