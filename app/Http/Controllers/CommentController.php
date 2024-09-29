<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



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
            'user_id' => auth::id(),
            'state_ticket' => $ticket->state->name,
            'content' => $request->input('content'),

        ]);

        
        HistoryController::logAction($ticket, false, auth::id(), "Comentario agregado: $request->content");
        //return redirect()->back()->with('success', 'Comentario añadido con éxito.');
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
