<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // mostrar tickets
    public function index()
    {
        $tickets = Ticket::get();
        return view('ticket.index',compact($tickets) );
    }

    //mostrar datos
    public function show(Ticket $ticket)
    {
        $ticket = Ticket::get();
        return view('ticket.show', compact($ticket));
    }

    //crear una vista de formulario
    public function create()
    {
        return view('ticket.create');
    }

    //guardar datos
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'element' => 'required',
            'state' => 'required',
        ]);

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'element' => $request->element,
            'state' => $request->state,
            ]);

        return redirect()->route('ticket.index')->with('success', 'Ticket creado con exito');
    }
    //editar datos
    public function edit(Ticket $ticket)
    {
    
        return view('ticket.edit', compact($ticket));
    }
    //actualizar datos
    public function update(Request $request, Ticket $ticket)
    {
        $validated=$request->validate([
                                            'title' => 'required',
                                            'description' => 'required',
                                            'element' => 'required',
                                            'state' => 'required',
                                        ]);
        
       $ticket->update($validated);
        return redirect()->route('ticket.index')->with('success', 'Ticket actualizado con exito');
    }

    //eliminar datos
    public function destroy(Ticket $ticket)
    {

        $ticket->delete();
        return redirect()->route('ticket.index')->with('success', 'Ticket eliminado con exito
                            ');
    }

}
