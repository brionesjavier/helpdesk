<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\History;
use App\Models\State;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function dashboard()
    {

        $userId = Auth::id();
        $ticketsPendientes = Ticket::where('created_by', $userId)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('state_id', 1);
            })
            ->count();


        $ticketsEnProceso = Ticket::where('created_by', $userId)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('state_id', 2)
                    ->orWhere('state_id', 3)
                    ->orWhere('state_id', 6);
            })
            ->count();

        $ticketsSolucionados = Ticket::where('created_by', $userId)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('state_id', 4)
                    ->orWhere('state_id', 7);
            })
            ->count();

        $ticketsCancelados = Ticket::where('created_by', $userId)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('state_id', 8)
                    ->orWhere('state_id', 5);
            })
            ->count();

        return view('dashboard', compact('ticketsPendientes', 'ticketsEnProceso', 'ticketsSolucionados', 'ticketsCancelados'));
    }


    public function sla(Ticket $ticket)
    {

        $histories = History::where('ticket_id', $ticket->id)
            ->where('change_state', true)
            ->get();

        return view('reports.sla', compact('ticket', 'histories'));
    }

    /**
     * Muestra el reporte de tickets filtrado por diversos parámetros
     */
    public function ticketsReport(Request $request)
    {

        // Guardar la URL actual en la sesión
        $request->session()->put('last_view', url()->current());

        // Validar los datos del formulario
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
            'status' => 'nullable|integer|exists:ticket_states,id',
            'priority' => 'nullable|string|in:low,medium,high',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'user' => 'nullable|integer|exists:users,id',
            'category' => 'nullable|integer|exists:categories,id',
            'order_by' => 'nullable|string|in:created_at,priority,title,id',
            'direction' => 'nullable|string|in:asc,desc',

        ]);

        // Extraer los valores validados o establecer valores predeterminados
        $search = $validated['search'] ?? null;
        $status = $validated['status'] ?? 'all';
        $priority = $validated['priority'] ?? 'all';
        $startDate = isset($validated['start_date']) ? Carbon::parse($validated['start_date'])->startOfDay() : null;
        $endDate = isset($validated['end_date']) ? Carbon::parse($validated['end_date'])->endOfDay() : Carbon::now()->endOfDay();
        $user = $validated['user'] ?? 'all';
        $category = $validated['category'] ?? 'all';
        $orderBy = $validated['order_by'] ?? 'created_at';
        $direction = $validated['direction'] ?? 'desc';

        // Construir la consulta para los tickets con filtros dinámicos
        $tickets = Ticket::with(['assignedUsers', 'state', 'element.category']) // Relaciones necesarias
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('id', $search); // Buscar por título o ID
                });
            })
            ->when($status && $status != 'all', function ($query) use ($status) {
                $query->whereHas('state', function ($query) use ($status) {
                    $query->where('id', $status); // Filtrar por estado
                });
            })
            ->when($priority && $priority != 'all', function ($query) use ($priority) {
                $query->where('priority', $priority); // Filtrar por prioridad
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->where('created_at', '>=', $startDate); // Filtrar por fecha de inicio
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->where('created_at', '<=', $endDate); // Filtrar por fecha de fin
            })
            ->when($user && $user != 'all', function ($query) use ($user) {
                $query->whereHas('assignedUsers', function ($query) use ($user) {
                    $query->where('user_id', $user)
                        ->where('is_active', true); // Filtrar por usuario asignado
                });
            })
            ->when($category && $category != 'all', function ($query) use ($category) {
                $query->whereHas('element.category', function ($query) use ($category) {
                    $query->where('id', $category); // Filtrar por categoría
                });
            })
            //->orderBy('created_at', 'desc') // Ordenar por fecha de creación
            ->orderBy($orderBy, $direction) // Ordenar por ID en desc
            ->paginate(10); // Paginación de resultados

        // Agregar el SLA en minutos a los tickets
        $tickets->map(function ($ticket) {
            $ticket->sla_in_minutes = $ticket->sla_in_minutes; // Atributo SLA
            return $ticket;
        });

        // Calcular el SLA para cada ticket
        foreach ($tickets as $ticket) {
            $ticket->sla = null;
            if ($ticket->assignedUsers->count() > 0) {
                $firstAssignment = $ticket->assignedUsers->first()->pivot->created_at;
                $ticket->sla = round(abs($firstAssignment->diffInMinutes($ticket->created_at))); // Diferencia en minutos
            }
        }

        // Mantener los parámetros de búsqueda en la paginación
        $tickets->appends([
            'search' => $search,
            'status' => $status,
            'priority' => $priority,
            'start_date' => $startDate ? $startDate->toDateString() : null,
            'end_date' => $endDate->toDateString(),
            'user' => $user,
            'category' => $category,
            'order_by' => $orderBy,
        ]);

        // Obtener categorías, estados y usuarios para los filtros
        $categories = Category::all();
        $states = State::all();
        $users = User::where('assignable', true)->get();

        // Retornar la vista con los datos para mostrar
        return view('reports.tickets', compact(
            'tickets',
            'search',
            'status',
            'priority',
            'startDate',
            'endDate',
            'states',
            'users',
            'categories',
            'category'
        ));
    }

    /**
     * Muestra el resumen del reporte de tickets
     */
    public function ticketsSummaryReport()
    {
        // Contar el número total de tickets
        $totalTickets = Ticket::count();

        // Contar el número de tickets pendiente
        $ticketsPendientes = Ticket::where('state_id', 1)->count();
        // Contar el número de tickets solucionado o finalizado
        $ticketsSolucionados = Ticket::whereIn('state_id', [4, 7])->count();
        // Contar el número de tickets en proceso  esto pueden ser asignado ,derivado en proceso
        $ticketsEnProceso = Ticket::whereIn('state_id', [2, 3, 6])->count();
        // Contar el número de tickets objetados
        $ticketsObjetados = Ticket::where('state_id', 5)->count();
        // Contar el número de tickets cancelados
        $ticketsCancelados = Ticket::where('state_id', 8)->count();


        // Calcular el SLA de atención promedio por usuario
        $slaAttentionByUser = User::select('users.id', 'users.first_name', 'users.last_name')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, tickets.created_at, tickets.sla_assigned_start_time)) AS avg_attention_time')
            ->selectRaw('COUNT(ticket_assigns.id) AS total')
            ->join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
            ->join('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
            ->where('ticket_assigns.is_active', 1)  // Filtra solo las asignaciones activas
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->orderBy('total', 'desc')
            ->get();




        // Calcular el SLA de resolución promedio por usuario
        $slaResolutionByUser = User::select(
            'users.id',
            'users.first_name',
            'users.last_name',
            DB::raw('AVG(TIMESTAMPDIFF(MINUTE, tickets.sla_assigned_start_time, tickets.solved_at)) AS avg_resolution_time'),
            DB::raw('COUNT(ticket_assigns.id) AS total')
        )
            ->join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
            ->join('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
            ->whereNotNull('tickets.solved_at')
            ->whereIn('tickets.state_id', [4, 7])  // Utiliza whereIn para los estados
            ->where('ticket_assigns.is_active', 1)  // Solo asignaciones activas
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->get();


        // Calcular el SLA de atención promedio general
        $avgAttentionTime = Ticket::selectRaw('AVG(TIMESTAMPDIFF(MINUTE,  tickets.created_at,tickets.sla_assigned_start_time)) as avg_attention_time')
            ->whereNotNull('tickets.sla_assigned_start_time')
            ->value('avg_attention_time');

        // Calcular el SLA de solución promedio general
        $avgResolutionTime = Ticket::whereNotNull(['solved_at', 'sla_assigned_start_time']) // Combinando ambos campos en una sola línea
            ->where(function ($query) {
                $query->where('state_id', 4)
                    ->orWhere('state_id', 7);
            })
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, sla_assigned_start_time, solved_at)) as avg_resolution_time')
            ->value('avg_resolution_time');

        // Contar tickets por categoría
        $ticketsByCategory = Category::select('categories.name')
            ->selectRaw('COUNT(tickets.id) as total')
            ->join('elements', 'categories.id', '=', 'elements.category_id')
            ->join('tickets', 'elements.id', '=', 'tickets.element_id')
            ->groupBy('categories.name')
            ->get();

        // Contar tickets por elemento
        $ticketsByElement = Ticket::select('elements.name as element', DB::raw('count(tickets.id) as total'))
            ->join('elements', 'tickets.element_id', '=', 'elements.id')
            ->groupBy('elements.name')
            ->get();

        // Contar tickets por prioridad
        $ticketsByPriority = Ticket::select('priority', DB::raw('count(id) as total'))
            ->groupBy('priority')
            ->get();


        $ticketsByUser = User::select(
            'users.id',
            'users.first_name',
            'users.last_name',
            DB::raw('COUNT(ticket_assigns.id) as total'),
            DB::raw('COUNT(CASE WHEN ticket_assigns.is_active = true THEN 1 END) as finalizado')
        )
            ->Join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id') // Usar LEFT JOIN si deseas incluir usuarios sin tickets
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->get();

        //contar ticket reasignados
        $ticketsMultipleAssignments = DB::table('ticket_assigns')
        ->select('ticket_id', DB::raw('COUNT(id) as total_assignments'))
        ->groupBy('ticket_id')
        ->having('total_assignments', '>', 1)
        ->get();




        // Retornar la vista con los datos del resumen
        return view('reports.summary', compact(
            'totalTickets',
            'ticketsPendientes',
            'ticketsSolucionados',
            'ticketsEnProceso',
            'ticketsObjetados',
            'ticketsCancelados',
            'ticketsByCategory',
            'ticketsByElement',
            'ticketsByPriority',
            'ticketsByUser',
            'ticketsMultipleAssignments',
            'slaAttentionByUser',
            'slaResolutionByUser',
            'avgAttentionTime',
            'avgResolutionTime'
        ));
    }
}
