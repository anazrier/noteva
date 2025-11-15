<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
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

=======
    <title>Buat Catatan Baru - Noteva</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <h1>NOTEVA</h1>
    </header>

    <main class="container">
        <div class="note-form">
            <h2 style="text-align:center; color:#1e293b; margin-bottom: 20px;">Buat Catatan Baru</h2>

            <form action="/notes" method="POST">
                @csrf
                <div class="form-group">
                    <label for="judul">Judul Catatan</label>
                    <input type="text" id="judul" name="judul" placeholder="Masukkan judul catatan..." required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Isi Catatan</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Tulis isi catatanmu di sini..." required></textarea>
                </div>

                <div class="form-buttons">
                    <a href="/notes" class="btn-back">Kembali</a>
                    <button type="submit" class="btn-save">Simpan Catatan</button>
                </div>

            </form>
        </div>
    </main>
>>>>>>> 07091260ff41b38eeddc8ef7e113e89c9bbddfbf
</body>
</html>
