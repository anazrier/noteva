<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>{{ $note->judul }} - Noteva</title>
    <meta name="csrf-token"
        content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="{{ asset('css/style.css') }}">

    <style>

    </style>
</head>

<body>

    <header class="navbar">
        <h1>Detail Catatan</h1>
    </header>

    <main class="container">

        <div class="note-form">
            <label>Judul</label>
            <input type="text"
                value="{{ $note->judul }}"
                readonly>

            <label>Deskripsi</label>
            <div class="note-description">{{ $note->deskripsi }}</div>

            @if ($note->tanggal_perubahan)
                <p style="color: #fff; font-size: 0.9rem; margin-bottom: 10px;">
                    Terakhir diubah: {{ \Carbon\Carbon::parse($note->tanggal_perubahan)->format('d M Y H:i') }}
                </p>
            @endif

            <!-- Tombol Generate To-Do -->
            <button type="button"
                class="btn-generate"
                onclick="generateTodoList({{ $note->id }})">
                ✅ Generate To-Do List
            </button>

            <!-- To-Do List Container -->
            <div id="todoListContainer"
                style="display: {{ $note->todo_list ? 'block' : 'none' }}">
                <div class="todo-list-container">
                    <h3 class="todo-list-title">📋 To-Do List</h3>
                    <div id="todoItems">
                        @if ($note->todo_list)
                            @php
                                $todos = json_decode($note->todo_list, true);
                            @endphp
                            @foreach ($todos as $index => $todo)
                                <div class="todo-item {{ $todo['completed'] ? 'completed' : '' }}"
                                    data-index="{{ $index }}">
                                    <input type="checkbox"
                                        class="todo-checkbox"
                                        {{ $todo['completed'] ? 'checked' : '' }}
                                        onchange="updateTodoStatus({{ $note->id }}, {{ $index }}, this.checked, this)">
                                    <span class="todo-text">{{ $todo['text'] }}</span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-buttons">
                <a href="{{ route('notes.index') }}"
                    class="btn-back">← Kembali</a>
               <form action="{{ route('notes.edit', $note->id) }}" method="POST" class="inline-form">
                    @csrf
                    @method('PUT')
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn-edit">edit</a>
                </form>
            </div>
        </div>

    </main>

    <!-- AI Features JS -->
    <script src="{{ asset('js/ai-features.js') }}"></script>

</body>

</html>