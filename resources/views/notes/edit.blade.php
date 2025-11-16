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
        <input type="text" name="judul" value="{{ $note->judul }}" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" required>{{ $note->deskripsi }}</textarea>

        @if($note->tanggal_perubahan)
            <p style="color: #fff; font-size: 0.9rem; margin-bottom: 10px;">
                Terakhir diubah: {{ \Carbon\Carbon::parse($note->tanggal_perubahan)->format('d M Y H:i') }}
            </p>
        @endif
        
        <div class="form-buttons">
            <a href="{{ route('notes.index') }}" class="btn-back">← Kembali</a>
            <div class="buttons-right">
                
                <form action="{{ route('notes.update', $note->id) }}" method="POST" class="inline-form">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </form>
                <form action="{{ route('notes.destroy', $note->id) }}" method="POST" id="formHapus">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn-delete" id="btnHapus">Hapus</button>
                </form>

                
            </div>
        </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>


<script>
document.getElementById('btnHapus').addEventListener('click', function () {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data ini tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formHapus').submit();
        }
    });
});
</script>




</body>
</html>
