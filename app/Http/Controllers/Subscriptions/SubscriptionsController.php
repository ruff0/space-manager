<?php

namespace App\Http\Controllers\Subscriptions;

use App\Space\Plan;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubscriptionsController extends Controller
{
	public function create(){
		$plans = Plan::all();

		return view('subscriptions.index', [
			'plans' => $plans
		]);
	}
}
