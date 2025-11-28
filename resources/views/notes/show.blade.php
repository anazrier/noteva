<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $note->judul }} - Noteva</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <header class="navbar">
        <h1>Detail Catatan</h1>
    </header>

    <main class="container">

        <div class="note-form">
            <label>Judul</label>
            <input type="text" value="{{ $note->judul }}" readonly>

            <label>Deskripsi</label>
            <div class="note-description" id="note-desc-{{ $note->id }}">{{ $note->deskripsi }}</div>

            @if ($note->tanggal_perubahan)
                <p style="color: #fff; font-size: 0.9rem; margin-bottom: 10px;">
                    Terakhir diubah: {{ \Carbon\Carbon::parse($note->tanggal_perubahan)->format('d M Y H:i') }}
                </p>
            @endif

            <!-- DROPDOWN AI FEATURES (Rewrite & Expand) -->
            <div class="ai-dropdown">
                <button class="btn-dropdown" onclick="toggleDropdown()">
                    ⋮ AI Features
                </button>
                <div id="dropdownMenu" class="dropdown-content">
                    <button class="dropdown-item" onclick="rewriteNote({{ $note->id }})">
                        ✏️ Rewrite
                    </button>
                    <button class="dropdown-item" onclick="expandNote({{ $note->id }})">
                        📖 Expand
                    </button>
                </div>
            </div>

            <!-- Tombol Generate To-Do -->
            <button type="button"
                class="btn-generate"
                onclick="generateTodoList({{ $note->id }})">
            <button type="button" class="btn-edit" onclick="generateTodoList({{ $note->id }})" style="width: 100%; margin: 10px 0;">
                ✅ Generate To-Do List
            </button>

            <!-- To-Do List Container -->
            <div id="todoListContainer" style="display: {{ $note->todo_list ? 'block' : 'none' }}">
                <div class="todo-list-container">
                    <h3 class="todo-list-title">📋 To-Do List</h3>
                    <div id="todoItems">
                        @if ($note->todo_list)
                            @php
                                $todos = json_decode($note->todo_list, true);
                            @endphp
                            @foreach ($todos as $index => $todo)
                                <div class="todo-item {{ $todo['completed'] ? 'completed' : '' }}" data-index="{{ $index }}">
                                    <input type="checkbox" class="todo-checkbox" {{ $todo['completed'] ? 'checked' : '' }}
                                        onchange="updateTodoStatus({{ $note->id }}, {{ $index }}, this.checked, this)">
                                    <span class="todo-text">{{ $todo['text'] }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-buttons">
                <a href="{{ route('notes.index') }}" class="btn-back">← Kembali</a>
                <div class="buttons-right">
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn-edit">✏️ Edit</a>
                    
                    <form id="deleteForm" action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-delete" onclick="confirmDelete()">🗑️ Hapus</button>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <!-- MODAL AI (UPDATED) -->
    <div id="aiModal" class="modal" onclick="closeModalOnOverlay(event)">
        <div class="modal-content">
            <!-- Header Modal dengan Close Button -->
            <div class="modal-header">
                <h3 id="aiModalTitle">✨ AI Features</h3>
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

    <!-- JavaScript -->
    <script src="{{ asset('js/ai.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <script src="{{ asset('js/ai-features.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Catatan ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // Merah
                cancelButtonColor: '#3b82f6',  // Biru
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fff',
                color: '#333'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Ya, submit form via ID
                    document.getElementById('deleteForm').submit();
                }
            });
        }
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: "Berhasil!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK",
            confirmButtonColor: "#4F46E5"
        });
    </script>
    @endif

</body>

</html>