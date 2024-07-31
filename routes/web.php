<?php

use App\Http\Controllers\ElementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
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
require __DIR__.'/auth.php';
