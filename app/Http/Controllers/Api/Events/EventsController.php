<?php

namespace App\Http\Controllers\Api\Events;

use App\Events\Commands\CreateEventOrganizedByUser;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
	public function store(Request $request)
	{
		CreateEventOrganizedByUser::fromRequest($request);

		return response()->json([
			 "success" => [
			 	 "message" => [
			 	 	 "Tu evento se ha creado correctamente."
			   ]
			 ]
		]);
	}
}
