<?php

namespace App\Http\Controllers\Subscriptions;


use App\Space\PlanType;
use App\Space\Subscription;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubscriptionsController extends Controller
{
	/**
	 * @return mixed
	 */
	public function create()
	{
		$plantypes = PlanType::with('plans')->where('active', true)->get();

		return view('subscriptions.create', [
			'plantypes' => $plantypes
		]);
	}
}
