<?php

namespace App\Http\Controllers\Api\Space;

use App\Space\Member;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentMethods extends Controller
{
	public function store(Request $request, Member $members)
	{
		$user = auth()->user();
		if($user->member->id != $members->id)
			abort(401, 'You are not authorized');


		if (!$members->hasStripeId()) {
			$customer = $members->createAsStripeCustomer($request->get('stripe_token'), [
				"metadata" => [
					'name'     => $user->profile->name,
					'lastname' => $user->profile->lastname,
					'phone'    => $user->profile->phone,
				]
			]);
		}

		if (!$members->hasStripeId()) {
			return response()->json($data = [
				'error' => [
					'needsPaymentMethod' => true,
					'messages'           => [
						'Ha habido un error, recarga la página y vuelve a intentarlo',
					]
				]
			], 422);
		}

		else {
			return response()->json($data = [
				'success' => [
					'needsPaymentMethod' => false,
				]
			], 201);
		}
	}
}
