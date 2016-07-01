<?php

namespace App\Http\Controllers\Api\Space;

use App\Space\Member;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MembersController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return Member::whereActive(true)->get();
	}
}
