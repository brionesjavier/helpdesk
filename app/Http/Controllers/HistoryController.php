<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

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
        $histories = History::where('ticket_id', $ticketId)->get();
        return view('histories.index', compact('histories'));
    }
}

