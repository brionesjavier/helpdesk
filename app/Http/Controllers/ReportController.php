<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ReportController extends Controller
{
  
    public function ticketsReport(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $priority = $request->input('priority');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date') ?: now()->toDateString(); // Fecha final predeterminada
    
        // Ajustar la fecha final para incluir hasta el final del día
        $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
    
        $tickets = Ticket::with(['assignedUsers', 'state'])
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('id', $search)
                    ->orWhereHas('assignedUsers', function($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                              ->orWhere('last_name', 'like', "%{$search}%");
                    });
            })
            ->when($status, function ($query, $status) {
                $query->whereHas('state', function ($query) use ($status) {
                    $query->where('id', $status);
                });
            })
            ->when($priority, function ($query, $priority) {
                $query->where('priority', $priority);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    
        // Mantener los parámetros de búsqueda en la paginación
        $tickets->appends([
            'search' => $search,
            'status' => $status,
            'priority' => $priority,
            'start_date' => $startDate,
            'end_date' => $endDate->toDateString(),
        ]);
    
        // Obtener todos los estados para el filtro
        $states = State::all();
    
        return view('reports.tickets', compact('tickets', 'search', 'status', 'priority', 'startDate', 'endDate', 'states'));
    }
    
}

    
    
    
    

