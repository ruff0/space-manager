<?php

namespace App\Http\Controllers;

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

		JavaScriptFacade::put([
			'needsProfile'  => $user->hasProfile() ? false : true,
			'user' => $user,
		]);

		view()->share('user', $user);

		if(!$user->hasProfile())
		{
			view()->share('profile', new Profile);
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
