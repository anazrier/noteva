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

        @foreach ($notes as $note)
            <div class="note-item">
                <h3>{{ $note->judul }}</h3>
                <p id="note-desc-{{ $note->id }}">{{ $note->deskripsi }}</p>

<button class="btn-summarize" data-id="{{ $note->id }}">
    Summarize AI
</button>

                </div>
            </div>
        @endforeach
    </div>
</main>

<a href="/notes/create" class="btn-float">+</a>

<!-- Modal -->
<div id="aiModal" class="modal" style="display:none;
        position:fixed; top:0; left:0; width:100%; height:100%;
        background:rgba(169, 23, 23, 0.5); justify-content:center; align-items:center;">

    <div style="background:rgb(20, 4, 4); padding:20px; border-radius:10px; width:90%; max-width:500px;">
        <h3>Ringkasan AI</h3>
        <pre id="aiResult">Memproses...</pre>
        <button onclick="closeModal()"
                style="margin-top:10px; padding:7px 15px; background:#333; color:white; border:none; border-radius:5px;">
            Tutup
        </button>
    </div>
</div>

<script src="{{ asset('js/ai.js') }}"></script>

</body>
</html>
