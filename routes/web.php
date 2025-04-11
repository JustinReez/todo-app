<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/token', function () {
    return csrf_token();
});

Route::get('/', function () {
    return redirect()->route('tasks.upcoming');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/upcoming', [TaskController::class, 'upcoming'])->name('tasks.upcoming');
Route::get('/tasks/todo', [TaskController::class, 'todo'])->name('tasks.todo');
Route::get('/tasks/calendar', [TaskController::class, 'calendar'])->name('tasks.calendar');

Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::get('/tasks/work', [TaskController::class, 'works'])->name('tasks.works');
Route::get('/tasks/personal', [TaskController::class, 'personals'])->name('tasks.personals');