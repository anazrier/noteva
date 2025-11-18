<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Catatan Baru</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <header class="navbar">
        <h1>Buat Catatan Baru</h1>
    </header>

    <main class="container">
        <form method="POST" action="{{ route('notes.store') }}" class="note-form" id="formSave">
            @csrf

            <label>Judul</label>
            <input type="text" name="judul" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" required></textarea>
            
            <div class="form-buttons">
                <a href="{{ route('notes.index') }}" class="btn-back">← Kembali</a>
                <button type="button" class="btn-save" id="simpan">Simpan</button>
            </div>
        </form>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('simpan').addEventListener('click', function () {

    Swal.fire({
        title: "Simpan catatan ini?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Simpan",
        denyButtonText: `Jangan Simpan`
    }).then((result) => {

        if (result.isConfirmed) {
            Swal.fire("Tersimpan!", "", "success");
            document.getElementById('formSave').submit();

        } else if (result.isDenied) {
            Swal.fire("Perubahan tidak disimpan", "", "info");
        }

    });

});
</script>

</body>
</html>
