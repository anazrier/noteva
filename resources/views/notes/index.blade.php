<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noteva - Catatan Saya</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<body>
    <header class="navbar">
        <h1>NOTEVA</h1>
    </header>

    <header class="navbar">
        <h1>NOTEVA</h1>
    </header>

    <main class="container">
        <div class="note-list">
            <h2>Catatan Tersimpan</h2>

            @if (count($notes) > 0)
                @foreach ($notes as $note)
                    <div class="note-item">
                        <h3>{{ $note['judul'] }}</h3>

                        
                        <p>{{ Str::limit($note->deskripsi, 150, '...') }}</p>
                        <div class="note-actions">
                            <!-- Tombol Edit -->
                            <a href="{{ route('notes.show', $note->id) }}" class="btn-edit">Detail</a>
                            <button class="btn-summarize">Summarize AI</button>
                        </div>
                        
                    </div>
                @endforeach
            @else
                <p class="empty">Belum ada catatan yang tersimpan.</p>
            @endif
        </div>

    </main>
    <!-- Tombol tambah catatan -->
    <a href="/notes/create" class="btn-float">+</a>
</body>
</html>

