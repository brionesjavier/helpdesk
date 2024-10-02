<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketNotification;



class CommentController extends Controller
{
    use AuthorizesRequests;  
    public function store(Request $request, Ticket $ticket)
    {
        $this->authorize('manageOrCreateByUser', $ticket);
        
        $request->validate([
            'content' => 'required',
        ]);
    
        // Crear el comentario
        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'state_ticket' => $ticket->state->name,
            'content' => $request->input('content'),
        ]);
    
        // Registrar la acción en el historial
        HistoryController::logAction($ticket, false, Auth::id(), "Comentario agregado: " . $request->input('content'));
    
        // Cargar relaciones solo si es necesario
        $ticket->load('state', 'user', 'assignedUsers', 'element');
    
        // Obtener el usuario autenticado
        $user = Auth::user();
    
        // Enviar el correo con notificación
        try {
            // Enviar correo al creador del ticket
            Mail::to($ticket->user->email)->send(new TicketNotification($ticket, $request->input('content'), $user));
            
            // Obtener el usuario asignado activo
            $userAssign = $ticket->assignedUsers()->where('is_active', true)->first();
        
            // Verificar que el ticket fue creado por el usuario y que hay un usuario asignado
            if ($userAssign) {
                // Enviar correo al usuario asignado
                Mail::to($userAssign->email)->send(new TicketNotification($ticket, $request->input('content'), $user));
            }
        
        } catch (\Exception $e) {
            // Manejar el error al enviar el correo
            return redirect()->route('tickets.show', $ticket)->with('message', 'Error al enviar la notificación por correo.');
        }
    
        // Redirigir con un mensaje de éxito
        return redirect()->route('tickets.show', $ticket)->with('message', 'Comentario añadido con éxito.');
    }
    //'El ticket fue cancelado, pero hubo un problema al enviar la notificación por correo.'

    public function index($ticketId)
    {
        
        // Recupera el ticket para asegurarte de que existe
        $ticket = Ticket::findOrFail($ticketId);

        $this->authorize('manageOrCreateByUser', $ticket);
        $comments = Comment::where('ticket_id', $ticketId)->orderBy('created_at', 'desc')//asc or desc
        ->get();
            
        
        return view('comments.index', compact('ticket','comments'));
    }
}
