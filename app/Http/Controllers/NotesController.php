<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotesController extends Controller
{
    public function index()
{
    // 1. Ambil semua notes (sesuai kode aslimu)
    $notes = Notes::orderBy('is_pinned', 'DESC')
        ->orderBy('updated_at', 'DESC')
        ->get();

    // 2. Filter dari hasil di atas untuk mendapatkan yang di-pin saja
    // (Kita pakai filter collection supaya tidak query database 2 kali)
    $pinnedNotes = $notes->where('is_pinned', 1);

    // 3. Kirim KEDUA variabel ke view
    return view('notes.index', compact('notes', 'pinnedNotes'));
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

    public function destroy($id)
    {
        $note = Notes::findOrFail($id);
        $note->delete();

        // Pastikan pakai ->with('success', 'Pesan...')
        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus.');
    }

    public function edit(Notes $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function togglePin($id)
{
    $note = Notes::findOrFail($id);

    // Toggle status (jika 1 jadi 0, jika 0 jadi 1)
    $note->is_pinned = !$note->is_pinned;
    $note->save();

    // Tentukan pesan notifikasi
    $message = $note->is_pinned ? 'Catatan berhasil disematkan!' : 'Sematkan catatan dilepas!';

    // Redirect kembali ke halaman sebelumnya dengan pesan sukses
    // Ini akan memicu SweetAlert yang sudah ada di index.blade.php kamu
    return redirect()->back()->with('success', $message);
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