<?php

namespace App\Http\Controllers\Admin;

use App\Bookables\BookableSize;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Bookables\CreateBookableSizeForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class BookableSizesController extends AdminController
{
	public function __construct()
	{
		$this->current['model'] = 'Tamaños de sala';
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
		$bookablesizes = BookableSize::all();

		return view('admin.bookablesizes.index', [
			'current'       => $this->current,
			'bookablesizes' => $bookablesizes
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
		$bookablesize = new BookableSize;

		return view('admin.bookablesizes.create', [
			'current'      => $this->current,
			'bookablesize' => $bookablesize
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 *
	 * @param CreateBookableSizeForm $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateBookableSizeForm $request)
	{
		$bookablesize = BookableSize::create($request->all());

		return redirect()->route('admin.bookablesizes.index')->with(
			'success', 'El tamaño de sala se ha guardado correctamente'
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param BookableSize $bookablesizes
	 *
	 * @return \Illuminate\Http\Response
	 *
	 */
	public function show(BookableSize $bookablesizes)
	{
		dd($bookablesizes);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 *
	 * @param BookableSize $bookablesizes
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit(BookableSize $bookablesizes)
	{
		$this->current['action'] = 'Actualizar';

		return view('admin.bookablesizes.edit', [
			'current'      => $this->current,
			'bookablesize' => $bookablesizes
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request

	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, BookableSize $bookablesizes)
	{
		$bookablesize = $bookablesizes->update(
			$request->all()
		);

		return redirect()->route('admin.bookablesizes.index')->with(
			'success', 'El tamaño de sala se ha guardado correctamente'
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(BookableSize $bookablesizes, Request $request)
	{
		$bookablesizes->delete();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
				'status'  => 'success',
				'message' => 'El tamaño de sala se ha borrado correctamente'
			], Response::HTTP_OK
			);
		}

		return redirect()->route('admin.bookabletypes.index')
		                 ->withStatus('success')
		                 ->withMessage('El tamaño de sala se ha borrado correctamente');
	}
}
