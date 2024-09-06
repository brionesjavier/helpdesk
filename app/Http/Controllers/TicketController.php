<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{
    // mostrar tickets
    //TODO:bandeja administracion
    public function index(Request $request)
    {
        $tickets = Ticket::get();

        // Guardar la URL actual en la sesión
        $uri=$request->session()->put('last_view', url()->current());

        return view('tickets.index',compact('tickets') );
    }

    public function dashboard()
{

    $userId=auth::id();
    $ticketsPendientes = Ticket::where('created_by',$userId)
                                ->where('is_active',true)
                                ->where(function ($query) {
                                    $query->where('state_id', 1);
                                })
                                ->count();

                                
    $ticketsEnProceso = Ticket::where('created_by',$userId)
                                ->where('is_active',true)
                                ->where(function ($query) {
                                    $query->where('state_id', 2)
                                          ->orWhere('state_id', 3)
                                          ->orWhere('state_id', 6);
                                })
                                ->count();

    $ticketsSolucionados = Ticket::where('created_by',$userId)
                                ->where('is_active',true)
                                ->where(function ($query) {
                                    $query->where('state_id', 4)
                                        ->orWhere('state_id', 7);
                                })
                                ->count();

    $ticketsCancelados = Ticket::where('created_by',$userId)
                                ->where('is_active',true)
                                ->where(function($query){
                                    $query->where('state_id', 8)
                                        ->orWhere('state_id', 5);
                                })
                                ->count();

    return view('dashboard', compact('ticketsPendientes', 'ticketsEnProceso', 'ticketsSolucionados', 'ticketsCancelados'));
}

    //TODO:bandeja usuario
    public function myTickets(Request $request):View
    {

        $userId=auth::id();
        $tickets = Ticket::where('created_by',$userId)
                        ->where('is_active',true)
                        ->paginate();
                        //->get();
   

        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());


        return view('tickets.my',compact('tickets') );
    }

    //mostrar datos
    //TODO:ver ticket por id todo los usuario
    public function show(Request $request,Ticket $ticket)
    {   
        $comments = Comment::where('ticket_id', $ticket->id)->orderBy('created_at','desc')->get();
        return view('tickets.show', compact('comments','ticket'));
    }


    //crear una vista de formulario
    //TODO:crear ticket  todo los usuario
    public function create()
    {   
        $categories= Category::get();
        return view('tickets.create',['categories'=>$categories]);
    }

    //guardar datos
    //TODO:guardar ticket  todo los usuario
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




        return redirect()->route('tickets.my')->with('message', 'Ticket creado con exito');
    }

    //editar datos
    public function edit(Ticket $ticket)
    {
        $categories= Category::get();
    
        return view('tickets.edit', compact('ticket','categories'));
    }

    //actualizar datos
    //TODO: actualizar ticket todo los usuarios
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

         // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));

         // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket actualizado con exito');                              

        //return redirect()->route('tickets.my')->with('message', 'Ticket actualizado con exito');
    }

    //eliminar datos
    public function destroy(Request $request,Ticket $ticket)
    {
        $ticket->update(['is_active'=>false]);

        //registro historial
        $user =Auth::user()->name;
        $stateName = $ticket->state->name;
        $message = "Ticket Eliminado: por  $user, Estado: $stateName ";
        HistoryController::logAction($ticket->id, auth::id(), $message);

        //$ticket->delete();

         // Obtener la URL de la última vista desde la sesión
         $lastView = $request->session()->get('last_view', route('tickets.index'));

         // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket eliminado con exito');

        //return redirect()->route('tickets.my')->with('message', 'Ticket eliminado con exito');
    }

/** para vista de solucion */
    public function showSolveForm(Ticket $ticket)
    {
        return view('tickets.solve', compact('ticket'));
    }

    public function solve(Request $request, Ticket $ticket)
    {
    
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = $validated['content'];

        $ticket->comment()->create([
            'content' => $comment,
            'user_id' => auth::id(),
            'ticket_id' => $ticket->id,
        ]);
    

        $ticket->state_id = 4 ;/* 4 ID del estado "Solucionado" */
        $ticket->solved_at = now();
        $ticket->save();

         // Obtener la URL de la última vista desde la sesión
         $lastView = $request->session()->get('last_view', route('tickets.index'));

         // Redirigir a la última vista
         return redirect($lastView)->with('message', 'Comentario agregado y ticket marcado como solucionado.');

}

// Mostrar el formulario para derivar el ticket
public function showDeriveForm(Ticket $ticket)
{
    $users= User::where('assignable',true)->get();
    return view('tickets.derive', compact('ticket','users'));
}

// Procesar la derivación del ticket
public function derive(Request $request, Ticket $ticket)
{
    $validated = $request->validate(['content' => 'required|string',]);
    $userId=$request->user_id;

    $comment = $validated['content'];

    $ticket->comment()->create([
        'content' => $comment,
        'user_id' => auth::id(),
        'ticket_id' => $ticket->id,
    ]);
    
    // Actualizar el estado del ticket
    $ticket->state_id = 6; 
    
    $ticket->save();

    // Desactivar asignaciones anteriores
    TicketAssignment::where('ticket_id', $ticket->id)
    ->update(['is_active' => false]);

    $details = "Usuario derivado por " . Auth::user()->name . " (ID: " . Auth::id() . ")";
    // Crear una nueva asignación
    TicketAssignment::create([
        'ticket_id' => $ticket->id,
        'user_id' => $userId,
        'details' => $details,
        'is_active' => true,
    ]);

    // Obtener la URL de la última vista desde la sesión
    $lastView = $request->session()->get('last_view', route('tickets.index'));

    // Redirigir a la última vista
    return redirect($lastView)->with('message', 'Ticket derivado con comentario agregado.');
}




// Mostrar el formulario para reabrir el ticket
public function showReopenForm(Ticket $ticket)
{
    return view('tickets.reopen', compact('ticket'));
}

// Procesar la reapertura del ticket
public function reopen(Request $request, Ticket $ticket)
{
    $validated = $request->validate([ 'content' => 'required|string',]);
    $comment = $validated['content'];
    $ticket->comment()->create([
        'content' => $comment,
        'user_id' => auth::id(),
        'ticket_id' => $ticket->id,]);

    // Actualizar el estado del ticket
    $ticket->state_id = 5; /* 5 ID del estado "Reabierto" */
    $ticket->save();

    // Obtener la URL de la última vista desde la sesión
    $lastView = $request->session()->get('last_view', route('tickets.index'));

    // Redirigir a la última vista
    return redirect($lastView)->with('message', 'Ticket reabierto con comentario agregado.');
}

// Procesar el cierre del ticket
public function close( Request $request,Ticket $ticket)
{
    $comment = "requerimiento cerrado";

    $ticket->comment()->create([
        'content' => $comment,
        'user_id' => auth::id(),
        'ticket_id' => $ticket->id,
    ]);

    // Actualizar el estado del ticket
    $ticket->state_id = 7; // ID del estado "Cerrado" (ajustar según tu implementación)
    $ticket->updated_at = now();
    $ticket->save();

    // Obtener la URL de la última vista desde la sesión
    $lastView = $request->session()->get('last_view', route('tickets.index'));

    // Redirigir a la última vista
    return redirect($lastView)->with('message', 'Ticket cerrado con comentario agregado.');
}

// Mostrar el formulario para cancelar el ticket
public function showCancelForm(Ticket $ticket)
{
    return view('tickets.cancel', compact('ticket'));
}

// Procesar la cancelación del ticket
public function cancel(Request $request, Ticket $ticket)
{
    $validated = $request->validate([
        'content' => 'required|string',
    ]);

    $comment = $validated['content'];

    $ticket->comment()->create([
        'content' => $comment,
        'user_id' => auth::id(),
        'ticket_id' => $ticket->id,
    ]);

    // Actualizar el estado del ticket
    $ticket->state_id = 8; /* 8 ID del estado "Cancelado" */
    $ticket->updated_at = now();
    $ticket->save();

    // Obtener la URL de la última vista desde la sesión
    $lastView = $request->session()->get('last_view', route('tickets.index'));

    // Redirigir a la última vista
    return redirect($lastView)->with('message', 'Ticket cancelado con comentario agregado.');
}


}
