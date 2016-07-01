<?php

namespace App\Http\Controllers\Admin;

use App\Bookables\Bookable;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Bookables\CreateBookableForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class BookablesController extends AdminController
{
	/**
	 * BookablesController constructor.
	 */
	public function __construct()
	{
		$this->current['model'] = 'Reservas';
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
		$bookables = Bookable::all();

		return view('admin.bookables.index', [
			'current'   => $this->current,
			'bookables' => $bookables
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
		$bookable = new Bookable;

		return view('admin.bookables.create', [
			'current'  => $this->current,
			'bookable' => $bookable
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 *
	 * @param CreateBookableForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateBookableForm $request)
	{
		$bookable = Bookable::create($request->all());

			if ($request->has('images')) {
			$bookable->images()->sync($request->get('images'));
		}

		return redirect()->route('admin.bookables.index')->with(
			'success', 'La entidad se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Bookable $bookables
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function show(Bookable $bookables)
	{
		dd($bookables);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 *
	 * @param Bookable $bookables
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Bookable $bookables)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.bookables.edit', [
			'current'  => $this->current,
			'bookable' => $bookables
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param CreateBookableForm $request
	 * @param Bookable           $bookables
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(CreateBookableForm $request, Bookable $bookables)
	{
		$bookables->update(
			$request->all()
		);

		if($request->has('images'))
		{
			$bookables->images()->sync($request->get('images'));
		}


		return redirect()->route('admin.bookables.index')->with(
			'success', 'La entidad se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Bookable $bookables, Request $request)
	{
		$bookables->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'La entidad se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.bookabletypes.index')
		                 ->withStatus('success')
		                 ->withMessage('La entidad se ha borrado correctamente');
	}
}
