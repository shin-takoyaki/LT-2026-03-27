<?php

declare(strict_types=1);

use App\InterfaceAdapters\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index'])->name('todos.index');
Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
Route::patch('/todos/{id}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');
Route::patch('/todos/{id}/title', [TodoController::class, 'updateTitle'])->name('todos.updateTitle');
Route::delete('/todos/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
