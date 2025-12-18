document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".match-card");
    const prev = document.querySelector(".match-arrow.prev");
    const next = document.querySelector(".match-arrow.next");

    if (!cards.length || !prev || !next) return;

    let index = 0;

    function render() {
        cards.forEach(card => card.classList.remove("active"));
        cards[index].classList.add("active");
    }

    next.addEventListener("click", () => {
        index = (index + 1) % cards.length;
        render();
    });

    prev.addEventListener("click", () => {
        index = (index - 1 + cards.length) % cards.length;
        render();
    });

    render();
});