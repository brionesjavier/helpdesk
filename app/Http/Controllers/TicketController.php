<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
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

    public function myTickets():View
    {
        $userId=auth::id();
        $tickets = Ticket::where('created_by',$userId)
                        ->where('is_active',true)
                        ->get();
        return view('tickets.my',compact('tickets') );
    }

    //mostrar datos
    public function show(Ticket $ticket)
    {

        $comments = Comment::where('ticket_id', $ticket->id)->get();
        return view('tickets.show', compact('comments','ticket'));
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
        $ticket=Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'element_id' => $request->element_id,
            'state_id' => $estado,
            'created_by'=>$user_id
            ]);

        //registro historial
        $title = $ticket->title;
        $stateName = $ticket->state->name;
        $description = $ticket->description;
        $category =$ticket->element->category->name;
        $element =$ticket->element->name;
        $message = "Ticket creado: 
                                título: $title , 
                                Estado: $stateName , 
                                Categoria: $category/$element, 
                                descripción: $description";
        HistoryController::logAction($ticket->id, auth::id(), $message);

        return redirect()->route('tickets.my')
                        ->with('message', 'Ticket creado con exito');
    }

    //editar datos
    public function edit(Ticket $ticket)
    {
        $categories= Category::get();
    
        return view('tickets.edit', compact('ticket','categories'));
    }
    //actualizar datos
    public function update(Request $request, Ticket $ticket)
    {
        $validated=$request->validate([
                                            'title' => 'required',
                                            'description' => 'required',
                                            'element_id' => 'required',
                                            
                                        ]);
        
       $ticket->update($validated);

                                        
       //registro historial
       $title = $ticket->title;
       $stateName = $ticket->state->name;
       $description = $ticket->description;
       $category =$ticket->element->category->name;
       $element =$ticket->element->name;
       $message = "Ticket actualizado: 
                               título: $title , 
                               Estado: $stateName , 
                               Categoria: $category/$element, 
                               descripción: $description";
       HistoryController::logAction($ticket->id, auth::id(), $message);

        return redirect()->route('tickets.my')
                        ->with('message', 'Ticket actualizado con exito');
    }

    //eliminar datos
    public function destroy(Ticket $ticket)
    {
        $ticket->update(['is_active'=>false]);

        //registro historial
        $user =Auth::user()->name;
        $stateName = $ticket->state->name;
        $message = "Ticket Eliminado: por  $user, Estado: $stateName ";
        HistoryController::logAction($ticket->id, auth::id(), $message);

        //$ticket->delete();
        return redirect()->route('tickets.my')
                        ->with('message', 'Ticket eliminado con exito');
    }

}
