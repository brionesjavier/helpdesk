<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTicketRequest;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class TicketAssignmentController extends Controller
{
    public function index(Request $request){
        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());
        //$tickets = Ticket::where('state_id', 1)->orwhere('state_id',5)->get();
        $tickets = Ticket::all();
        return view('support.index', compact('tickets'));
    }

    //TODO: bandeja soporte
    public function assigned(): View
    {
        // Obtener el usuario autenticado
        $user = auth::user();

     

        // Obtener los tickets asignados al usuario
        $tickets = $user->assignedTickets()->wherePivot('is_active', true)->get();

        // Retornar la vista con los tickets asignados
        return view('support.assigned', compact('tickets'));
    }


    public function show($ticketId)
    {
        $ticket = Ticket::with('assignedUsers')->findOrFail($ticketId);
        $assignments = $ticket->assignedUsers()->orderBy('ticket_assigns.created_at', 'desc')->first();
        $users= User::all();
        return view('support.show', compact('ticket', 'assignments','users'));
    }
    

    public function store(AssignTicketRequest $request, Ticket $ticket)
    {
        $userId = $request->validated()['user_id'];
        $details = $request->validated()['details'];

        /// Actualizar el estado del ticket
        $ticket->update([ 'state_id' => 2 ]);
       

        $currentAssignee = $ticket->assignedUsers()->where('is_active',true)->first();

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
