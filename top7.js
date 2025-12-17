document.addEventListener("DOMContentLoaded", () => {
    const rows = document.querySelectorAll(".top7-row");
    const img = document.querySelector("#team-logo-img");
    const title = document.querySelector(".top7-content h2");
    const info = document.querySelector(".top7-content p");

    const prevBtn = document.querySelector(".arrow.prev");
    const nextBtn = document.querySelector(".arrow.next");

    if (!rows.length) return;

    let current = 0;

    const teams = Array.from(rows).map(row => ({
        name: row.querySelector("p").innerText,
        position: row.querySelector("span").innerText,
        logo: row.dataset.logo,
        points: row.dataset.points
    }));

    function render(index) {
        rows.forEach(r => r.classList.remove("active"));
        rows[index].classList.add("active");

        img.style.opacity = 0;

        setTimeout(() => {
            img.src = "/team-logo/" + teams[index].logo;
            title.innerText = teams[index].name;
            info.innerText = `${teams[index].position} место · ${teams[index].points} очков`;
            img.style.opacity = 1;
        }, 150);
    }

    nextBtn.addEventListener("click", () => {
        current = (current + 1) % teams.length;
        render(current);
    });

    prevBtn.addEventListener("click", () => {
        current = (current - 1 + teams.length) % teams.length;
        render(current);
    });

    render(current);
});