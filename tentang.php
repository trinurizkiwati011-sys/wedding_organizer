<?php

include "config/koneksi.php";

$judul = "Tentang Kami - Luxora Organizer";

include "includes/header.php";
include "includes/navbar.php";


// ==========================================
// AMBIL DATA PENGATURAN
// ==========================================

$query_pengaturan = mysqli_query(
    $koneksi,
    "SELECT * FROM pengaturan
     ORDER BY id_pengaturan ASC
     LIMIT 1"
);

$pengaturan = mysqli_fetch_assoc($query_pengaturan);


// ==========================================
// DATA DEFAULT
// ==========================================

$nama_wo = !empty($pengaturan['nama_wo'])
    ? $pengaturan['nama_wo']
    : "Luxora Organizer";

$slogan = !empty($pengaturan['slogan'])
    ? $pengaturan['slogan']
    : "Mewujudkan Pernikahan Impian Anda";

$deskripsi = !empty($pengaturan['deskripsi'])
    ? $pengaturan['deskripsi']
    : "Luxora Organizer adalah wedding organizer profesional yang membantu pasangan mewujudkan pernikahan yang indah, elegan dan berkesan.";

?>

<!-- ==================================================
     PAGE HERO
================================================== -->

<section class="hero" style="
    min-height: 500px;
    background-position: center;
">

    <div class="container">

        <div class="hero-content fade-left">

            <p>
                ABOUT LUXORA
            </p>

            <h1>
                Our Story
            </h1>

            <p>
                Mengenal lebih dekat Luxora Organizer
                dan bagaimana kami membantu mewujudkan
                hari istimewa Anda.
            </p>

        </div>

    </div>

</section>


<!-- ==================================================
     INTRO ABOUT
================================================== -->

<section class="section">

    <div class="container">

        <div class="intro-grid">

            <div class="intro-image fade-left">

                <img
                    src="assets/images/galeri-1.jpg"
                    alt="Luxora Organizer"
                >

            </div>


            <div class="intro-content fade-right">

                <p
                    style="
                        color:#b88980;
                        letter-spacing:3px;
                        margin-bottom:10px;
                    "
                >
                    WELCOME TO LUXORA
                </p>

                <h2>
                    We Create
                    Beautiful Moments.
                </h2>

                <p>
                    Selamat datang di
                    <strong>
                        <?php echo htmlspecialchars($nama_wo); ?>
                    </strong>.
                </p>

                <p>
                    <?php echo htmlspecialchars($deskripsi); ?>
                </p>

                <p>
                    Bagi kami, pernikahan bukan hanya
                    sebuah acara. Setiap detail memiliki
                    cerita dan setiap momen memiliki arti.
                    Karena itu, kami berusaha memberikan
                    pelayanan terbaik untuk membantu
                    menciptakan hari yang benar-benar
                    spesial bagi setiap pasangan.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     OUR PHILOSOPHY
================================================== -->

<section
    class="section"
    style="background:#ead8d0;"
>

    <div class="container">

        <div class="section-title fade-up">

            <p
                style="
                    color:#b88980;
                    letter-spacing:3px;
                    margin-bottom:5px;
                "
            >
                OUR PHILOSOPHY
            </p>

            <h2>
                We Design.
                You Celebrate.
            </h2>

            <p>
                Kami percaya bahwa sebuah pernikahan
                yang indah dimulai dari perencanaan
                yang matang dan perhatian terhadap
                setiap detail.
            </p>

        </div>


        <div class="card-grid">

            <!-- CARD 1 -->

            <div
                class="card fade-up"
                style="transition-delay:0.1s;"
            >

                <div class="card-content">

                    <h3>
                        Passion
                    </h3>

                    <p>
                        Kami mengerjakan setiap acara
                        dengan penuh semangat dan perhatian.
                        Setiap konsep kami buat dengan
                        mempertimbangkan karakter serta
                        keinginan pasangan.
                    </p>

                </div>

            </div>


            <!-- CARD 2 -->

            <div
                class="card fade-up"
                style="transition-delay:0.2s;"
            >

                <div class="card-content">

                    <h3>
                        Details
                    </h3>

                    <p>
                        Dari dekorasi hingga jalannya acara,
                        kami memperhatikan berbagai detail
                        agar setiap bagian pernikahan
                        terlihat harmonis dan berkesan.
                    </p>

                </div>

            </div>


            <!-- CARD 3 -->

            <div
                class="card fade-up"
                style="transition-delay:0.3s;"
            >

                <div class="card-content">

                    <h3>
                        Memories
                    </h3>

                    <p>
                        Tujuan kami bukan hanya membuat
                        acara berjalan lancar, tetapi juga
                        menciptakan kenangan indah yang
                        dapat dikenang untuk waktu yang lama.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     WHY CHOOSE US
================================================== -->

<section class="section">

    <div class="container">

        <div class="section-title fade-up">

            <p
                style="
                    color:#b88980;
                    letter-spacing:3px;
                    margin-bottom:5px;
                "
            >
                WHY CHOOSE US
            </p>

            <h2>
                Why Luxora?
            </h2>

            <p>
                Alasan mengapa pasangan mempercayakan
                momen spesial mereka kepada kami.
            </p>

        </div>


        <div class="intro-grid">

            <!-- IMAGE -->

            <div class="intro-image fade-left">

                <img
                    src="assets/images/galeri-5.jpg"
                    alt="Wedding Moment"
                >

            </div>


            <!-- CONTENT -->

            <div class="intro-content fade-right">

                <h2>
                    Your Day,
                    Your Story.
                </h2>


                <p>
                    Setiap pasangan memiliki cerita,
                    karakter dan impian yang berbeda.
                    Karena itu, kami tidak menggunakan
                    satu konsep yang sama untuk semua acara.
                </p>


                <p>
                    Kami mendengarkan apa yang Anda
                    inginkan, membantu memberikan ide,
                    kemudian mengubahnya menjadi konsep
                    pernikahan yang sesuai dengan
                    keinginan Anda.
                </p>


                <div
                    style="
                        margin-top:25px;
                    "
                >

                    <p>
                        ✓ Tim profesional
                    </p>

                    <p>
                        ✓ Konsep dapat disesuaikan
                    </p>

                    <p>
                        ✓ Memperhatikan setiap detail
                    </p>

                    <p>
                        ✓ Pelayanan dari awal hingga acara selesai
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     OUR VALUES
================================================== -->

<section
    class="section"
    style="background:#f7e9e2;"
>

    <div class="container">

        <div class="section-title fade-up">

            <p
                style="
                    color:#b88980;
                    letter-spacing:3px;
                "
            >
                OUR VALUES
            </p>

            <h2>
                Made With Love
            </h2>

        </div>


        <div class="layanan-grid">

            <!-- VALUE 1 -->

            <div
                class="layanan-card fade-up"
                style="transition-delay:0.1s;"
            >

                <h3>
                    Trust
                </h3>

                <p>
                    Kami membangun hubungan yang baik
                    dengan setiap klien melalui komunikasi
                    yang terbuka dan pelayanan yang dapat
                    dipercaya.
                </p>

            </div>


            <!-- VALUE 2 -->

            <div
                class="layanan-card fade-up"
                style="transition-delay:0.2s;"
            >

                <h3>
                    Creativity
                </h3>

                <p>
                    Kami selalu berusaha menghadirkan
                    ide dan konsep yang kreatif agar
                    pernikahan terasa lebih personal.
                </p>

            </div>


            <!-- VALUE 3 -->

            <div
                class="layanan-card fade-up"
                style="transition-delay:0.3s;"
            >

                <h3>
                    Excellence
                </h3>

                <p>
                    Kami berkomitmen memberikan hasil
                    dan pelayanan terbaik pada setiap
                    acara yang kami tangani.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     SIMPLE GALLERY
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
                OUR MOMENTS
            </p>

            <h2>
                A Glimpse Of Our Work
            </h2>

            <p>
                Beberapa momen dari acara yang telah
                kami bantu persiapkan.
            </p>

        </div>


        <div class="galeri-grid">

            <div
                class="galeri-item zoom-in"
                style="transition-delay:0.1s;"
            >

                <img
                    src="assets/images/galeri-1.jpg"
                    alt="Wedding Moment"
                >

            </div>


            <div
                class="galeri-item zoom-in"
                style="transition-delay:0.15s;"
            >

                <img
                    src="assets/images/galeri-2.jpg"
                    alt="Wedding Moment"
                >

            </div>


            <div
                class="galeri-item zoom-in"
                style="transition-delay:0.2s;"
            >

                <img
                    src="assets/images/galeri-3.jpg"
                    alt="Wedding Decoration"
                >

            </div>


            <div
                class="galeri-item zoom-in"
                style="transition-delay:0.25s;"
            >

                <img
                    src="assets/images/galeri-4.jpg"
                    alt="Wedding Makeup"
                >

            </div>

        </div>


        <div
            style="
                text-align:center;
                margin-top:40px;
            "
            class="fade-up"
        >

            <a
                href="galeri.php"
                class="btn-detail"
            >
                Explore Our Gallery
            </a>

        </div>

    </div>

</section>


<!-- ==================================================
     CTA
================================================== -->

<section
    class="section"
    style="background:#cdb5ad;"
>

    <div class="container">

        <div
            class="contact-box fade-up"
            style="
                text-align:center;
                background:#fff8f3;
            "
        >

            <p
                style="
                    color:#b88980;
                    letter-spacing:3px;
                "
            >
                LET'S CELEBRATE
            </p>

            <h2>
                Let's Create
                Something Beautiful
                Together.
            </h2>

            <p>
                <?php echo htmlspecialchars($slogan); ?>.
                Ceritakan kepada kami tentang
                pernikahan impian Anda.
            </p>

            <br>

            <a
                href="kontak.php"
                class="btn-detail"
            >
                Let's Talk
            </a>

        </div>

    </div>

</section>


<?php

include "includes/footer.php";

?>