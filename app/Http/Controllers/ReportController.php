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
use App\SlaTimeFormatter;

class ReportController extends Controller
{
    use SlaTimeFormatter;

    public function dashboard()
    {
        /* se obtiene la fecha del dia */
        $today = Carbon::today();

        /* se obtiene el usuario autenticado */
        $user = auth::user();

        /* dashboar usuario basico */
        $ticketsPendientes = Ticket::where('created_by', $user->id)
            ->where('is_active', true)
            ->where('state_id', 1)
            ->count();

        $ticketsEnProceso = Ticket::where('created_by', $user->id)
            ->where('is_active', true)
            ->whereIn('state_id', [2, 3, 6])
            ->count();

        $ticketsSolucionados = Ticket::where('created_by', $user->id)
            ->where('is_active', true)
            ->whereIn('state_id', [4, 7])
            ->count();

        $ticketsCancelados = Ticket::where('created_by', $user->id)
            ->where('is_active', true)
            ->whereIn('state_id', [5, 8])
            ->count();

        /* dashboar usuario soporte */


        // tickets asignados/derivado a soporte
        $ticketsGestion = $user->assignedTickets()
            ->wherePivot('is_active', true)
            ->whereIn('state_id', [2, 6])
            ->count();
        // tickets en proceso por soporte
        $ticketsGestionProcess = $user->assignedTickets()
            ->wherePivot('is_active', true)
            ->where('state_id', 3)
            ->count();

        // Tickets asignados/derivados a soporte resueltos del día
        $ticketsGestionSolved = $user->assignedTickets()
            ->wherePivot('is_active', true)
            ->whereIn('state_id', [4, 7])
            ->whereDate('tickets.solved_at', $today) // Filtrar por fecha
            ->whereNotNull('solved_at')
            ->count();

        // tickets en Objetado a soporte
        $ticketsGestionObjet = $user->assignedTickets()
            ->wherePivot('is_active', true)
            ->where('state_id', 5)
            ->count();

        // Tickets cancelados  del día por usuario o soporte
        $ticketsGestionCancel = $user->assignedTickets()
            ->wherePivot('is_active', true)
            ->where('state_id', 8)
            ->whereDate('tickets.created_at', $today) // Filtrar por fecha
            ->count();

        // Tickets asignados/derivados a soporte resueltos del día
        $ticketsGestionTotal = $user->assignedTickets()
            ->wherePivot('is_active', true)
            ->whereIn('state_id', [2, 3, 5, 6,])
            ->count();

        //dashboard administracion

        // Consultas para contar los tickets
        $totalTicketsPendientes = Ticket::where('state_id', 1)
            ->where('solved_at', null)
            ->count();
        $totalTicketsEnGestion = Ticket::whereIn('state_id', [2, 6])
            ->count();

        $totalTicketsEnProceso = Ticket::where('state_id', 3)
            ->where('solved_at', null)
            ->count();

        $totalTicketsSolucionados = Ticket::whereIn('state_id', [4, 7])
            ->whereNotNull('solved_at')
            ->count();
        $totalTicketsObjetado = Ticket::where('state_id', 5)
            ->where('solved_at', null)
            ->count();

        $totalTicketsCancelados = Ticket::where('state_id', 8)
            ->count();
        $totalTickets = Ticket::count();



        //administracion ticket del dia

        $totalTicketsPendientesDelDia = Ticket::where('state_id', 1)
            ->where('solved_at', null)
            ->whereDate('updated_at', $today)
            ->count();

        $totalTicketsEnGestionDelDia = Ticket::whereIn('state_id', [2, 6])
            ->whereDate('updated_at', $today)
            ->count();

        $totalTicketsEnProcesoDelDia = Ticket::where('state_id', 3)
            ->where('solved_at', null)
            ->whereDate('updated_at', $today)
            ->count();

        $totalTicketsSolucionadosDelDia = Ticket::whereIn('state_id', [4, 7])
            ->whereNotNull('solved_at')
            ->whereDate('updated_at', $today)
            ->count();

        $totalTicketsObjetadoDelDia = Ticket::where('state_id', 5)
            ->where('solved_at', null)
            ->whereDate('updated_at', $today)
            ->count();

        $totalTicketsCanceladosDelDia = Ticket::where('state_id', 8)
            ->whereDate('updated_at', $today)
            ->count();

        $totalTicketsDelDia = Ticket::whereDate('created_at', $today) // Contar solo tickets del día
            ->count();




        return view('dashboard', compact(
            'ticketsPendientes',
            'ticketsEnProceso',
            'ticketsSolucionados',
            'ticketsCancelados',

            'ticketsGestion',
            'ticketsGestionProcess',
            'ticketsGestionSolved',
            'ticketsGestionObjet',
            'ticketsGestionCancel',
            'ticketsGestionTotal',

            'totalTicketsPendientes',
            'totalTicketsEnGestion',
            'totalTicketsEnProceso',
            'totalTicketsSolucionados',
            'totalTicketsObjetado',
            'totalTicketsCancelados',
            'totalTickets',

            'totalTicketsPendientesDelDia',
            'totalTicketsEnGestionDelDia',
            'totalTicketsEnProcesoDelDia',
            'totalTicketsSolucionadosDelDia',
            'totalTicketsObjetadoDelDia',
            'totalTicketsCanceladosDelDia'
        ));
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
        $startDate = isset($validated['start_date']) ? Carbon::parse($validated['start_date'])->startOfDay() : Carbon::now()->startOfDay();
        $endDate = isset($validated['end_date']) ? Carbon::parse($validated['end_date'])->endOfDay() : Carbon::now()->endOfDay();
        $user = $validated['user'] ?? 'all';
        $category = $validated['category'] ?? 'all';
        $orderBy = $validated['order_by'] ?? 'created_at';
        $direction = $validated['direction'] ?? 'desc';

        // Construir la consulta para los tickets con filtros dinámicos
        $tickets = Ticket::with(['assignedUsers', 'state', 'element.category']) // Relaciones necesarias
            ->selectRaw('*, EXTRACT(EPOCH FROM sla_assigned_start_time - created_at)  as sla_assigned,
                            EXTRACT(EPOCH FROM solved_at - sla_assigned_start_time )  as sla_solved')

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
    public function ticketsSummaryReport(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = isset($validated['start_date']) ? Carbon::parse($validated['start_date'])->startOfDay() : Carbon::now()->startOfDay();
        $endDate = isset($validated['end_date']) ? Carbon::parse($validated['end_date'])->endOfDay() : Carbon::now()->endOfDay();

        // Contar el número total de tickets
        $totalTickets = Ticket::whereBetween('created_at', [$startDate, $endDate])->count();

        // Contar el número de tickets pendiente
        $ticketsPendientes = Ticket::where('state_id', 1)->whereBetween('created_at', [$startDate, $endDate])->count();
        // Contar el número de tickets solucionado o finalizado
        $ticketsSolucionados = Ticket::whereIn('state_id', [4, 7])->whereBetween('created_at', [$startDate, $endDate])->count();
        // Contar el número de tickets en proceso  esto pueden ser asignado ,derivado en proceso
        $ticketsEnProceso = Ticket::whereIn('state_id', [2, 3, 6])->whereBetween('created_at', [$startDate, $endDate])->count();
        // Contar el número de tickets objetados
        $ticketsObjetados = Ticket::where('state_id', 5)->whereBetween('created_at', [$startDate, $endDate])->count();
        // Contar el número de tickets cancelados
        $ticketsCancelados = Ticket::where('state_id', 8)->whereBetween('created_at', [$startDate, $endDate])->count();


        // Calcular el SLA de asignacion promedio por usuario
        $slaAttentionByUser = User::select('users.id', 'users.first_name', 'users.last_name')
            ->selectRaw('AVG(EXTRACT(EPOCH FROM tickets.sla_assigned_start_time - tickets.created_at))  as avg_attention_time') //TODO:EN REVISION
            ->selectRaw('COUNT(ticket_assigns.id) AS total')
            ->join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
            ->join('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
            ->where('ticket_assigns.is_active', 1)  // Filtra solo las asignaciones activas
            ->whereBetween('tickets.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->orderBy('total', 'desc')
            ->get();

        // Calcular el SLA de resolución promedio por usuario
        $slaResolutionByUser = User::select(
            'users.id',
            'users.first_name',
            'users.last_name',
            DB::raw('AVG(EXTRACT(EPOCH FROM  tickets.solved_at - tickets.sla_assigned_start_time))  as avg_resolution_time'), //TODO:EN REVISION
            DB::raw('COUNT(ticket_assigns.id) AS total')
        )
            ->join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
            ->join('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
            ->whereNotNull('tickets.solved_at')
            ->whereIn('tickets.state_id', [4, 7])  // Utiliza whereIn para los estados
            ->where('ticket_assigns.is_active', 1)  // Solo asignaciones activas
            ->whereBetween('tickets.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->get();

        $supportTickets = User::select(
            'users.id',
            'users.first_name',
            'users.last_name',
            DB::raw('COUNT(CASE WHEN tickets.state_id IN (2, 3, 6) THEN tickets.id END) AS process_tickets'),  // Total de tickets en estados 2, 3 y 6
            DB::raw('SUM(CASE WHEN tickets.state_id = 5 THEN 1 ELSE 0 END) AS obj_tickets'),  // Conteo de tickets en estado 5
            DB::raw('COUNT(tickets.id) AS total_tickets')  // Total de tickets en estados 2, 3, 5 y 6
        )
            ->leftJoin('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
            ->leftJoin('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
            ->whereIn('tickets.state_id', [2, 3, 5, 6])  // Utiliza whereIn para múltiples valores
            ->where('ticket_assigns.is_active', 1)  // Solo asignaciones activas
            ->whereBetween('tickets.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->get();


        // Calcular el SLA de atención promedio general
        $avgAttentionTime = Ticket::selectRaw('AVG(EXTRACT(EPOCH FROM  tickets.sla_assigned_start_time - tickets.created_at ))  as avg_attention_time') //TODO:EN REVISION
            ->whereNotNull('tickets.sla_assigned_start_time')
            ->whereBetween('tickets.created_at', [$startDate, $endDate])
            ->value('avg_attention_time');

        // Calcular el SLA de solución promedio general
        $avgResolutionTime = Ticket::selectRaw('AVG(EXTRACT(EPOCH FROM solved_at - sla_assigned_start_time ))  as avg_resolution_time')
            ->where(function ($query) {
                $query->where('state_id', 4)
                    ->orWhere('state_id', 7);
            })
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereNotNull(['solved_at', 'sla_assigned_start_time']) // Combinando ambos campos en una sola línea
            ->value('avg_resolution_time');

            $ticket = new Ticket();

        // Formatear los tiempos antes de pasarlos a la vista
        $formattedAvgAttentionTime =$ticket->getFormattedSla($avgAttentionTime);
        $formattedAvgResolutionTime =$ticket->getFormattedSla($avgResolutionTime);

        // Contar tickets por categoría
        $ticketsByCategory = Category::select('categories.name')
            ->selectRaw('COUNT(tickets.id) as total')
            ->join('elements', 'categories.id', '=', 'elements.category_id')
            ->join('tickets', 'elements.id', '=', 'tickets.element_id')
            ->whereBetween('tickets.created_at', [$startDate, $endDate])
            ->groupBy('categories.name')
            ->get();

        // Contar tickets por elemento
        $ticketsByElement = Ticket::select('elements.name as element', DB::raw('count(tickets.id) as total'))
            ->join('elements', 'tickets.element_id', '=', 'elements.id')
            ->whereBetween('tickets.created_at', [$startDate, $endDate])
            ->groupBy('elements.name')
            ->get();

        // Contar tickets por prioridad
        $ticketsByPriority = Ticket::select('priority', DB::raw('count(id) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
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
            ->whereBetween('ticket_assigns.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->get();

        //contar ticket reasignados
        $ticketsMultipleAssignments = DB::table('ticket_assigns')
    ->select('ticket_id', DB::raw('COUNT(id) as total_assignments'))
    ->whereBetween('ticket_assigns.created_at', [$startDate, $endDate])
    ->groupBy('ticket_id')
    ->having(DB::raw('COUNT(id)'), '>', 1)
    ->get();

        // Obtener tickets objetados más de una vez
        $ticketsObjetadosCount = History::selectRaw('ticket_id,COUNT(*) AS total_objeciones')
            ->where('state_id', '=', 4) // Estado "Objetado"
            ->where('change_state', 1) // Solo cambios de estado
            ->whereBetween('created_at', [$startDate, $endDate]) // Filtra por rango de fechas
            ->groupBy('ticket_id')
            ->having(DB::raw('COUNT(id)'), '>', 1)
            ->get(); // Podrías usar paginate() si esperas muchos resultados


        $TimesSolvedByUser = $this->TimesSolvedByUser($startDate, $endDate);

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
            'supportTickets',
            'ticketsObjetadosCount',
            'ticketsMultipleAssignments',
            'slaAttentionByUser',
            'slaResolutionByUser',
            'avgAttentionTime',
            'avgResolutionTime',
            'formattedAvgAttentionTime',
            'formattedAvgResolutionTime',
            'TimesSolvedByUser'
        ));
    }

    public function TimesSolvedByUser($startDate, $endDate)
    {
        $TimesSolvedByUser = User::select(
            'users.id AS user_id',
            'users.first_name',
            'users.last_name'
        )
        ->selectRaw('AVG(EXTRACT(EPOCH FROM  latest_solution.latest_solution_date -latest_assignment.latest_assignment_date  )) as avgSolutionByUser')
        ->selectRaw('COUNT(tickets.id) AS total')
        ->join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
        ->join('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
        ->leftJoin(DB::raw('(
            SELECT 
                ticket_id, 
                MAX(created_at) AS latest_assignment_date 
            FROM histories 
            WHERE state_id IN (2, 6) -- Estado de derivación o asignación
            GROUP BY ticket_id
        ) AS latest_assignment'), 'tickets.id', '=', 'latest_assignment.ticket_id')
        ->leftJoin(DB::raw('(
            SELECT 
                ticket_id, 
                MAX(histories.created_at) AS latest_solution_date 
            FROM histories 
            JOIN tickets ON histories.ticket_id = tickets.id 
            WHERE histories.state_id = 4 AND (tickets.state_id = 4 OR tickets.state_id = 7)
            GROUP BY ticket_id
        ) AS latest_solution'), 'tickets.id', '=', 'latest_solution.ticket_id')
        ->where('ticket_assigns.is_active', 1)
        ->whereBetween('tickets.created_at', [$startDate, $endDate])
        ->whereNotNull('latest_solution.latest_solution_date')
        ->groupBy('users.id', 'users.first_name', 'users.last_name')
        ->orderByRaw('AVG(EXTRACT(EPOCH FROM  latest_assignment.latest_assignment_date - latest_solution.latest_solution_date )) ASC')
        ->get();
    
        return $TimesSolvedByUser;
    }
    
}
