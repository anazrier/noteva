<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <label for="title">Judul Catatan</label>
                    <input type="text" id="title" name="title" placeholder="Masukkan judul catatan..." required>
                </div>

                <div class="form-group">
                    <label for="note">Isi Catatan</label>
                    <textarea id="note" name="note" placeholder="Tulis isi catatanmu di sini..." required></textarea>
                </div>

                <div class="form-buttons">
                    <a href="/notes" class="btn-back">Kembali</a>
                    <button type="submit" class="btn-save">Simpan Catatan</button>
                </div>

            </form>
        </div>
    </main>
</body>
</html>
