<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'content' => 'required',
        ]);
        Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth::id(),
            'state_ticket' => $ticket->state->name,
            'content' => $request->input('content'),

        ]);
        
        if(($ticket->state_id == 2 ||$ticket->state_id == 5)&&  $ticket->assignedUsers()->where('user_id', auth::id())->exists()){
            $ticket->update(['state_id'=>3]);
            //registro historial
            $stateName = $ticket->state->name;
            $message = "Ticket actualizado:  Estado: $stateName ";
            HistoryController::logAction($ticket->id, auth::id(), $message);
        }

        HistoryController::logAction($ticket->id, auth::id(), "Agregado un comentario: $request->content");
        //return redirect()->back()->with('success', 'Comentario añadido con éxito.');
        return redirect()->route('tickets.show',$ticket)->with('message', 'Comentario añadido con éxito.');
    }

    public function index($ticketId)
    {
        // Recupera el ticket para asegurarte de que existe
        $ticket = Ticket::findOrFail($ticketId);

        $comments = Comment::where('ticket_id', $ticketId)->orderBy('created_at', 'desc')//asc or desc
        ->get();
        
        return view('comments.index', compact('ticket','comments'));
    }
}
