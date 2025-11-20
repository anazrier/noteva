
function openModal() {
    const modal = document.getElementById("aiModal");
    modal.style.display = "flex"; // tampilkan modal (flex karena CSS)
}

function closeModal() {
    const modal = document.getElementById("aiModal");
    modal.style.display = "none"; // sembunyikan modal
}

// Fungsi utama Summarize AI

document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".btn-summarize");

@@ -8,6 +23,10 @@ document.addEventListener("DOMContentLoaded", () => {

            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            // Tampilkan modal dengan tulisan "Memproses..."
            openModal();
            document.getElementById("aiResult").innerText = "Memproses...";

            try {
                const response = await fetch("/summarize", {
                    method: "POST",
@@ -21,13 +40,13 @@ document.addEventListener("DOMContentLoaded", () => {
                const result = await response.json();

                if (result.error) {
                     document.getElementById("aiResult").innerText = "API ERROR:\n" + result.message;
                } else {
                     document.getElementById("aiResult").innerText = result.summary;
                }
            } catch (err) {
                document.getElementById("aiResult").innerText = "JS ERROR: " + err.message;
            }
        });
    });