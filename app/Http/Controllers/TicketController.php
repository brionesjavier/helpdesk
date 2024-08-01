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
        return view('tickets.index',compact('tickets') );
    }

    //mostrar datos
    public function show(Ticket $ticket)
    {
        $ticket = Ticket::get();
        return view('tickets.show', compact('ticket'));
    }

    //crear una vista de formulario
    public function create()
    {
        return view('tickets.create');
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

        return redirect()->route('tickets.index')
                        ->with('message', 'Ticket creado con exito');
    }
    //editar datos
    public function edit(Ticket $ticket)
    {
    
        return view('tickets.edit', compact('ticket'));
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
        return redirect()->route('tickets.index')
                        ->with('message', 'Ticket actualizado con exito');
    }

    //eliminar datos
    public function destroy(Ticket $ticket)
    {

        $ticket->delete();
        return redirect()->route('tickets.index')
                        ->with('message', 'Ticket eliminado con exito');
    }

}
