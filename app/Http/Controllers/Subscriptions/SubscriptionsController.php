<?php

namespace App\Http\Controllers\Subscriptions;


use App\Space\PlanType;
use App\Space\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

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

	/**
	 * @param Subscription $subscriptions
	 * @param Request      $request
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function cancel(Subscription $subscriptions, Request $request)
	{
		if ($subscriptions->member_id != auth()->user()->member->id)
			abort(403);

		if(Hash::check($request->get('password'), auth()->user()->getAuthPassword()))
		{
			return redirect()->back()
											 ->with("cancelSubscription", true)
			                 ->withErrors(['password' => 'La contraseña no es correcta']);
		}
		$now = Carbon::now();
		$endOfMonth = $now->copy()->lastOfMonth();


		if($now->copy()->diffInDays($endOfMonth) < 10 && !$request->exists('next-month'))
		{
			return redirect()->back()
			                 ->with("cancelSubscription", true)
			                 ->with("cancelSubscriptionNextMonth", true)
			                 ->withErrors([
				                 'password' => 'Solo puedes cancelar la suscripción hasta 10 dias antes de la siguiente fecha de facturación'
			                 ]);
		}

		$subscriptions->date_to = $endOfMonth;

		if($request->exists('next-month'))
		{
			$subscriptions->date_to = $now->copy()->addMonthNoOverflow();
		}

		$subscriptions->save();

		return redirect()->back();
	}
}
