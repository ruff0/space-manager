<?php

namespace App\Http\Controllers\Api\Events;

use App\Events\Commands\CreateEventOrganizedByUser;
use App\Events\EloquentEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function index()
	{
		$events = EloquentEvent::all();

		$events = $events->map(function($event) {
			return $this->transform($event);
		});

		return response()->json([
			"data" => $events
		]);
	}


	/**
	 * @param EloquentEvent $event
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	public function show(EloquentEvent $event)
	{
		return response()->json([
			"data" => $this->transform($event)
		]);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
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

	/**
	 * @param $event
	 * @return array
	 * @author Boudy de Geer <boudydegeer@mosaiqo.com>
	 */
	protected function transform($event)
	{
		$url = env("APP_URL", 'https://be.ulab.es');
		return [
			'id' => $event->id,
			'title' => $event->title,
			'description' => $event->description,
			'image' => "{$url}/$event->image",
			'status' => 'available',
			'venue' => [
				"id" => "",
				"name" => "ULab",
				"address" => "Plaza de San Cristobal 14",
				"state" => "Alicante",
				"city" => "Alicante",
				"zip" => "03002",
				"phone" => "+34 966444114"
			],
			'purchaseLing' => "{$url}/events/{$event->id}",
			'attendees' => [
				'max' => $event->persons,
				'registered' => 0,
				'available' => $event->persons,
			],
			"date" => [
				"init" => Carbon::parse("{$event->date} {$event->from}")->getTimestamp(),
				"finish" => Carbon::parse("{$event->date} {$event->to}")->getTimestamp()
			]
		];
	}
}
