<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;

Route::resource('notes', NotesController::class);
