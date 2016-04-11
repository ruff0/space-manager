<?php

namespace App\Http\Controllers;

use App\Space\Member;
use App\User\Profile;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 */
	public function __construct()
	{
		$user = auth()->user();

		if ($user) {
			JavaScriptFacade::put([
				'needsMemberData' => $user->needsMemberData()
			]);

			view()->share('user', $user);

			if ($user->needsMemberData()) {
				view()->share('member', $user->member);
			}
		}
	}


	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('pages.home');
	}
}
