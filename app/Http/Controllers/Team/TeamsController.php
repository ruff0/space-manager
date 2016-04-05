<?php

namespace App\Http\Controllers\Team;

use App\Http\Requests\Team\UpdateTeamForm;
use App\Team\Team;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TeamsController extends Controller
{

	/**
	 * @param Team $teams
	 *
	 * @return mixed
	 */
	public function edit(Team $teams)
	{
 	  return view('teams.edit', [
	   'team' =>  $teams
    ]);
	}

	/**
	 * @param Team           $teams
	 * @param UpdateTeamForm $request
	 *
	 * @return
	 */
	public function update(Team $teams, UpdateTeamForm $request)
	{
		$teams->update($request->all());

		return redirect()->route('teams.edit', [ $teams->id ]);
	}
}
