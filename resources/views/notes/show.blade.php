<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Catatan</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<header class="navbar">
    <h1>Edit Catatan</h1>
</header>

<main class="container">

    <!-- Form Update -->
    <form action="{{ route('notes.update', $note->id) }}" method="POST" class="note-form">
        @csrf
        @method('PUT')
        
        <label>Judul</label>
        <input type="text" name="judul" value="{{ $note->judul }}" readonly>

        <label>Deskripsi</label>
        <textarea name="deskripsi" readonly>{{ $note->deskripsi }}</textarea>

        @if($note->tanggal_perubahan)
            <p style="color: #fff; font-size: 0.9rem; margin-bottom: 10px;">
                Terakhir diubah: {{ \Carbon\Carbon::parse($note->tanggal_perubahan)->format('d M Y H:i') }}
            </p>
        @endif
        
        <div class="form-buttons">
            <a href="{{ route('notes.index') }}" class="btn-back">← Kembali</a>
            <div class="buttons-right">
                
                <form action="{{ route('notes.edit', $note->id) }}" method="POST" class="inline-form">
                    @csrf
                    @method('PUT')
                    <a href="{{ route('notes.edit', $note->id) }}" class="btn-edit">edit</a>
                </form>
            </div>
        </div>


    


</main>


</body>
</html>
