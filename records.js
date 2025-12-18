document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector(".records-track");
    if (!track) return;

    const cards = track.querySelectorAll(".record-card");

    let position = 0;
    const speed = 0.5;

    function animate() {
        position -= speed;
        track.style.transform = `translateX(${position}px)`;

        const centerX = window.innerWidth / 2;

        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const cardCenter = rect.left + rect.width / 2;
            const distance = Math.abs(centerX - cardCenter);

            if (distance < rect.width / 2) {
                card.classList.add("is-center");
            } else {
                card.classList.remove("is-center");
            }
        });

        if (Math.abs(position) > track.scrollWidth / 2) {
            position = 0;
        }

        requestAnimationFrame(animate);
    }

    animate();
});