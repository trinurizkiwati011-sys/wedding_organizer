<?php

include "config/koneksi.php";

$judul = "Galeri - Luxora Organizer";

include "includes/header.php";
include "includes/navbar.php";


// ==================================================
// AMBIL DATA GALERI
// ==================================================

$query_galeri = mysqli_query(
    $koneksi,
    "SELECT *
     FROM galeri
     ORDER BY id_galeri DESC"
);

?>

<!-- ==================================================
     HERO
================================================== -->

<section
    class="hero"
    style="
        min-height:500px;
        background-position:center;
    "
>

    <div class="container">

        <div class="hero-content fade-left">

            <p>
                LUXORA MOMENTS
            </p>

            <h1>
                Our Gallery
            </h1>

            <p>
                A collection of beautiful moments
                created with love.
            </p>

        </div>

    </div>

</section>


<!-- ==================================================
     GALERI
================================================== -->

<section class="section">

    <div class="container">

        <div class="section-title fade-up">

            <p
                style="
                    color:#b88980;
                    letter-spacing:3px;
                "
            >
                LITTLE MOMENTS
            </p>

            <h2>
                Beautiful Memories
            </h2>

            <p>
                Lihat berbagai momen indah dari
                pernikahan yang telah kami bantu
                wujudkan bersama pasangan.
            </p>

        </div>


        <!-- ==================================================
             GRID GALERI
        ================================================== -->

        <div class="galeri-grid">

            <?php if (mysqli_num_rows($query_galeri) > 0): ?>

                <?php

                $delay = 0.1;

                while (
                    $galeri = mysqli_fetch_assoc(
                        $query_galeri
                    )
                ):

                ?>

                    <div
                        class="galeri-item zoom-in"
                        style="
                            transition-delay:
                            <?php echo $delay; ?>s;
                        "
                        onclick="openLightbox(
                            'assets/images/<?php
                                echo htmlspecialchars(
                                    $galeri['gambar']
                                );
                            ?>',
                            '<?php
                                echo htmlspecialchars(
                                    $galeri['judul']
                                );
                            ?>'
                        )"
                    >

                        <img
                            src="assets/images/<?php
                                echo htmlspecialchars(
                                    $galeri['gambar']
                                );
                            ?>"
                            alt="<?php
                                echo htmlspecialchars(
                                    $galeri['judul']
                                );
                            ?>"
                        >


                        <!-- OVERLAY -->

                        <div class="galeri-overlay">

                            <div>

                                <span
                                    style="
                                        font-size:28px;
                                    "
                                >
                                    +
                                </span>

                                <h3>
                                    <?php

                                    echo htmlspecialchars(
                                        $galeri['judul']
                                    );

                                    ?>
                                </h3>

                            </div>

                        </div>

                    </div>


                    <?php

                    $delay += 0.1;

                    if ($delay > 0.8) {
                        $delay = 0.1;
                    }

                    ?>

                <?php endwhile; ?>


            <?php else: ?>

                <div class="empty-data">

                    <h3>
                        Galeri Belum Tersedia
                    </h3>

                    <p>
                        Saat ini belum ada foto
                        yang dapat ditampilkan.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>


<!-- ==================================================
     LIGHTBOX
================================================== -->

<div
    id="lightbox"
    class="lightbox"
    onclick="closeLightbox()"
>

    <button
        type="button"
        class="lightbox-close"
        onclick="closeLightbox()"
    >
        ×
    </button>


    <div
        class="lightbox-content"
        onclick="event.stopPropagation()"
    >

        <img
            id="lightbox-image"
            src=""
            alt=""
        >

        <h3 id="lightbox-title"></h3>

    </div>

</div>


<!-- ==================================================
     CTA
================================================== -->

<section
    class="section"
    style="
        background:#ead8d0;
    "
>

    <div class="container">

        <div
            class="contact-box fade-up"
            style="
                text-align:center;
            "
        >

            <p
                style="
                    color:#b88980;
                    letter-spacing:3px;
                "
            >
                YOUR STORY STARTS HERE
            </p>

            <h2>
                Let's Create Your Memories
            </h2>

            <p>
                Setiap pernikahan memiliki cerita
                yang berbeda. Biarkan Luxora membantu
                menciptakan cerita indah Anda.
            </p>

            <br>

            <a
                href="kontak.php"
                class="btn-detail"
            >
                Konsultasi Sekarang
            </a>

        </div>

    </div>

</section>


<!-- ==================================================
     JAVASCRIPT LIGHTBOX
================================================== -->

<script>

function openLightbox(image, title) {

    const lightbox =
        document.getElementById("lightbox");

    const lightboxImage =
        document.getElementById("lightbox-image");

    const lightboxTitle =
        document.getElementById("lightbox-title");


    lightboxImage.src = image;

    lightboxImage.alt = title;

    lightboxTitle.textContent = title;

    lightbox.classList.add("active");

    document.body.style.overflow = "hidden";

}


function closeLightbox() {

    const lightbox =
        document.getElementById("lightbox");

    lightbox.classList.remove("active");

    document.body.style.overflow = "";

}


document.addEventListener(
    "keydown",
    function(event) {

        if (event.key === "Escape") {

            closeLightbox();

        }

    }
);

</script>


<?php

include "includes/footer.php";

?>