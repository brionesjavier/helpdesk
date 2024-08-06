<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(Request $request, $ticketId)
    {
        $request->validate([
            'content' => 'required',
        ]);

        Comment::create([
            'ticket_id' => $ticketId,
            'user_id' => auth::id(),
            'content' => $request->input('content'),
        ]);

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
