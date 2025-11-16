document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll(".btn-summarize");

    buttons.forEach(btn => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            const desc = document.getElementById("note-desc-" + id).innerText;

            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const response = await fetch("/summarize", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrf
                    },
                    body: JSON.stringify({ text: desc })
                });

                const result = await response.json();

                if (result.error) {
                    alert("API ERROR:\n" + result.message);
                } else {
                    alert("HASIL RINGKASAN:\n" + result.summary);
                }

            } catch (err) {
                alert("JS ERROR: " + err.message);
            }
        });
    });
});
