<?php

use App\Http\Controllers\ElementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TicketAssignmentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */
Route::get('/dashboard',[ReportController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de Roles
Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index')->middleware('can:roles.index');
Route::get('/roles/create', [RolePermissionController::class, 'create'])->name('roles.create')->middleware('can:roles.create');
Route::post('/roles', [RolePermissionController::class, 'store'])->name('roles.store')->middleware('can:roles.store');
Route::get('/roles/{role}/edit', [RolePermissionController::class, 'edit'])->name('roles.edit')->middleware('can:roles.edit');
Route::put('/roles/{role}', [RolePermissionController::class, 'update'])->name('roles.update')->middleware('can:roles.update');
Route::delete('/roles/{role}', [RolePermissionController::class, 'destroy'])->name('roles.destroy')->middleware('can:roles.destroy');

//Rutas de users 
Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('can:users.index');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('can:users.show');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('can:users.edit');
Route::put('/users/{user}/update', [UserController::class, 'update'])->name('users.update')->middleware('can:users.update');
Route::get('/users/{user}/manage', [UserController::class, 'manageRoles'])->name('users.manageRoles')->middleware('can:users.manageRoles');
Route::post('/users/{user}/manage', [UserController::class, 'updateRoles'])->name('users.updateRoles')->middleware('can:users.updateRoles');

// Rutas de Categorías
Route::get('categories', [CategoryController::class,'index'])->name('categories.index')->middleware('can:categories.index');
Route::get('categories/create', [CategoryController::class,'create'])->name('categories.create')->middleware('can:categories.create');
Route::post('categories/create', [CategoryController::class,'store'])->name('categories.store')->middleware('can:categories.store');
Route::get('categories/{category}/edit', [CategoryController::class,'edit'])->name('categories.edit')->middleware('can:categories.edit');
Route::put('categories/{category}/update', [CategoryController::class,'update'])->name('categories.update')->middleware('can:categories.update');
Route::get('categories/{category}/elements', [CategoryController::class,'getElements'])->name('getElements')->middleware('can:getElements');
Route::get('categories/{category}', [CategoryController::class,'show'])->name('categories.show')->middleware('can:categories.show');
Route::delete('categories/{category}', [CategoryController::class,'destroy'])->name('categories.destroy')->middleware('can:categories.destroy');

// Rutas de Elementos
Route::get('elements', [ElementController::class,'index'])->name('elements.index')->middleware('can:elements.index');
Route::get('elements/create', [ElementController::class,'create'])->name('elements.create')->middleware('can:elements.create');
Route::post('elements/create', [ElementController::class,'store'])->name('elements.store')->middleware('can:elements.store');
Route::get('elements/{element}', [ElementController::class,'show'])->name('elements.show')->middleware('can:elements.show');
Route::get('elements/{element}/edit', [ElementController::class,'edit'])->name('elements.edit')->middleware('can:elements.edit');
Route::put('elements/{element}', [ElementController::class,'update'])->name('elements.update')->middleware('can:elements.update');
Route::delete('elements/{element}', [ElementController::class,'destroy'])->name('elements.destroy')->middleware('can:elements.destroy');

// Rutas de Estados
Route::get('states', [StateController::class,'index'])->name('states.index')->middleware('can:states.index');
Route::get('states/create', [StateController::class,'create'])->name('states.create')->middleware('can:states.create');
Route::post('states/create', [StateController::class,'store'])->name('states.store')->middleware('can:states.store');
Route::get('states/{state}', [StateController::class,'show'])->name('states.show')->middleware('can:states.show');
Route::get('states/{state}/edit', [StateController::class,'edit'])->name('states.edit')->middleware('can:states.edit');
Route::put('states/{state}', [StateController::class,'update'])->name('states.update')->middleware('can:states.update');
Route::delete('states/{state}', [StateController::class,'destroy'])->name('states.destroy')->middleware('can:states.destroy');


// Rutas de Tickets
Route::get('tickets',[TicketController::class, 'index'])->name('tickets.index')->middleware('can:tickets.index');
Route::get('tickets/create',[TicketController::class, 'create'])->name('tickets.create')->middleware('can:tickets.create');
Route::post('tickets/create',[TicketController::class, 'store'])->name('tickets.store')->middleware('can:tickets.store');
Route::get('tickets/{ticket}',[TicketController::class, 'show'])->name('tickets.show')->middleware('can:tickets.show');

Route::get('tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit')->middleware('can:tickets.edit');
Route::put('tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update')->middleware('can:tickets.update');
Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy')->middleware('can:tickets.destroy');

Route::get('my-tickets/{ticket}',[TicketController::class, 'myshow'])->name('tickets.myshow')->where('ticket', '[0-9]+')->middleware('can:tickets.show');

// Rutas de Comentarios
Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('can:comments.store');
Route::get('/tickets/{ticket}/comments', [CommentController::class, 'index'])->name('comments.index')->middleware('can:comments.index');

// Rutas de Historiales
Route::get('/tickets/{ticket}/history', [HistoryController::class, 'index'])->name('history.index')->middleware('can:history.index');
Route::get('my-histories', [HistoryController::class, 'myHistories'])->name('histories.my')->middleware('can:histories.my');

// Rutas de Mis Tickets
Route::get('/my-tickets', [TicketController::class, 'myTickets'])->name('tickets.my')->middleware('can:tickets.my');

// Rutas de Solución de Tickets
Route::get('/tickets/{ticket}/process', [TicketController::class, 'showProcessForm'])->name('tickets.process')->middleware('can:tickets.process');
Route::post('/tickets/{ticket}/process', [TicketController::class, 'process'])->name('tickets.process.submit')->middleware('can:tickets.process.submit');

// Rutas de Solución de Tickets
Route::get('/tickets/{ticket}/solve', [TicketController::class, 'showSolveForm'])->name('tickets.solve')->middleware('can:tickets.solve');
Route::post('/tickets/{ticket}/solve', [TicketController::class, 'solve'])->name('tickets.solve.submit')->middleware('can:tickets.solve.submit');

// Rutas de Derivación de Tickets
Route::get('/tickets/{ticket}/derive', [TicketController::class, 'showDeriveForm'])->name('tickets.derive')->middleware('can:tickets.derive');
Route::post('/tickets/{ticket}/derive', [TicketController::class, 'derive'])->name('tickets.derive.submit')->middleware('can:tickets.derive.submit');

// Rutas de Cierre de Tickets
Route::post('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close')->middleware('can:tickets.close');

// Rutas de Reapertura de Tickets
Route::get('/tickets/{ticket}/reopen', [TicketController::class, 'showReopenForm'])->name('tickets.reopen')->middleware('can:tickets.reopen');
Route::post('/tickets/{ticket}/reopen', [TicketController::class, 'reopen'])->name('tickets.reopen.submit')->middleware('can:tickets.reopen.submit');

// Rutas de Cancelación de Tickets
Route::get('/tickets/{ticket}/cancel', [TicketController::class, 'showCancelForm'])->name('tickets.cancel')->middleware('can:tickets.cancel');
Route::post('/tickets/{ticket}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel.submit')->middleware('can:tickets.cancel.submit');

// Rutas de Asignación de Tickets
Route::get('/support', [TicketAssignmentController::class, 'index'])->name('support.index')->middleware('can:support.index');//ticket sin asignar soporte
Route::get('/support/center', [TicketAssignmentController::class, 'center'])->name('support.center')->middleware('can:support.center');
Route::get('/support/{ticket}', [TicketAssignmentController::class, 'show'])->name('support.show')->middleware('can:support.show');
Route::post('/support/{ticket}', [TicketAssignmentController::class, 'store'])->name('support.store')->middleware('can:support.store');

// Rutas de Tickets Asignados a soporte
Route::get('/tickets-assigned', [TicketAssignmentController::class, 'assigned'])->name('support.assigned')->middleware('can:support.assigned');

//reporte

Route::get('/reports/tickets', [ReportController::class, 'ticketsReport'])->name('reports.tickets')->middleware('can:reports.tickets');
Route::get('/reports/{ticket}/tickets', [ReportController::class, 'sla'])->name('reports.sla')->middleware('can:reports.sla');
Route::get('/reports/summary', [ReportController::class, 'ticketsSummaryReport'])->name('reports.summary')->middleware('can:reports.summary');
Route::get('test', [TicketController::class, 'test'])->name('test');

require __DIR__.'/auth.php';
