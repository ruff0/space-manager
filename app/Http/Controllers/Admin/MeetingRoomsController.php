<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Resources\MeetingRoomForm;
use App\Resources\Models\MeetingRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class MeetingRoomsController extends AdminController
{
	public function __construct()
	{
		$this->current['model'] = 'Salas de reuniones';
		view()->share('current', $this->current);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->current['action'] = 'Listado';
		$meetingrooms = MeetingRoom::all();

		return view('admin.meetingrooms.index', [
			'current' => $this->current,
			'meetingrooms'   => $meetingrooms
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$this->current['action'] = 'Crear';
		$meetingroom = new MeetingRoom;

		return view('admin.meetingrooms.create', [
			'current' => $this->current,
			'meetingroom'    => $meetingroom
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param MeetingRoomForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(MeetingRoomForm $request)
	{
		$meetingroom = MeetingRoom::create(
			$request->all()
		);

		return redirect()->route('admin.meetingrooms.index')->with(
			'success', 'La sala de reuniones se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param MeetingRoom $meetingRooms
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(MeetingRoom $meetingrooms)
	{
		dd($meetingrooms);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param MeetingRoom $meetingrooms
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function edit(MeetingRoom $meetingrooms)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.meetingrooms.edit', [
			'current' => $this->current,
			'meetingroom'    => $meetingrooms
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param MeetingRoomForm $request
	 * @param MeetingRoom     $meetingrooms
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(MeetingRoomForm $request, MeetingRoom $meetingrooms)
	{

		$meetingroom = $meetingrooms->update(
			$request->all()
		);

		return redirect()->route('admin.meetingrooms.index')->with(
			'success', 'La sala de reuniones se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 *
	 * @param MeetingRoom $meetingrooms
	 * @param Request     $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(MeetingRoom $meetingrooms, Request $request)
	{
		$meetingrooms->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'La sala de reuniones se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.meetingrooms.index')
		                 ->withStatus('success')
		                 ->withMessage('La sala de reuniones se ha borrado correctamente');
	}
}
