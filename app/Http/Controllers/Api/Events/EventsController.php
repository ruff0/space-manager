<?php

namespace App\Http\Controllers\Api\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
	public function store(Request $request)
	{
		$event = CreaEventOrganizedByUser::fromRequest($request);

		return response()->json([
			 "data" => $event->toArray(),
			 "success" => [
			 	 "message" => [
			 	 	 "Tu evento se ha creado correctamente."
			   ]
			 ]
		]);
	}
}
