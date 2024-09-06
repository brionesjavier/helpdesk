<?php

namespace App\Http\Controllers;

use App\Models\History;
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

    public function myHistories(Request $request){
        $tickets = Ticket::where('created_by', Auth::id())
        ->orderBy('updated_at', 'DESC')
        ->paginate();
        //->get();

        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        return view('histories.my', compact('tickets'));
    }

}

