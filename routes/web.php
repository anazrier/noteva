<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\AIController;

Route::resource('notes', NotesController::class);

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


Route::resource('notes', NotesController::class);
//Route Summarize
Route::post('/notes/{note}/summarize', [AIController::class, 'summarize'])->name('notes.summarize');

//Route TO DO
Route::post('/notes/{note}/generate-todo', [AIController::class, 'generateTodo'])->name('notes.generateTodo');
Route::post('/notes/{note}/update-todo-item', [AIController::class, 'updateTodoItem'])->name('notes.updateTodoItem');

//Route rewrite
Route::post('/notes/{note}/rewrite', [AIController::class, 'rewrite'])->name('notes.rewrite');

//Route Expand
Route::post('/notes/{note}/expand', [AIController::class, 'expand'])->name('notes.expand');

Route::get("/test-key", function() {
    return env("OPENAI_API_KEY");
});


Route::post('/summarize', [AIController::class, 'summarize'])->name('ai.summarize');
Route::get("/test-key", function() {
    return env("OPENAI_API_KEY");
});

