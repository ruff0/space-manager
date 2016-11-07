<?php

namespace App\Http\Controllers;

use App\Files\File;
use App\Files\Image;
use App\Http\Controllers\AdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Requests;
use Symfony\Component\HttpFoundation\Response;

class FilesController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$files = Image::all();

		if ($request->ajax() || $request->wantsJson()) {
			return new JsonResponse([
					'status'  => 'success',
					'files' => $files
				], Response::HTTP_OK
			);
		}
		return $files;
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
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$file = $request->file('file');
		$name = time(). "-". $request->user()->id . "-" . $file->getClientOriginalName();
		$file = $file->move('storage/temp', $name);
		
		$file = File::create([
			'name' => $file->getFilename(),
			'type' => 'image',
			'path' => $file->getPath(),
			'extension' => $file->getExtension(),
			'pathname' => $file->getPathname(),
			'size' => $file->getSize()
		]);

		return $file;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
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
	 *
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
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
