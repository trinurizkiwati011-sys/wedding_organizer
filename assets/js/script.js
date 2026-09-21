// ==============================
// NAVBAR SCROLL
// ==============================

window.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar");

    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add("navbar-scroll");
        } else {
            navbar.classList.remove("navbar-scroll");
        }
    }
});


// ==============================
// KONFIRMASI LOGOUT
// ==============================

const logoutLinks = document.querySelectorAll(".logout-link");

logoutLinks.forEach(function (link) {
    link.addEventListener("click", function (event) {

        const yakin = confirm("Apakah kamu yakin ingin logout?");

        if (!yakin) {
            event.preventDefault();
        }

    });
});


// ==============================
// TOMBOL FAVORIT
// ==============================

const favoritButtons = document.querySelectorAll(".btn-favorit");

favoritButtons.forEach(function (button) {

    button.addEventListener("click", function () {

        const status = button.getAttribute("data-favorit");

        if (status === "true") {

            button.setAttribute("data-favorit", "false");
            button.innerHTML = "♡ Tambah Favorit";

        } else {

            button.setAttribute("data-favorit", "true");
            button.innerHTML = "♥ Favorit";

        }

    });

});


// ==============================
// KONFIRMASI HAPUS
// ==============================

const deleteButtons = document.querySelectorAll(".btn-hapus");

deleteButtons.forEach(function (button) {

    button.addEventListener("click", function (event) {

        const yakin = confirm(
            "Apakah kamu yakin ingin menghapus data ini?"
        );

        if (!yakin) {
            event.preventDefault();
        }

    });

});


// ==============================
// AUTO HIDE ALERT
// ==============================

setTimeout(function () {

    const alerts = document.querySelectorAll(".alert");

    alerts.forEach(function (alert) {

        alert.style.transition = "opacity 0.5s";
        alert.style.opacity = "0";

        setTimeout(function () {
            alert.remove();
        }, 500);

    });

}, 4000);


// ==============================
// GALERI LIGHTBOX SEDERHANA
// ==============================

const galleryImages = document.querySelectorAll(".galeri-item img");

galleryImages.forEach(function (image) {

    image.addEventListener("click", function () {

        const overlay = document.createElement("div");

        overlay.className = "gallery-overlay";

        overlay.innerHTML = `
            <div class="gallery-close">&times;</div>
            <img src="${image.src}" alt="${image.alt}">
        `;

        document.body.appendChild(overlay);

        const closeButton = overlay.querySelector(".gallery-close");

        closeButton.addEventListener("click", function () {
            overlay.remove();
        });

        overlay.addEventListener("click", function (event) {

            if (event.target === overlay) {
                overlay.remove();
            }

        });

    });

});

// ==================================================
// SCROLL ANIMATION
// ==================================================

const animatedElements = document.querySelectorAll(
    ".fade-up, .fade-left, .fade-right, .zoom-in"
);

const observer = new IntersectionObserver(
    function (entries) {

        entries.forEach(function (entry) {

            if (entry.isIntersecting) {

                entry.target.classList.add("show");

            }

        });

    },
    {
        threshold: 0.15
    }
);


animatedElements.forEach(function (element) {

    observer.observe(element);

});