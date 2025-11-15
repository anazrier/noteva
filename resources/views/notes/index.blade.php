<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noteva - Catatan Saya</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="navbar">
        <h1>NOTEVA</h1>
    </header>

    <main class="container">
        <div class="note-list">
            <h2>Catatan Tersimpan</h2>

            @if (count($notes) > 0)
                @foreach ($notes as $note)
                    <div class="note-item">
                        <h3>{{ $note->judul }}</h3>
                        <p id="note-desc-{{ $note->id }}">{{ Str::limit($note->deskripsi, 150, '...') }}</p>
                        <div class="note-actions">
                            <a href="{{ route('notes.show', $note->id) }}" class="btn-edit">Detail</a>
                            <button class="btn-summarize" data-id="{{ $note->id }}">Summarize AI</button>
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

    <!-- Modal AI Summary -->
    <div id="aiModal" class="modal" style="display:none;
            position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(0, 0, 0, 0.7); justify-content:center; align-items:center; z-index:9999;">
        <div style="background:#fff; padding:30px; border-radius:10px; width:90%; max-width:600px; max-height:80vh; overflow-y:auto; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
            <h3 style="margin-top:0; color:#333; font-weight:600;">Ringkasan AI</h3>
            <pre id="aiResult" style="white-space: pre-wrap; word-wrap: break-word; background:#f5f5f5; padding:15px; border-radius:5px; color:#333; font-family: 'Poppins', sans-serif; line-height:1.6; font-size:14px;">Memproses...</pre>
            <button onclick="closeModal()"
                    style="margin-top:15px; padding:10px 20px; background:#4CAF50; color:white; border:none; border-radius:5px; cursor:pointer; font-weight:600; transition: all 0.3s;">
                Tutup
            </button>
        </div>
    </div>

    <script src="{{ asset('js/ai.js') }}"></script>
</body>
</html>