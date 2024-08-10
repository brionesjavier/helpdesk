<?php

use App\Http\Controllers\ElementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TicketAssignmentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::resource('categories', CategoryController::class);
Route::get('categories',[CategoryController::class,'index'])->name('categories.index');
Route::get('categories/create',[CategoryController::class,'create'])->name('categories.create');
Route::post('categories/create',[CategoryController::class,'store'])->name('categories.store');
Route::get('categories/{category}/edit/',[CategoryController::class,'edit'])->name('categories.edit');
Route::put('categories/{category}/update',[CategoryController::class,'update'])->name('categories.update');
Route::get('categories/{category}/elements',[CategoryController::class,'getElements'])->name('getElements');
Route::get('categories/{category}',[CategoryController::class,'show'])->name('categories.show');
Route::delete('categories/{category}',[CategoryController::class,'destroy'])->name('categories.destroy');

Route::get('elements', [ElementController::class,'index'] )->name('elements.index');
Route::get('elements/create', [ElementController::class,'create'] )->name('elements.create');
Route::post('elements/create', [ElementController::class,'store'] )->name('elements.store');
Route::get('elements/{element}', [ElementController::class,'show'] )->name('elements.show');
Route::get('elements/{element}/edit', [ElementController::class,'edit'] )->name('elements.edit');
Route::put('elements/{element}', [ElementController::class,'update'] )->name('elements.update');
Route::delete('elements/{element}', [ElementController::class,'destroy'] )->name('elements.destroy');

Route::get('states', [StateController::class,'index'] )->name('states.index');
Route::get('states/create', [StateController::class,'create'] )->name('states.create');
Route::post('states/create', [StateController::class,'store'] )->name('states.store');
Route::get('states/{state}', [StateController::class,'show'] )->name('states.show');
Route::get('states/{state}/edit', [StateController::class,'edit'] )->name('states.edit');
Route::put('states/{state}', [StateController::class,'update'] )->name('states.update');
Route::delete('states/{state}', [StateController::class,'destroy'] )->name('states.destroy');

Route::get('tickets',[TicketController::class, 'index'])->name('tickets.index');
Route::get('tickets/create',[TicketController::class, 'create'])->name('tickets.create');
Route::post('tickets/create',[TicketController::class, 'store'])->name('tickets.store');
Route::get('tickets/{ticket}',[TicketController::class, 'show'])->name('tickets.show');
Route::get('tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
Route::put('tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');


Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/tickets/{ticket}/comments', [CommentController::class, 'index'])->name('comments.index');
Route::get('/tickets/{ticket}/history', [HistoryController::class, 'index']);

Route::get('/support', [TicketAssignmentController::class, 'index'])->name('support.index');
Route::get('/support/{ticket}', [TicketAssignmentController::class, 'show'])->name('support.show');
Route::post('/support/{ticket}', [TicketAssignmentController::class, 'store'])->name('support.store');

Route::get('/tickets-assigned', [TicketAssignmentController::class, 'assigned'])->name('support.assigned');

Route::get('/my-tickets', [TicketController::class, 'myTickets'])->name('tickets.my');
Route::get('/my-tickets/{tickets}', [TicketController::class, 'show'])->name('tickets.show');




require __DIR__.'/auth.php';
