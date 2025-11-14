<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Catatan Baru</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header class="navbar">
        <h1>Buat Catatan Baru</h1>
    </header>

    <main class="container">
        <form method="POST" action="{{ route('notes.store') }}" class="note-form">
            @csrf

            <label>Judul</label>
            <input type="text" name="judul" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required></textarea>

            <button type="submit" class="btn-save">Simpan</button>
        </form>

        <a href="{{ route('notes.index') }}" class="btn-back">← Kembali</a>
    </main>

</body>
</html>
