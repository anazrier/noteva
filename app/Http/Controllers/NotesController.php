<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotesController extends Controller
{
    public function index()
    {
        $notes = Notes::orderBy('created_at', 'desc')->get();

        return view('notes.index', [
            'notes' => $notes
        ]);
    }
    
    public function create()
    {
        return view ('notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $note = Notes::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_perubahan' => Carbon::now(),
        ]);

        return redirect()->route('notes.index');
    }

    public function show(Notes $note)
    {
        return view('notes.show', [
            'note' => $note,
        ]);
    }

    public function update(Request $request, Notes $note)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $note->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal_perubahan' => Carbon::now(),
        ]);

        return redirect()->route('notes.show', $note->id);
    }

    public function destroy(Notes $note)
    {
        $note->delete();

        return redirect()->route('notes.index');
    }
}
