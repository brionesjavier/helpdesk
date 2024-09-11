<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\State;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
  
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

    // Si no se proporciona una fecha de inicio, se toma una fecha por defecto
    $startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;

    // Construir la consulta para los tickets
    $tickets = Ticket::with(['assignedUsers', 'state', 'element.category']) // Asegurarse de cargar la relación con categoría a través de element
        ->when($search, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('id', $search);
            });
        })
        ->when($status && $status != 'all', function ($query) use ($status) {
            $query->whereHas('state', function ($query) use ($status) {
                $query->where('id', $status);
            });
        })
        ->when($priority && $priority != 'all', function ($query) use ($priority) {
            $query->where('priority', $priority);
        })
        ->when($startDate, function ($query) use ($startDate) {
            $query->where('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query) use ($endDate) {
            $query->where('created_at', '<=', $endDate);
        })
        ->when($user && $user != 'all', function ($query) use ($user) {
            $query->whereHas('assignedUsers', function ($query) use ($user) {
                $query->where('user_id', $user)
                      ->where('is_active', true);
            });
        })
        // Filtro por categoría a través de la relación element
        ->when($category && $category != 'all', function ($query) use ($category) {
            $query->whereHas('element.category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Mantener los parámetros de búsqueda en la paginación
    $tickets->appends([
        'search' => $search,
        'status' => $status,
        'priority' => $priority,
        'start_date' => $startDate ? $startDate->toDateString() : null,
        'end_date' => $endDate->toDateString(),
        'user' => $user,
        'category' => $category, // Asegurarse de que la categoría esté en la paginación
    ]);

    // Obtener las categorías, estados y usuarios para los filtros
    $categories = Category::all();
    $states = State::all();
    $users = User::where('assignable', true)->get();

    // Retornar la vista con los datos para mostrar
    return view('reports.tickets', compact('tickets', 'search', 'status', 'priority', 'startDate', 'endDate', 'states', 'users', 'categories', 'category'));
}
}

    


    
    
    
    

