<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTicketRequest;
use App\Models\State;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketAssignmentController extends Controller
{
    public function index(Request $request)
    {
        // Obtener los parámetros de la solicitud
        $search = $request->input('search');
        $state = $request->input('state');
        $user = $request->input('user');
        $assignment = $request->input('assignment'); // Nuevo parámetro para asignación
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
    
        // Construir la consulta base
        $query = Ticket::query();
    
        // Aplicar búsqueda por título o folio
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('id', 'like', "%$search%");
            });
        }
    
        // Aplicar búsqueda por usuario
        if ($user && $user != 'all') {
            $query->whereHas('assignedUsers', function ($q) use ($user) {
                $q->where('user_id', $user)
                  ->where('is_active', true);
            });
        }
    
        // Filtrar por estado
        if ($state && $state != 'all') {
            $query->where('state_id', $state);
        }
    
        // Filtrar por asignación
        if ($assignment && $assignment == 'has_assignment') {
            $query->whereHas('assignedUsers', function ($q) {
                $q->where('is_active', true);
            });
        } elseif ($assignment && $assignment == 'no_assignment') {
            $query->doesntHave('assignedUsers');
        }
    
        // Ordenar los resultados
        $query->orderBy($sortBy, $sortDirection);
    
        // Paginación
        $tickets = $query->paginate(10)->appends($request->except('page'));
    
        // Obtener todos los estados para el filtro
        $states = State::all();
    
        // Obtener todos los usuarios para el filtro de asignación
        $users = User::where('assignable', true)->get();
    
        return view('support.index', compact('tickets', 'states', 'users'));
    }
    
    
    

    //TODO: bandeja soporte
    public function assigned(): View
    {
        // Obtener el usuario autenticado
        $user = auth::user();

        $priorities = [
            'low' => 'Baja',
            'medium' => 'Media',
            'high' => 'Alta'
        ];

        // Obtener los tickets asignados al usuario
        $tickets = $user->assignedTickets()->wherePivot('is_active', true)
            ->paginate();

        $states = State::all();
        //->get();

        // Retornar la vista con los tickets asignados
        return view('support.assigned', compact('tickets', 'priorities', 'states'));
    }


    public function show($ticketId)
    {
        $ticket = Ticket::with('assignedUsers')->findOrFail($ticketId);
        $assignments = $ticket->assignedUsers()->orderBy('ticket_assigns.created_at', 'desc')->first();
        $users = User::where('assignable', true)->get();
        return view('support.show', compact('ticket', 'assignments', 'users'));
    }


    public function store(AssignTicketRequest $request, Ticket $ticket)
    {
        $userId = $request->validated()['user_id'];
        $details = $request->validated()['details'];
        $priority = $request->validated()['priority'];


        /// Actualizar el estado del ticket
        $ticket->update([
            'state_id' => 2,
            'priority' => $priority
        ]);


        $currentAssignee = $ticket->assignedUsers()->where('is_active', true)->first();

        if ($currentAssignee && $currentAssignee->id == $userId) {
            // Si el usuario seleccionado es el mismo que el actual, redirige con un mensaje de error
            return redirect()->route('support.show', $ticket)
                ->with('error', 'El ticket ya está asignado a este usuario.');
        }

        // Desactivar asignaciones anteriores
        TicketAssignment::where('ticket_id', $ticket->id)
            ->update(['is_active' => false]);

        // Crear nueva asignación
        TicketAssignment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $userId,
            'details' => $details,
            'is_active' => true,
        ]);

        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));

        // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket asignado/reasignado correctamente.');

        // return redirect()->route('support.show', $ticket)->with('success', 'Ticket asignado/reasignado correctamente.');
    }
}
