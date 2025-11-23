// ============================
// Fungsi buka & tutup modal
// ============================
function openModal() {
    const modal = document.getElementById("aiModal");
    modal.style.display = "flex";
}

function closeModal() {
    const modal = document.getElementById("aiModal");
    modal.style.display = "none";
}

// Tutup modal kalau klik overlay (area gelap di luar modal)
function closeModalOnOverlay(event) {
    const modal = document.getElementById("aiModal");
    if (event.target === modal) {
        closeModal();
    }
}

// ============================
// AI SUMMARIZE - Ringkas
// ============================
document.addEventListener("DOMContentLoaded", () => {
    const summarizeButtons = document.querySelectorAll(".btn-summarize");

    summarizeButtons.forEach((btn) => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            const desc = document.getElementById("note-desc-" + id).innerText;
            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            // Tampilkan modal & update title
            openModal();
            document.getElementById("aiModalTitle").innerText = "📝 Ringkasan AI";
            document.getElementById("aiResult").innerText = "Sedang meringkas...";

            try {
                const response = await fetch(`/notes/${id}/summarize`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf,
                    },
                    body: JSON.stringify({ text: desc })
                });

                const result = await response.json();

                if (result.error) {
                    document.getElementById("aiResult").innerText =
                        "❌ ERROR:\n" + result.message;
                } else {
                    document.getElementById("aiResult").innerText = result.summary;
                }
            } catch (err) {
                document.getElementById("aiResult").innerText =
                    "⚠️ KESALAHAN: " + err.message;
            }
        });
    });
});