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
        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'state_ticket' => $ticket->state->name,
            'content' => $request->input('content'),

        ]);

        
        HistoryController::logAction($ticket, false, Auth::id(), "Comentario agregado: $request->content");
        // Cargar relaciones
        $ticket->load('state', 'user', 'assignedUsers', 'element');
        $user = Auth::user();
        // Enviar correo notificando el cambio de estado
        Mail::to($ticket->user->email)->send(new TicketNotification($ticket, $request->input('content' ,$user )));
        return redirect()->route('tickets.show',$ticket)->with('message', 'Comentario añadido con éxito.');
    }

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
