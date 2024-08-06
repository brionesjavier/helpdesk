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
            'content' => $request->input('content'),
        ]);

        HistoryController::logAction($ticket->id, auth::id(), "Added a comment: $request->content");
        return redirect()->back()->with('success', 'Comentario añadido con éxito.');
    }

    public function index($ticketId)
    {
        // Recupera el ticket para asegurarte de que existe
        $ticket = Ticket::findOrFail($ticketId);

        $comments = Comment::where('ticket_id', $ticketId)->get();
        
        return view('comments.index', compact('ticket','comments'));
    }
}
