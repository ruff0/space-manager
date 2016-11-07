<?php

namespace App\Http\Controllers\Events;

use App\Events\EloquentEvent;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param $event
	 * @return \Illuminate\Http\Response
	 */
	public function show(EloquentEvent $event)
	{
		return view('events.show', [
			'event' => $event
		]);
	}

}
