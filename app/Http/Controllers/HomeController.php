<?php

namespace App\Http\Controllers;

use Laracasts\Utilities\JavaScript\JavaScriptFacade;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 */
	public function __construct()
	{
		$this->middleware('auth');
	 	$user = auth()->user();

		JavaScriptFacade::put([
			'needsProfile'  => $user->hasProfile() ? false : true,
			'user' => $user,
		]);
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
//		dd(session());
		return view('pages.home');
	}
}
