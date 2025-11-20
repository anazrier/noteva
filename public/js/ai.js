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

// ============================
// Fungsi utama Summarize AI
// ============================
document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".btn-summarize");

    buttons.forEach((btn) => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            const desc = document.getElementById("note-desc-" + id).innerText;
            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            // Tampilkan modal dengan tulisan "Memproses..."
            openModal();
            document.getElementById("aiResult").innerText = "Memproses...";

            try {
                // FIX: Ubah URL jadi /notes/{id}/summarize
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
                        "API ERROR:\n" + result.message;
                } else {
                    document.getElementById("aiResult").innerText =
                        result.summary;
                }
            } catch (err) {
                document.getElementById("aiResult").innerText =
                    "JS ERROR: " + err.message;
            }
        });
    });
});