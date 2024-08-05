<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // mostrar tickets
    public function index()
    {
        $tickets = Ticket::get();
        return view('tickets.index',compact('tickets') );
    }

    public function lista():View
    {
        dd($tickets = Ticket::all());
        return view('tickets.list',compact('tickets') );
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
        $categories= Category::get();
        return view('tickets.create',['categories'=>$categories]);
    }

    //guardar datos
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'element_id' => 'required',
            //'category_id' => 'required',
        ]);

        $estado = 1;//estado 1 -> creado
        $user_id = Auth::id();
        //return dd($request);
        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'element_id' => $request->element_id,
            'state_id' => $estado,
            'created_by'=>$user_id
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
