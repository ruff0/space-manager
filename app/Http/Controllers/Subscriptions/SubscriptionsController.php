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
		$plantypes = PlanType::with('plans')->get();

		return view('subscriptions.index', [
			'plantypes' => $plantypes
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 *
	 * @param Subscription $subscriptions
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Subscription $subscriptions)
	{

		dd($subscriptions);
	}
}
