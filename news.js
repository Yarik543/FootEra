document.querySelectorAll(".news-btn").forEach(btn => {
    btn.addEventListener("click", () => {
        const card = btn.closest(".news-card");
        card.classList.toggle("open");

        btn.textContent = card.classList.contains("open")
            ? "Скрыть"
            : "Читать";
    });
});