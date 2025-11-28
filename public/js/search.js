document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchInput");

    searchInput.addEventListener("input", () => {
        const keyword = searchInput.value.trim();
        fetchNotes(keyword);
    });
});

function fetchNotes(keyword) {
    if (keyword === "") {
        document.querySelector(".note-list").innerHTML = "";
        return;
    }

    fetch(`/search?q=${encodeURIComponent(keyword)}`)
        .then(res => res.json())
        .then(data => {
            renderNotes(data);
        })
        .catch(err => console.error("Search Error:", err));
}

function renderNotes(notes) {
    const list = document.querySelector(".note-list");
    list.innerHTML = "";

    if (notes.length === 0) {
        list.innerHTML = `
            <div class="no-result">Tidak ada hasil ditemukan.</div>
        `;
        return;
    }

    notes.forEach(note => {
        list.innerHTML += `
            <div class="note-item">
                <h3>${note.judul}</h3>
                <p>${note.deskripsi}</p>
            </div>
        `;
    });
}
