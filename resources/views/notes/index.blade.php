<!DOCTYPE html>
<html>
<head>
    <title>notesva - All notes</title>
</head>
<body>

    <h1>Daftar notes</h1>

    <!-- Summary -->
    @if(isset($summary))
        <h3>Ringkasan Semua Catatan:</h3>
        <p>{{ $summary }}</p>
        <hr>
    @endif


    <!-- Form tambah notes -->
    <h2>Tambah notes Baru</h2>
    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <input type="text" name="judul" placeholder="Judul" required> <br><br>
        <textarea name="deskripsi" placeholder="Deskripsi..." required></textarea><br><br>
        <button type="submit">Simpan</button>
    </form>

    <hr>

    <!-- List semua notes -->
    <h2>Semua Catatan</h2>

    @foreach ($notes as $notes)
        <div style="margin-bottom: 20px;">
            <h3>{{ $notes->judul }}</h3>
            <p>{{ Str::limit($notes->deskripsi, 100) }}</p>
            <a href="{{ route('notes.show', $notes->id) }}">Lihat Detail</a>
        </div>
    @endforeach

</body>
</html>
