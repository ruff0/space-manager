<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Facades\Gate;

class AdminController extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $current = [
      'module' => '',
      'model' => '',
      'action' => '',
    ];

    /**
     * AdminController constructor.
     */
    public function __construct()
    {

	  	if(Gate::denies('access::backend'))
		  {
			  abort(403);
		  }
    }
}
