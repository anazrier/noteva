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


Route::post('/summarize', [AIController::class, 'summarize'])->name('ai.summarize');
Route::get("/test-key", function() {
    return env("OPENAI_API_KEY");
});

