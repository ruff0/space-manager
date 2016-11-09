<?php

namespace App\Http\Controllers\Api\Tickets;

use App\Events\Commands\ReserveTicketForUser;
use App\Events\EloquentTicket;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TicketReservationsController extends Controller
{
    public function store(EloquentTicket $ticket, Request $request)
    {
        ReserveTicketForUser::fromRequest($request);
    }
}
