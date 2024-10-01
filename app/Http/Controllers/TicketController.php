<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\State;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Mail\TicketStatusChanged;
use App\Mail\TicketAlert;
use Illuminate\Support\Facades\Mail;


class TicketController extends Controller
{
    use AuthorizesRequests;
    // mostrar Todos los tickets
    public function index(Request $request)
    {
        // Obtener los parámetros de la solicitud
        $search = $request->input('search');
        $state = $request->input('state');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        // Construir la consulta base
        $query = Ticket::query();

        // Aplicar búsqueda por título o folio
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%");
            });
        }

        // Filtrar por estado
        if ($state && $state != 'all') {
            $query->where('state_id', $state);
        }

        // Ordenar los resultados
        $query->orderBy($sortBy, $sortDirection);

        // Paginación
        $tickets = $query->paginate(10);

        // Obtener todos los estados para el filtro
        $states = State::all();

        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        return view('tickets.index', compact('tickets', 'states'));
    }




    //TODO:bandeja usuario

    public function myTickets(Request $request): View
    {
        $userId = Auth::id();

        // Inicializa la consulta
        $query = Ticket::where('created_by', $userId)
            ->where('is_active', true);

        // Filtro por búsqueda en título o folio
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filtro por estado
        if ($request->filled('state') && $request->state != 'all') {
            $query->where('state_id', $request->state);
        }

        // Ordenar según el criterio seleccionado
        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        // Validar los valores de ordenamiento
        if (!in_array($sortField, ['created_at', 'id', 'title', 'updated_at'])) {
            $sortField = 'created_at'; // valor por defecto
        }
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc'; // valor por defecto
        }

        $query->orderBy($sortField, $sortDirection);

        // Paginación
        $tickets = $query->paginate(10);

        // Obtener los estados
        $states = State::whereNotIn('id', [7])->get();

        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        return view('tickets.my', compact('tickets', 'states'));
    }

    //mostrar datos
    //TODO:ver ticket por id todo los usuario
    public function show(Request $request, Ticket $ticket)
    {
        $assignments = $ticket->assignedUsers()->orderBy('ticket_assigns.created_at', 'desc')->first();
        $comments = Comment::where('ticket_id', $ticket->id)->orderBy('created_at', 'desc')->get();
        return view('tickets.show', compact('comments', 'ticket', 'assignments'));
    }


    //crear una vista de formulario
    //TODO:crear ticket  todo los usuario
    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('tickets.create', ['categories' => $categories]);
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

        $estado = 1; //estado 1 -> creado
        $user_id = Auth::id();
        //return dd($request);
        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'element_id' => $request->element_id,
            'state_id' => $estado,
            'created_by' => $user_id,
            'attention_deadline' => Carbon::now()->addHours(2) // Lógica para calcular el SLA 
        ]);

        HistoryController::logAction($ticket, true, Auth::id(), "Ticket creado: '{$ticket->description}'");

        // Cargar relaciones
        $ticket->load('state', 'user', 'assignedUsers', 'element');

        // Enviar correo notificando el cambio de estado
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));

        return redirect()->route('tickets.my')->with('message', 'Ticket creado con exito');
    }

    //editar datos
    public function edit(Ticket $ticket)
    {
        $this->authorize('manageOrCreateByUser', $ticket);
        $categories = Category::where('is_active', 1)->get();

        return view('tickets.edit', compact('ticket', 'categories'));
    }

    //actualizar datos
    //TODO: actualizar ticket todo los usuarios
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('manageOrCreateByUser', $ticket);
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'element_id' => 'required',

        ]);

        $ticket->update($validated);


        HistoryController::logAction($ticket, false, Auth::id(), 'El ticket fue actualizado por el usuario con ID ' . Auth::id() . ' sin cambiar su estado');
        $ticket->load('state', 'user', 'assignedUsers', 'element');

        // Enviar correo notificando el cambio de estado
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));


        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));

        // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket actualizado con exito');

        //return redirect()->route('tickets.my')->with('message', 'Ticket actualizado con exito');
    }

    //eliminar datos
    public function destroy(Request $request, Ticket $ticket)
    {
        $this->authorize('createByUser', $ticket);
        $ticket->update(['is_active' => false]);

        $ticket->load('state', 'user', 'assignedUsers', 'element');

        $currentAssignee = $ticket->assignedUsers()->where('is_active', true)->first();
        if ($currentAssignee) {
            $user = User::find($currentAssignee->user_id);
            Mail::to($user->email)->send(new TicketAlert($ticket));
        }

        // Enviar correo notificando el cambio de estado
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));

        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));

        // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket eliminado con exito');
    }
    /** para vista de comenzar proceso */
    public function showProcessForm(Ticket $ticket): View
    {
        $this->authorize('manage', $ticket);
        return view('tickets.process', compact('ticket'));
    }

    public function process(Request $request, Ticket $ticket)
    {

        $this->authorize('manage', $ticket);
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = $validated['content'];
        // Actualizar el estado del ticket
        $ticket->update(['state_id' => 3,]); /* 3 ID del estado "En proceso" */
        $ticket->comment()->create([
            'content' => $comment,
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'state_ticket' => $ticket->state->name,
        ]);



        // registro historial
        HistoryController::logAction($ticket, true, Auth::id(), "El estado del ticket cambió a 'En Progreso' por el usuario con ID " . Auth::id());
        // Cargar relaciones
        $ticket->load('state', 'user', 'assignedUsers', 'element');

        // Enviar correo notificando el cambio de estado
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));

        return redirect()->route('tickets.show', compact('ticket'))->with('message', 'ticket  en proceso.');
    }


    /** para vista de solucion */
    public function showSolveForm(Ticket $ticket): View
    {
        $this->authorize('manage', $ticket);
        $categories = Category::where('is_active', 1)->get();
        return view('tickets.solve', compact('ticket', 'categories'));
    }

    public function solve(Request $request, Ticket $ticket)
    {
        $this->authorize('manage', $ticket);
        $validated = $request->validate([
            'content' => 'required|string',
            'element_id' => 'required'
        ]);

        $elementId = $validated['element_id'];

        $comment = $validated['content'];

        $ticket->comment()->create([
            'content' => $comment,
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'state_ticket' => 'Solucionado',
        ]);

        // Actualizar el estado del ticket
        $ticket->update(['state_id' => 4, 'element_id' => $elementId, 'solved_at' => Carbon::now()]); /* 4 ID del estado "Solucionado" */


        HistoryController::logAction($ticket, true, Auth::id(), "El estado del ticket cambió a 'Solucionado' por el usuario con ID " . Auth::id());

        // Cargar relaciones
        $ticket->load('state', 'user', 'assignedUsers', 'element');

        // Enviar correo notificando el cambio de estado
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));
        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));

        // Redirigir a la última vista
        return redirect($lastView)->with('message', ' ticket solucionado.');
    }

    // Mostrar el formulario para reabrir el ticket
    public function showReopenForm(Ticket $ticket)
    {
        $this->authorize('CreateByUser', $ticket);
        return view('tickets.reopen', compact('ticket'));
    }

    // Procesar la reapertura del ticket
    public function reopen(Request $request, Ticket $ticket)
    {

        $this->authorize('CreateByUser', $ticket);
        $validated = $request->validate(['content' => 'required|string',]);
        $comment = $validated['content'];


        $ticket->comment()->create([
            'content' => $comment,
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'state_ticket' => 'Objetado',
        ]);

        $ticket->update([
            'state_id' => 5, /* 5 ID del estado "Reabierto" */
            'solved_at' => null, // Eliminar la fecha de solución al objetar
        ]);

        HistoryController::logAction($ticket, true, Auth::id(), "El ticket fue reabierto por el usuario con ID " . Auth::id());
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));

        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));

        // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket reabierto.');
    }

    // Mostrar el formulario para derivar el ticket
    public function showDeriveForm(Ticket $ticket): View
    {
        $this->authorize('manage', $ticket);
        $users = User::where('assignable', true)->get();
        return view('tickets.derive', compact('ticket', 'users'));
    }

    // Procesar la derivación del ticket
    public function derive(Request $request, Ticket $ticket)
    {
        $this->authorize('manage', $ticket);
        // Validar la solicitud
        $validated = $request->validate([
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id', // Validar el user_id
        ]);

        $userId = $validated['user_id']; // Obtiene el user_id de los datos validados
        $comment = $validated['content'];

        // Obtener el usuario asignado
        $userAssign = $ticket->assignedUsers()->where('is_active', true)->first();

        // Verificar si el ticket ya está asignado al mismo usuario
        if ($userAssign && $userAssign->id == $userId) {
            return redirect()->route('tickets.derive', compact('ticket'))
                ->with('message', 'El ticket ya está asignado a este usuario.')
                ->withInput(); // Mantener los datos del formulario
        }

        // Crear el comentario
        $ticket->comment()->create([
            'content' => $comment,
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'state_ticket' => 'Derivado',
        ]);

        // Actualizar el estado del ticket
        $ticket->update(['state_id' => 6]); // ID del estado "derivado"

        // Desactivar asignaciones anteriores
        TicketAssignment::where('ticket_id', $ticket->id)->update(['is_active' => false]);

        // Crear una nueva asignación
        TicketAssignment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $userId,
            'details' => "Usuario derivado por " . Auth::user()->name . " (ID: " . Auth::id() . ")",
            'is_active' => true,
        ]);

        // Registrar la acción en el historial
        HistoryController::logAction($ticket, true, Auth::id(), "El ticket fue derivado al usuario con ID $userId por el usuario con ID " . Auth::id());
        // Cargar relaciones
        $ticket->load('state', 'user', 'assignedUsers', 'element');

        
        // Enviar correo notificando el cambio de estado
        Mail::to($$userAssign->email)->send(new TicketAlert($ticket));
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));
       

        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));

        // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket derivado.');
    }

    // Procesar el cierre del ticket
    public function close(Request $request, Ticket $ticket)
    {
        $comment = "requerimiento cerrado";

        $ticket->update(['state_id' => 7,]); /* 7 ID del estado "Cerrado" */
        $ticket->comment()->create([
            'content' => $comment,
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'state_ticket' => 'Finalizado',
        ]);

        $ticket->update(['state_id' => 7,]); /* 7 ID del estado "Cerrado" */


        HistoryController::logAction($ticket, true, Auth::id(), "El ticket fue cerrado por el usuario con ID " . Auth::id());
        // Cargar relaciones
        $ticket->load('state', 'user', 'assignedUsers', 'element');
        
     

        // Enviar correo notificando el cambio de estado
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));

        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));

        // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket cerrado con comentario agregado.');
    }

    // Mostrar el formulario para cancelar el ticket
    public function showCancelForm(Ticket $ticket): View
    {
        $this->authorize('manageOrCreateByUser', $ticket);
        return view('tickets.cancel', compact('ticket'));
    }

    // Procesar la cancelación del ticket
    public function cancel(Request $request, Ticket $ticket)
    {
        $this->authorize('manageOrCreateByUser', $ticket);
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = $validated['content'];


        $ticket->comment()->create([
            'content' => $comment,
            'user_id' => auth::id(),
            'ticket_id' => $ticket->id,
            'state_ticket' => 'Cancelado',
        ]);

        $ticket->update(['state_id' => 8]); /* 8 ID del estado "Cancelado" */

        HistoryController::logAction($ticket, true, Auth::id(), "El ticket fue cancelado por el usuario con ID " . Auth::id());
        // Cargar relaciones
        $ticket->load('state', 'user', 'assignedUsers', 'element');

         // Obtener el usuario asignado
         $userAssign = $ticket->assignedUsers()->where('is_active', true)->first();

        // Enviar correo notificando el cambio de estado
        Mail::to($$userAssign->email)->send(new TicketAlert($ticket));
        Mail::to($ticket->user->email)->send(new TicketStatusChanged($ticket));

        // Obtener la URL de la última vista desde la sesión
        $lastView = $request->session()->get('last_view', route('tickets.index'));


        // Redirigir a la última vista
        return redirect($lastView)->with('message', 'Ticket cancelado ');
    }
}
