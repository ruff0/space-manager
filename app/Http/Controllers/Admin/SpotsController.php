<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Resources\SpotForm;
use App\Resources\Models\Spot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class SpotsController extends AdminController
{
	public function __construct()
	{
		$this->current['model'] = 'Puestos';
		view()->share('current', $this->current);
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$this->current['action'] = 'Listado';
		$spots = Spot::all();

		return view('admin.spots.index', [
			'current' => $this->current,
			'spots'   => $spots
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
		$spot = new Spot;

		return view('admin.spots.create', [
			'current' => $this->current,
			'spot'    => $spot
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param SpotForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(SpotForm $request)
	{
		$spot = Spot::create(
			$request->all()
		);

		return redirect()->route('admin.spots.index')->with(
			'success', 'La sala de reuniones se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Spot $meetingRooms
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Spot $spots)
	{
		dd($spots);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param Spot $spots
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function edit(Spot $spots)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.spots.edit', [
			'current' => $this->current,
			'spot'    => $spots
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param SpotForm $request
	 * @param Spot     $spots
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(SpotForm $request, Spot $spots)
	{

		$spot = $spots->update(
			$request->all()
		);

		return redirect()->route('admin.spots.index')->with(
			'success', 'La sala de reuniones se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 *
	 * @param Spot $spots
	 * @param Request     $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Spot $spots, Request $request)
	{
		$spots->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'La sala de reuniones se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.spots.index')
		                 ->withStatus('success')
		                 ->withMessage('La sala de reuniones se ha borrado correctamente');
	}
}
