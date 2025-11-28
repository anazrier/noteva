// ============================
// DROPDOWN MENU - Toggle Show/Hide
// ============================

function toggleDropdown() {
    console.log("Dropdown toggled");
    const dropdown = document.getElementById("dropdownMenu");
    dropdown.classList.toggle("show");
}

// ============================
// TUTUP DROPDOWN - Klik di luar
// ============================

window.onclick = function(event) {
    // Kalau yang diklik BUKAN button dropdown
    if (!event.target.matches('.btn-dropdown')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        
        // Loop semua dropdown dan tutup yang terbuka
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

// ============================
// REWRITE - Perbaiki Bahasa
// ============================

function rewriteNote(noteId) {
    console.log("Rewrite note:", noteId);
    
    // Ambil deskripsi dari elemen HTML
    const desc = document.getElementById("note-desc-" + noteId).innerText;
    
    // Ambil CSRF token
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    console.log("Deskripsi:", desc);

    // Tutup dropdown
    document.getElementById("dropdownMenu").classList.remove("show");

    // Tampilkan modal dengan loading text
    openModal();
    document.getElementById("aiModalTitle").innerText = "✏️ Perbaikan Bahasa AI";
    document.getElementById("aiResult").innerText = "Sedang memperbaiki bahasa...";

    // Kirim request ke backend
    fetch(`/notes/${noteId}/rewrite`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf,
        },
        body: JSON.stringify({ text: desc })
    })
    .then(response => {
        console.log("Response status:", response.status);
        return response.json();
    })
    .then(data => {
        console.log("Rewrite response:", data);
        
        // Tampilkan hasil di modal
        if (data.error) {
            document.getElementById("aiResult").innerText = "❌ ERROR:\n" + data.message;
        } else {
            document.getElementById("aiResult").innerText = data.rewritten;
        }
    })
    .catch(error => {
        console.error("Rewrite error:", error);
        document.getElementById("aiResult").innerText = "⚠️ KESALAHAN: " + error.message;
    });
}

// ============================
// EXPAND - Kembangkan Catatan
// ============================

function expandNote(noteId) {
    console.log("Expand note:", noteId);
    
    // Ambil deskripsi dari elemen HTML
    const desc = document.getElementById("note-desc-" + noteId).innerText;
    
    // Ambil CSRF token
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    console.log("Deskripsi:", desc);

    // Tutup dropdown
    document.getElementById("dropdownMenu").classList.remove("show");

    // Tampilkan modal dengan loading text
    openModal();
    document.getElementById("aiModalTitle").innerText = "📖 Pengembangan Catatan AI";
    document.getElementById("aiResult").innerText = "Sedang mengembangkan catatan...";

    // Kirim request ke backend
    fetch(`/notes/${noteId}/expand`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrf,
        },
        body: JSON.stringify({ text: desc })
    })
    .then(response => {
        console.log("Response status:", response.status);
        return response.json();
    })
    .then(data => {
        console.log("Expand response:", data);
        
        // Tampilkan hasil di modal
        if (data.error) {
            document.getElementById("aiResult").innerText = "❌ ERROR:\n" + data.message;
        } else {
            document.getElementById("aiResult").innerText = data.expanded;
        }
    })
    .catch(error => {
        console.error("Expand error:", error);
        document.getElementById("aiResult").innerText = "⚠️ KESALAHAN: " + error.message;
    });
}