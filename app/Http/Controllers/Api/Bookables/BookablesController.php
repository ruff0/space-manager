<?php

namespace App\Http\Controllers\Api\Bookables;

use App\Bookables\Bookable;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BookablesController extends Controller
{
	/**
	 * @return mixed
	 */
	public function index()
	{
		$bookables = Bookable::whereActive(true)->get();

		return $bookables;
	}

	/**
	 * @param Bookable $bookables
	 *
	 * @return Bookable
	 */
	public function show(Bookable $bookables)
	{
		$resources = [
			'rooms' => []
		];

		foreach ($bookables->resources as $resource) {
			$settings = $resource->settings;

				if($resource->ofType('room'))
				$resources['rooms'][] = $resource->resourceable;

		}

		$bookables->settings = $settings;
		$bookables->rooms = collect($resources['rooms']);
		return $bookables;
	}
}
