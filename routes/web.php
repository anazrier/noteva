<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\AIController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect root URL ke notes index
Route::get('/', function () {
    return redirect()->route('notes.index');
});

// Resource routes untuk notes
Route::resource('notes', NotesController::class);

// AI routes
Route::post('/notes/{note}/summarize', [AIController::class, 'summarize'])->name('notes.summarize');
Route::post('/notes/{note}/generate-todo', [AIController::class, 'generateTodo'])->name('notes.generateTodo');
Route::post('/notes/{note}/update-todo-item', [AIController::class, 'updateTodoItem'])->name('notes.updateTodoItem');

// Notes additional routes
Route::post('/notes/{id}/pin', [NotesController::class, 'togglePin'])->name('notes.pin');
Route::get('/search', [NotesController::class, 'search']);

// Test route (sebaiknya dihapus di production)
Route::get("/test-key", function() {
    return env("OPENAI_API_KEY");
});