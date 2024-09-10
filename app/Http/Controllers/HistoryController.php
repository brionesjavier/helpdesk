<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\State;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public static function logAction($ticketId, $userId, $action)
    {
        History::create([
            'ticket_id' => $ticketId,
            'user_id' => $userId,
            'action' => $action,
        ]);
    }

    public function index($ticketId)
    {
        $histories = History::where('ticket_id', $ticketId)
        ->get();

        return view('histories.index', compact('histories'));
    }

/*     public function myHistories(Request $request){
        $tickets = Ticket::where('created_by', Auth::id())
        ->orderBy('updated_at', 'DESC')
        ->paginate();
        //->get();

        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        return view('histories.my', compact('tickets'));
    } */
    public function myHistories(Request $request)
{
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

