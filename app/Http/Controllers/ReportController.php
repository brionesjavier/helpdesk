<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function ticketsReport()
    {
        $tickets = Ticket::with(['assignedUsers', 'state'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reports.tickets', compact('tickets'));
    }
}
