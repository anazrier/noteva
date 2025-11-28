<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotesController extends Controller
{
    public function index()
    {

        $notes = Notes::orderBy('is_pinned', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();


        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
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


        return redirect()->route('notes.index')->with('success', 'Perubahan berhasil disimpan!');
        // return redirect()->back()->with('success', 'To Do List berhasil digenerate!');
    }

    public function destroy(Notes $note)
    {
        $note->delete();

        return redirect()->route('notes.index');
    }

    public function edit(Notes $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function togglePin($id)
    {
        $note = Notes::findOrFail($id);

        // toggle
        $note->is_pinned = !$note->is_pinned;
        $note->save();

        return response()->json([
            'message' => $note->is_pinned 
                ? 'Catatan berhasil di-pin!' 
                : 'Catatan di-unpin!'
        ]);
    }
    public function search(Request $request)
    {
        $keyword = $request->q;

        if (empty($keyword)) {
            return response()->json([]);
        }

        $notes = Notes::where('judul', 'LIKE', "%$keyword%")
            ->orWhere('deskripsi', 'LIKE', "%$keyword%")
            ->orderBy('is_pinned', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();

        return response()->json($notes);
    }


}