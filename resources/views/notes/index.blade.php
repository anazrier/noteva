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
    <script src="{{ asset('js/search.js') }}"></script>

    
</head>

<body>
        <nav class="navbar">
    <h1>NOTEVA</h1>

    <div class="navbar-flex">
        <input type="text" id="searchInput" placeholder="🔍 Cari catatan..." class="search-box">
        <button class="btn-pin" onclick="openPinModal()">📌 Pin</button>
    </div>
</nav>



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
                            <button class="btn-summarize" data-id="{{ $note->id }}">📝 Summarize</button>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="empty">Belum ada catatan yang tersimpan.</p>
            @endif
        </div>
    </main>
    
    <!-- Modal AI Summary -->
    <div id="aiModal" class="modal" style="display:none;">
        <div class="modal-content">
            <!-- Header Modal dengan Close Button -->
            <div class="modal-header">
                <h3 id="aiModalTitle">📝 Ringkasan AI</h3>
                <button class="modal-close-icon" onclick="closeModal()" title="Tutup">×</button>
            </div>
            
            <!-- Body Modal (Area Hasil AI) -->
            <div class="modal-body">
                <div id="aiResultContainer" class="result-container">
                    <pre id="aiResult">Memproses...</pre>
                </div>
            </div>
            
            <!-- Footer Modal dengan Tombol Action -->
            <div class="modal-footer">
                <button class="btn-modal-close" onclick="closeModal()">
                    <span>✓</span> Tutup
                </button>
            </div>
        </div>
    </div>
    <!-- Tombol tambah catatan -->
    <a href="/notes/create" class="btn-float">+</a>


    <div id="pinModal" class="modal" style="display:none;">
    <div class="modal-content">
        <h3>Pilih Catatan untuk di-PIN</h3>

        @foreach ($notes as $note)
            <div class="pin-item">
                <span>{{ $note->judul }}</span>
                <button onclick="pinNote({{ $note->id }})" 
                        class="btn-pin-action">
                    {{ $note->is_pinned ? 'Unpin' : 'Pin' }}
                </button>
            </div>
        @endforeach

        <button class="btn-close" onclick="closePinModal()">Tutup</button>
    </div>
</div>


    <script src="{{ asset('js/ai.js') }}"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: "{{ session('success') }}",
            icon: "success",
            draggable: true
        });
    </script>
    @endif

    <script>
    function openPinModal() {
        document.getElementById('pinModal').style.display = 'block';
    }

    function closePinModal() {
        document.getElementById('pinModal').style.display = 'none';
    }

    function pinNote(id) {
        fetch(`/notes/${id}/pin`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                title: "Berhasil!",
                text: data.message,
                icon: "success"
            }).then(() => {
                location.reload();
            });
        });
    }
    </script>


</body>
</html>