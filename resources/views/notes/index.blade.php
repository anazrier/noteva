<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noteva - Catatan Saya</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=123">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/search.js') }}"></script>

    
</head>

<body>
<nav class="navbar">
    <h1>NOTEVA</h1>

    <div class="nav-row">
        <input type="text" id="searchInput" placeholder="🔍 Cari catatan..." class="search-box">
        <button class="btn-pin" onclick="togglePinModal()">
            📌 Pin
        </button>
    </div>

</nav>



    <main class="container">
        <div class="note-list">
            <h2>Catatan Tersimpan</h2>

            @if (count($notes) > 0)
                @foreach ($notes as $note)
                    <div class="note-item" style="position: relative; overflow: hidden;">

                        @if($note->is_pinned)
                            <div style="
                                position: absolute;
                                top: 0;
                                right: 0;
                                background: linear-gradient(135deg, #3b82f6, #2563eb);
                                color: white;
                                padding: 6px 16px;
                                border-bottom-left-radius: 16px;
                                font-size: 12px;
                                font-weight: 600;
                                box-shadow: -2px 2px 8px rgba(0,0,0,0.15);
                                z-index: 10;
                            ">
                                📌
                            </div>
                        @endif

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

    <!-- MODAL AI (UPDATED - Sama dengan show.blade.php) -->
    <div id="aiModal" class="modal" onclick="closeModalOnOverlay(event)">
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

    <div id="modalPin" class="modal" style="display: none;">
    <div class="modal-content">
        
        <div class="modal-header">
            <h3>📌 Kelola Pin Catatan</h3>
            <button type="button" class="modal-close-icon" onclick="togglePinModal()">
                &times;
            </button>
        </div>

        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
            @foreach($notes as $note)
                <div class="pin-item" style="background: {{ $note->is_pinned ? 'linear-gradient(135deg, #3b82f6, #2563eb)' : 'rgba(0,0,0,0.05)' }}; border: 1px solid {{ $note->is_pinned ? 'transparent' : '#ddd' }};">
                    
                    <span style="color: {{ $note->is_pinned ? '#fff' : '#333' }}; font-weight: 500;">
                        {{ Str::limit($note->judul, 40) }}
                    </span>
                    
                    <form action="{{ route('notes.pin', $note->id) }}" method="POST" style="margin:0;">
                        @csrf
                        
                        @if($note->is_pinned)
                            <button type="submit" class="btn-pin-action" style="background: rgba(255,255,255,0.2); color: white;">
                                X Unpin
                            </button>
                        @else
                            <button type="submit" class="btn-pin-action" style="background: #3b82f6; color: white; border: none;">
                                Pin
                            </button>
                        @endif
                    </form>

                </div>
            @endforeach
            
            @if($notes->isEmpty())
                <p style="text-align: center; padding: 20px;">Belum ada catatan sama sekali.</p>
            @endif
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-modal-close" onclick="togglePinModal()">
                Selesai
            </button>
        </div>
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
        function togglePinModal() {
            const modal = document.getElementById('modalPin');
            
            // Cek status display saat ini
            if (modal.style.display === "none" || modal.style.display === "") {
                modal.style.display = "flex"; // Munculkan (flex agar ke tengah)
            } else {
                modal.style.display = "none"; // Sembunyikan
            }
        }

        // Menutup modal jika user klik di luar area konten (background gelap)
        window.onclick = function(event) {
            const modal = document.getElementById('modalPin');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>