<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\State;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Muestra el reporte de tickets filtrado por diversos parámetros
     */
    public function ticketsReport(Request $request)
    {
        // Obtener los valores de los filtros desde la solicitud
        $search = $request->input('search');
        $status = $request->input('status');
        $priority = $request->input('priority');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $user = $request->input('user');
        $category = $request->input('category'); // Obtener la categoría desde el request

        // Ajustar la fecha final para incluir hasta el final del día
        $endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfDay();
        // Si no se proporciona una fecha de inicio, usar una fecha por defecto (null)
        $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;

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
            ->orderBy('created_at', 'desc') // Ordenar por fecha de creación
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
        ]);

        // Obtener categorías, estados y usuarios para los filtros
        $categories = Category::all();
        $states = State::all();
        $users = User::where('assignable', true)->get();

        // Retornar la vista con los datos para mostrar
        return view('reports.tickets', compact(
            'tickets', 'search', 'status', 'priority', 
            'startDate', 'endDate', 'states', 'users', 'categories', 'category'
        ));
    }

    /**
     * Muestra el resumen del reporte de tickets
     */
    public function ticketsSummaryReport()
    {
        // Contar el número total de tickets
        $totalTickets = Ticket::count();

        // Calcular el SLA de atención promedio por usuario
         $slaAttentionByUser = User::select('users.id', 'users.first_name', 'users.last_name')
                                    ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, ticket_assigns.created_at, tickets.created_at)) as avg_attention_time')
                                    ->selectRaw('COUNT(ticket_assigns.id) as total')
                                    ->join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
                                    ->join('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
                                    ->groupBy('users.id', 'users.first_name', 'users.last_name')
                                    ->orderBy('total', 'desc')
                                    ->get();
                                 
                                


        // Calcular el SLA de resolución promedio por usuario
        $slaResolutionByUser = User::select('users.id', 'users.first_name', 'users.last_name')
                                    ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, ticket_assigns.created_at, tickets.solved_at)) as avg_resolution_time')
                                    ->selectRaw('COUNT(ticket_assigns.id) as total')
                                    ->join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
                                    ->join('tickets', 'ticket_assigns.ticket_id', '=', 'tickets.id')
                                    ->whereNotNull('tickets.solved_at')
                                    ->groupBy('users.id', 'users.first_name', 'users.last_name')
                                    ->orderBy('total', 'desc')
                                    ->get();

        // Calcular el SLA de atención promedio general
        $avgAttentionTime = Ticket::join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
                                    ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, ticket_assigns.created_at, tickets.created_at)) as avg_attention_time')
                                    ->value('avg_attention_time');

        // Calcular el SLA de solución promedio general
         $avgResolutionTime =Ticket::join('ticket_assigns', 'tickets.id', '=', 'ticket_assigns.ticket_id')
                                    ->whereNotNull('tickets.solved_at')
                                    ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, ticket_assigns.created_at, tickets.solved_at)) as avg_resolution_time')
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

        // Contar tickets por usuario
        $ticketsByUser = User::select('users.id', 'users.first_name', 'users.last_name', DB::raw('COUNT(ticket_assigns.id) as total'))
        ->join('ticket_assigns', 'users.id', '=', 'ticket_assigns.user_id')
        ->groupBy('users.id', 'users.first_name', 'users.last_name') // Incluye todas las columnas no agregadas aquí
        ->get();
    


        // Retornar la vista con los datos del resumen
        return view('reports.summary', compact(
            'totalTickets', 'ticketsByCategory', 'ticketsByElement', 
            'ticketsByPriority', 'ticketsByUser', 'slaAttentionByUser', 
            'slaResolutionByUser', 'avgAttentionTime', 'avgResolutionTime'
        ));
    }
}
