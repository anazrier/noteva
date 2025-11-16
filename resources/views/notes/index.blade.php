<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noteva - Catatan Saya</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>

</head>

<body>
    @yield('content')
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
    <div id="aiModal" class="modal">
        <div class="modal-content">
            <h3>Ringkasan AI</h3>
            <pre id="aiResult">Memproses...</pre>

            <button class="modal-close" onclick="closeModal()">Tutup</button>
        </div>
    </div>

    <script src="{{ asset('js/ai.js') }}"></script>


    
    @stack('scripts')

    @if(session('success'))
<script>
Swal.fire({
    title: "{{ session('success') }}",
    icon: "success",
    draggable: true
});
</script>
@endif
</body>
</html>