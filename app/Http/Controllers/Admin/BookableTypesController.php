<?php

namespace App\Http\Controllers\Admin;

use App\Bookables\BookableType;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Bookables\CreateBookableTypeForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;


class BookableTypesController extends AdminController
{
	public function __construct()
	{
		$this->current['model'] = 'Tipos de sala';
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
		$bookabletypes = BookableType::all();

		return view('admin.bookabletypes.index', [
			'current'       => $this->current,
			'bookabletypes' => $bookabletypes
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
		$bookabletype = new BookableType;

		return view('admin.bookabletypes.create', [
			'current'      => $this->current,
			'bookabletype' => $bookabletype
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 *
	 * @param CreateBookableTypeForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateBookableTypeForm $request)
	{
		$bookabletype = BookableType::create($request->all());

		if ($request->has('images')) {
			$bookabletype->images()->sync($request->get('images'));
		}


		return redirect()->route('admin.bookabletypes.index')->with(
			'success', 'El tipo de sala se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param BookableType $bookabletypes
	 *
	 * @return \Illuminate\Http\Response
	 * @internal param int $id
	 *
	 */
	public function show(BookableType $bookabletypes)
	{
		dd($bookabletypes);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param BookableType $bookabletypes
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function edit(BookableType $bookabletypes)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.bookabletypes.edit', [
			'current'      => $this->current,
			'bookabletype' => $bookabletypes
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param BookableType              $bookabletypes
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function update(Request $request, BookableType $bookabletypes)
	{
		if(!$request->has('active')) {
			$request->offsetSet('active', false);
		}

		if ($request->has('images')) {
			$bookabletypes->images()->sync($request->get('images'));
		}

		$bookabletypes->update(
			$request->all()
		);


		return redirect()->route('admin.bookabletypes.index')->with(
			'success', 'El tipo de sala se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param BookableType $bookabletypes
	 *
	 * @param Request      $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(BookableType $bookabletypes, Request $request)
	{
		$bookabletypes->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'El tipo de sala se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.bookabletypes.index')
		                 ->withStatus('success')
		                 ->withMessage('El tipo de sala se ha borrado correctamente');
	}
}
