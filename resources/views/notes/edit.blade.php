<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catatan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="navbar">
    <h1>Edit Catatan</h1>
</header>

<main class="container">

    <form action="{{ route('notes.update', $note->id) }}" method="POST" class="note-form">
        @csrf
        @method('PUT')

        <label>Judul</label>
        <input type="text" name="judul" value="{{ $note->judul }}" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" required>{{ $note->deskripsi }}</textarea>

        <button type="submit" class="btn-save">Simpan Perubahan</button>
    </form>

    <a href="{{ route('notes.index') }}" class="btn-back">← Kembali</a>
</main>

</body>
</html>
