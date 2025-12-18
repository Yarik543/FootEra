document.addEventListener("DOMContentLoaded", () => {
    const track = document.querySelector(".records-track");
    const cards = document.querySelectorAll(".record-card");
    const viewport = document.querySelector(".records-viewport");

    if (!track || !cards.length || !viewport) return;

    let position = 0;
    const speed = 0.75;

    function animate() {
        position -= speed;
        track.style.transform = `translateX(${position}px)`;

        const trackWidth = track.scrollWidth / 2;

        // бесконечность без скачка
        if (Math.abs(position) >= trackWidth) {
            position = 0;
        }

        // центрирование
        const viewportRect = viewport.getBoundingClientRect();
        const centerX = viewportRect.left + viewportRect.width / 2;

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

        requestAnimationFrame(animate);
    }

    animate();
});