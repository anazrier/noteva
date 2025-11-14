<!DOCTYPE html>
<html>
<head>
    <title>Detail notes</title>
</head>
<body>

    <a href="{{ route('notes.index') }}">← Kembali</a>

    <h1>{{ $note->judul }}</h1>
    <p>{{ $note->deskripsi }}</p>
    <p><small>Terakhir diubah: {{ $note->tanggal_perubahan }}</small></p>

    <hr>

    <!-- Edit form -->
    <h2>Edit Note</h2>
    <form action="{{ route('notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="judul" value="{{ $note->judul }}" required> <br><br>
        <textarea name="deskripsi" required>{{ $note->deskripsi }}</textarea><br><br>

        <button type="submit">Update</button>
    </form>

    <hr>

    <!-- Delete -->
    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
        @csrf
        @method('DELETE')

        <button type="submit" style="color: red;">Hapus</button>
    </form>

</body>
</html>
