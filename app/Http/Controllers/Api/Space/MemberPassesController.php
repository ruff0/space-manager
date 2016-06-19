<?php

namespace App\Http\Controllers\Api\Space;

use App\Bookables\Bookable;
use App\Space\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MemberPassesController extends Controller
{
	/**
	 * @param Member $members
	 *
	 * @return
	 */
	public function index(Member $members)
	{
		return $members->passes()->with('bookable')->get();
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Member            $members
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Member $members, Request $request)
	{
		$bookable = Bookable::find($request->get('bookable')['id']);
		if(!$bookable)
			return response()->json(['error' => 'Bookable does not exist'], 404);

		$pass = $members->passes()->create([
			'date_to' =>  Carbon::parse($request->get('date_to')),
			'hours' => $request->get('hours'),
			'bookable_id' => $bookable->id
		]);
		return $pass;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Member $members
	 * @param  int   $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Member $members ,$id)
	{
		return $members->passes()->where('id', $id)->delete($id);
	}
}
