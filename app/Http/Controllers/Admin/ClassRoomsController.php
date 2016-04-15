<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Resources\ClassRoomForm;
use App\Resources\Models\ClassRoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class ClassRoomsController extends AdminController
{
	public function __construct()
	{
		$this->current['model'] = 'Aulas';
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
		$classrooms = ClassRoom::all();

		return view('admin.classrooms.index', [
			'current' => $this->current,
			'classrooms'   => $classrooms
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
		$classroom = new ClassRoom;

		return view('admin.classrooms.create', [
			'current' => $this->current,
			'classroom'    => $classroom
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ClassRoomForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(ClassRoomForm $request)
	{
		$classroom = ClassRoom::create(
			$request->all()
		);

		return redirect()->route('admin.classrooms.index')->with(
			'success', 'La sala de reuniones se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param ClassRoom $meetingRooms
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(ClassRoom $classrooms)
	{
		dd($classrooms);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param ClassRoom $classrooms
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function edit(ClassRoom $classrooms)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.classrooms.edit', [
			'current' => $this->current,
			'classroom'    => $classrooms
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param ClassRoomForm $request
	 * @param ClassRoom     $classrooms
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(ClassRoomForm $request, ClassRoom $classrooms)
	{

		$classroom = $classrooms->update(
			$request->all()
		);

		return redirect()->route('admin.classrooms.index')->with(
			'success', 'La sala de reuniones se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 *
	 * @param ClassRoom $classrooms
	 * @param Request     $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ClassRoom $classrooms, Request $request)
	{
		$classrooms->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'La sala de reuniones se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.classrooms.index')
		                 ->withStatus('success')
		                 ->withMessage('La sala de reuniones se ha borrado correctamente');
	}
}
