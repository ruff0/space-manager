<?php

namespace App\Http\Controllers\Api\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return response()->json([
			"data" => [
				$this->mockCategories()
			]
		]);
	}

	private function mockCategories()
	{
		return [
			[
				"id" => "6a5d4b22-fff7-4aeb-9875-1cf9e3654bbe",
				"name" => "Categoria 1",
				"color" => [
					"rgb" => "#ff0004"
				],
				"backgroundColor" => [
					"rgb" => "#ff0004"
				],
				"icon" => [
					"url" => ""
				]
			],
			[
				"id" => "6a5d4b22-fff7-4aeb-9875-2cf9e3654bbe",
				"name" => "Categoria 2",
				"color" => [
					"rgb" => "#00ff04"
				],
				"backgroundColor" => [
					"rgb" => "#ff0004"
				],
				"icon" => [
					"url" => ""
				]
			],
			[
				"id" => "6a5d4b22-fff7-4aeb-9875-3cf9e3654bbe",
				"name" => "Categoria 3",
				"color" => [
					"rgb" => "#0040ff"
				],
				"backgroundColor" => [
					"rgb" => "#ff0004"
				],
				"icon" => [
					"url" => ""
				]
			],
			[
				"id" => "6a5d4b22-fff7-4aeb-9875-4cf9e3654bbe",
				"name" => "Categoria 4",
				"color" => [
					"rgb" => "#104c00f"
				],
				"backgroundColor" => [
					"rgb" => "#ff0004"
				],
				"icon" => [
					"url" => ""
				]
			],
		];

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
