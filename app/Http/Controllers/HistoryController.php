<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\State;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public static function logAction(Ticket $ticket, $change = false, $userId, $action)
    {
        // Obtener el último cambio de estado del ticket y calcular el tiempo de SLA en minutos
        $lastHistory = History::selectRaw('id, EXTRACT(EPOCH FROM (NOW() - created_at))  as sla_time')
            ->where('ticket_id', $ticket->id)
            ->where('change_state', true)
            ->orderBy('created_at', 'desc')
            ->first();
    
        // Si existe un historial previo, obtenemos el tiempo de SLA calculado, si no, es 0
        $slaTime = $lastHistory ? $lastHistory->sla_time : 0;
    
        // Crear un nuevo registro en el historial con el SLA calculado
        History::create([
            'ticket_id' => $ticket->id,
            'state_id' => $ticket->state_id,
            'change_state' => $change,
            'user_id' => $userId,
            'action' => $action,
            'sla_time' => $slaTime,
        ]);
    }
    
    

    public function index(Request $request, $ticketId)
    {
        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());
    
        // Modificar la consulta para convertir sla_time (segundos) a un intervalo en formato legible
        $histories = History::selectRaw("*,make_interval(secs => sla_time) AS sla_time_interval")
            ->where('ticket_id', $ticketId)
            ->get();
    
        return view('histories.index', compact('histories'));
    }

    public function myHistories(Request $request)
    {
        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        // Recuperar los parámetros de búsqueda
        $search = $request->input('search');
        $stateId = $request->input('state');
        $sortBy = $request->input('sort_by', 'updated_at');
        $sortDirection = $request->input('sort_direction', 'DESC');

        // Construir la consulta base
        $query = Ticket::where('created_by', Auth::id());

        // Filtrar por búsqueda (título o folio)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Filtrar por estado
        if ($stateId && $stateId !== 'all') {
            $query->where('state_id', $stateId);
        }

        // Ordenar los resultados
        $query->orderBy($sortBy, $sortDirection);

        // Paginación
        $tickets = $query->paginate(10);

        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        // Recuperar todos los estados para el formulario
        $states = State::all(); // Asegúrate de importar el modelo State si no lo has hecho

        return view('histories.my', compact('tickets', 'states'));
    }
}
