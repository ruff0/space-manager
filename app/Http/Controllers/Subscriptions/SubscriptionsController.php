<?php

namespace App\Http\Controllers\Subscriptions;


use App\Space\PlanType;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubscriptionsController extends Controller
{
	public function create(){
		$plantypes = PlanType::with('plans')->get();

		return view('subscriptions.index', [
			'plantypes' => $plantypes
		]);
	}
}
