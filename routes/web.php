<?php

use App\Http\Controllers\ElementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StateController;
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
Route::get('categories/{category}',[CategoryController::class,'show'])->name('categories.show');
Route::delete('categories/{category}',[CategoryController::class,'destroy'])->name('categories.destroy');

route::get('elements', [ElementController::class,'index'] )->name('elements.index');
route::get('elements/create', [ElementController::class,'create'] )->name('elements.create');
route::post('elements/create', [ElementController::class,'store'] )->name('elements.store');
route::get('elements/{element}', [ElementController::class,'show'] )->name('elements.show');
route::get('elements/{element}/edit', [ElementController::class,'edit'] )->name('elements.edit');
route::put('elements/{element}', [ElementController::class,'update'] )->name('elements.update');
route::delete('elements/{element}', [ElementController::class,'destroy'] )->name('elements.destroy');

route::get('states', [StateController::class,'index'] )->name('states.index');
route::get('states/create', [StateController::class,'create'] )->name('states.create');
route::post('states/create', [StateController::class,'store'] )->name('states.store');
route::get('states/{state}', [StateController::class,'show'] )->name('states.show');
route::get('states/{state}/edit', [StateController::class,'edit'] )->name('states.edit');
route::put('states/{state}', [StateController::class,'update'] )->name('states.update');
route::delete('states/{state}', [StateController::class,'destroy'] )->name('states.destroy');

route::get('tickets',[TicketController::class, 'index'])->name('tickets.index');
route::get('tickets/create',[TicketController::class, 'create'])->name('tickets.create');
route::post('tickets/create',[TicketController::class, 'store'])->name('tickets.store');
route::get('tickets/{ticket}',[TicketController::class, 'show'])->name('tickets.show');
route::get('tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
route::put('tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

require __DIR__.'/auth.php';
