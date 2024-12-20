<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTicketRequest;
use App\Mail\TicketAlert;
use App\Models\State;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketStatusChanged;

class TicketAssignmentController extends Controller
{
    public function index(Request $request)
    {
        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

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
        //filtrar por estado ticket
        $query->whereNotIn('state_id', [4, 7, 8]); // 4= solucionado , 7 = Finalizado, 8 = Cancelado
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
        //$states = State::all();
        $states = State::whereNotIn('id', [4, 7, 8])->get();

        // Obtener todos los usuarios para el filtro de asignación
        $users = User::where('assignable', true)->get();



        return view('support.index', compact('tickets', 'states', 'users'));
    }


    public function center(Request $request)
    {

        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        // Construir la consulta base
        $query = Ticket::query();

        //filtrar por estado ticket
        $query->whereNotIn('state_id', [4, 7, 8]); // 4= solucionado , 7 = Finalizado, 8 = Cancelado

        // Filtrar por tickets no asignados
        $query->doesntHave('assignedUsers');

        // Ordenar los resultados
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Paginación
        $tickets = $query->paginate(10)->appends($request->except('page'));

        return view('support.center', compact('tickets'));
    }





    //TODO: bandeja soporte
    public function assigned(Request $request): View
    {
        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        // Obtener el usuario autenticado
        $user = auth::user();

        $priorities = [
            'low' => 'Baja',
            'medium' => 'Media',
            'high' => 'Alta',
            'critical' => 'Crítico'
        ];

        // Obtener los tickets asignados al usuario
        $tickets = $user->assignedTickets()->wherePivot('is_active', true)
            ->whereNotIn('state_id', [4, 7, 8])
            ->orderBy('priority', 'desc')
            ->paginate();

        $states = State::whereNotIn('id', [4, 7, 8]) // Asegúrate de que 'id' es la columna correcta.
            ->get();

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

    public function showCenter($ticketId)
    {
        // Cargar el ticket junto con los usuarios asignados
        $ticket = Ticket::with('assignedUsers')->findOrFail($ticketId);
    
        // Verificar si el ticket ya está asignado a cualquier usuario
      /*   if ($ticket->assignedUsers()->exists()) {
            // Si ya está asignado, retornar error 410 (Gone)
            abort(404, 'Este ticket no está disponible.');
        } */
    
        // Obtener la última asignación si existiera, en este caso no debería haber ninguna
        $assignments = $ticket->assignedUsers()->orderBy('ticket_assigns.created_at', 'desc')->first();
        
        // Obtener los usuarios asignables
        $users = User::where('assignable', true)->get();
    
        // Retornar la vista con los datos necesarios
        return view('support.showcenter', compact('ticket', 'assignments', 'users'));
    }


    public function store(AssignTicketRequest $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|integer|exists:users,id',
            'details' => 'required|max:255',
            'priority' => 'nullable|string|in:low,medium,high,critical'
        ]);

        $userId = $validated['user_id'];
        $details = $validated['details'];
        $priority = $validated['priority'];

        $currentAssignee = $ticket->assignedUsers()->where('is_active', true)->first();

        if ($currentAssignee && $currentAssignee->id == $userId) {
            // Si el usuario seleccionado es el mismo que el actual, redirige con un mensaje de error
            return redirect()->route('support.show', $ticket)
                ->with('message', 'El ticket ya está asignado a este usuario.');
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

        // Actualizar el estado del ticket
        $ticketData = [
            'state_id' => 2,
            'priority' => $priority,
            'sla_due_time' => $this->calculateDueTime($priority), // Asignar la fecha límite del SLA
        ];

        // Solo establecer 'sla_assigned_start_time' si aún no tiene valor
        if (is_null($ticket->sla_assigned_start_time)) {
            $ticketData['sla_assigned_start_time'] = Carbon::now();
        }

        // Actualizar los datos del ticket
        $ticket->update($ticketData);
        $user = User::find($userId);


        HistoryController::logAction($ticket, true, Auth::id(), "El ticket fue asignado al usuario  $user->first_name $user->last_name (ID: $user->id) por el usuario " . Auth::user()->first_name . " " . Auth::user()->last_name . " (ID: " . Auth::id() . ").");

        // Cargar relaciones
        $ticket->load('state', 'user', 'assignedUsers', 'element');

        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.my'));
        try {
            // Enviar correo notificando el cambio de estado
            Mail::to($user->email)->send(new TicketAlert($ticket));
            Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));
        } catch (\Exception $e) {
            return redirect($lastView)->with('message', 'Ticket  fue asignado/reasignado correctamente, pero hubo un problema al enviar la notificación por correo.');
        }

        // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket asignado/reasignado correctamente.');

        // return redirect()->route('support.show', $ticket)->with('success', 'Ticket asignado/reasignado correctamente.');
    }

    // Método para calcular la fecha límite del SLA
    protected function calculateDueTime($priority)
    {
        $now = Carbon::now();
        switch ($priority) {
            case 'critical':
                return $now->addHours(4);
            case 'high':
                return $now->addHours(8);
            case 'medium':
                return $now->addDays(1);
            case 'low':
                return $now->addDays(2);
            default:
                return null; // O manejar el caso de prioridad no definida
        }
    }
}
