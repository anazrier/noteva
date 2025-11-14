<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/notes', function () {
    $notes = session('notes', []);
    return view('notes', ['notes' => $notes]);
});

Route::get('/notes/create', function () {
    return view('create');
});

Route::post('/notes', function (Request $request) {
    // Ambil data dari form
    $title = $request->input('title');
    $note = $request->input('note');

    // Sementara, kita simpan di session dulu (belum pakai database)
    $notes = session('notes', []);
    $notes[] = ['title' => $title, 'note' => $note];
    session(['notes' => $notes]);

    // Kembali ke halaman utama
    return redirect('/notes');
});