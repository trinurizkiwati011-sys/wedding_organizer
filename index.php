<?php

include "config/koneksi.php";

$judul = "Home - Luxora Organizer";

include "includes/header.php";
include "includes/navbar.php";


// ==========================================
// DATA LAYANAN
// ==========================================

$query_layanan = mysqli_query(
    $koneksi,
    "SELECT * FROM layanan
     WHERE status = 'aktif'
     ORDER BY id_layanan ASC
     LIMIT 6"
);


// ==========================================
// DATA PAKET
// ==========================================

$query_paket = mysqli_query(
    $koneksi,
    "SELECT * FROM paket
     WHERE status = 'aktif'
     ORDER BY id_paket ASC
     LIMIT 3"
);


// ==========================================
// DATA GALERI
// ==========================================

$query_galeri = mysqli_query(
    $koneksi,
    "SELECT * FROM galeri
     WHERE status = 'aktif'
     ORDER BY id_galeri ASC
     LIMIT 8"
);


// ==========================================
// DATA TESTIMONI
// ==========================================

$query_testimoni = mysqli_query(
    $koneksi,
    "SELECT * FROM testimoni
     WHERE status = 'ditampilkan'
     ORDER BY id_testimoni DESC
     LIMIT 3"
);

?>

<!-- ==================================================
     HERO
================================================== -->

<section class="hero">

    <div class="container">

        <div class="hero-content fade-left">

            <p>
                LUXORA ORGANIZER
            </p>

            <h1>
                We Design.
                You Celebrate.
            </h1>

            <p>
                Kami membantu menciptakan pernikahan yang
                indah, elegan dan penuh dengan momen
                yang tidak terlupakan.
            </p>

            <a href="paket.php" class="btn-primary">
                Lihat Paket
            </a>

            <a href="kontak.php" class="btn-primary">
                Hubungi Kami
            </a>

        </div>

    </div>

</section>


<!-- ==================================================
     INTRO
================================================== -->

<section class="section">

    <div class="container">

        <div class="intro-grid">

            <div class="intro-image fade-left">

                <img
                    src="assets/images/galeri-3.jpg"
                    alt="Dekorasi Pernikahan Luxora Organizer"
                >

            </div>


            <div class="intro-content fade-right">

                <h2>
                    Your Dream.
                    Our Creation.
                </h2>

                <p>
                    Dari acara intimate hingga pernikahan
                    yang megah, Luxora Organizer membantu
                    mewujudkan konsep yang Anda impikan.
                </p>

                <p>
                    Kami memperhatikan setiap detail mulai
                    dari dekorasi, makeup, busana,
                    dokumentasi hingga jalannya acara.
                </p>

                <a href="tentang.php" class="btn-detail">
                    Kenal Lebih Dekat
                </a>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     LAYANAN
================================================== -->

<section class="section">

    <div class="container">

        <div class="section-title fade-up">

            <h2>
                What We Do
            </h2>

            <p>
                Berbagai layanan yang kami siapkan
                untuk membuat hari spesial Anda
                berjalan sempurna.
            </p>

        </div>


        <div class="layanan-grid">

            <?php if (mysqli_num_rows($query_layanan) > 0): ?>

                <?php
                $delay = 0.1;
                ?>

                <?php while ($layanan = mysqli_fetch_assoc($query_layanan)): ?>

                    <div
                        class="layanan-card fade-up"
                        style="transition-delay: <?php echo $delay; ?>s;"
                    >

                        <img
                            src="assets/images/<?php echo htmlspecialchars($layanan['gambar']); ?>"
                            alt="<?php echo htmlspecialchars($layanan['nama_layanan']); ?>"
                        >

                        <h3>
                            <?php echo htmlspecialchars($layanan['nama_layanan']); ?>
                        </h3>

                        <p>
                            <?php echo htmlspecialchars($layanan['deskripsi']); ?>
                        </p>

                    </div>

                    <?php
                    $delay += 0.1;
                    ?>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="empty-data">

                    Data layanan belum tersedia.

                </div>

            <?php endif; ?>

        </div>


        <div
            style="text-align:center; margin-top:40px;"
            class="fade-up"
        >

            <a
                href="layanan.php"
                class="btn-detail"
            >
                Lihat Semua Layanan
            </a>

        </div>

    </div>

</section>


<!-- ==================================================
     GALERI PREVIEW
================================================== -->

<section class="section">

    <div class="container">

        <div class="section-title fade-up">

            <h2>
                Little Moments
            </h2>

            <p>
                Beberapa momen indah yang telah kami
                abadikan dalam berbagai acara.
            </p>

        </div>


        <div class="galeri-grid">

            <?php if (mysqli_num_rows($query_galeri) > 0): ?>

                <?php
                $delay = 0.1;
                ?>

                <?php while ($galeri = mysqli_fetch_assoc($query_galeri)): ?>

                    <div
                        class="galeri-item zoom-in"
                        style="transition-delay: <?php echo $delay; ?>s;"
                    >

                        <img
                            src="assets/images/<?php echo htmlspecialchars($galeri['gambar']); ?>"
                            alt="<?php echo htmlspecialchars($galeri['judul']); ?>"
                        >

                    </div>

                    <?php
                    $delay += 0.08;
                    ?>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="empty-data">

                    Galeri belum tersedia.

                </div>

            <?php endif; ?>

        </div>


        <div
            style="text-align:center; margin-top:40px;"
            class="fade-up"
        >

            <a
                href="galeri.php"
                class="btn-detail"
            >
                Lihat Semua Galeri
            </a>

        </div>

    </div>

</section>


<!-- ==================================================
     PAKET
================================================== -->

<section class="section">

    <div class="container">

        <div class="section-title fade-up">

            <h2>
                Our Wedding Packages
            </h2>

            <p>
                Pilihan paket yang dapat disesuaikan
                dengan kebutuhan dan konsep pernikahan Anda.
            </p>

        </div>


        <div class="paket-grid">

            <?php if (mysqli_num_rows($query_paket) > 0): ?>

                <?php
                $delay = 0.1;
                $nomor_paket = 1;
                ?>

                <?php while ($paket = mysqli_fetch_assoc($query_paket)): ?>

                    <div
                        class="paket-card fade-up"
                        style="transition-delay: <?php echo $delay; ?>s;"
                    >

                        <?php if ($nomor_paket == 2): ?>

                            <div
                                style="
                                    background:#c99f96;
                                    color:white;
                                    padding:7px;
                                    font-size:15px;
                                    letter-spacing:1px;
                                "
                            >
                                MOST POPULAR
                            </div>

                        <?php endif; ?>


                        <img
                            src="assets/images/<?php echo htmlspecialchars($paket['gambar']); ?>"
                            alt="<?php echo htmlspecialchars($paket['nama_paket']); ?>"
                        >


                        <div class="paket-content">

                            <h3>
                                <?php echo htmlspecialchars($paket['nama_paket']); ?>
                            </h3>


                            <div class="harga">

                                Rp
                                <?php echo number_format(
                                    $paket['harga'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                            </div>


                            <p>

                                <?php
                                echo htmlspecialchars(
                                    $paket['deskripsi']
                                );
                                ?>

                            </p>


                            <a
                                href="detail-paket.php?id=<?php echo $paket['id_paket']; ?>"
                                class="btn-detail"
                            >
                                Lihat Paket
                            </a>

                        </div>

                    </div>

                    <?php

                    $delay += 0.15;
                    $nomor_paket++;

                    ?>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="empty-data">

                    Data paket belum tersedia.

                </div>

            <?php endif; ?>

        </div>


        <div
            style="text-align:center; margin-top:40px;"
            class="fade-up"
        >

            <a
                href="paket.php"
                class="btn-detail"
            >
                Lihat Semua Paket
            </a>

        </div>

    </div>

</section>


<!-- ==================================================
     TESTIMONI
================================================== -->

<section class="section">

    <div class="container">

        <div class="section-title fade-up">

            <h2>
                What Our Clients Say
            </h2>

            <p>
                Cerita dari pasangan yang telah
                mempercayakan hari istimewa mereka
                kepada Luxora Organizer.
            </p>

        </div>


        <div class="testimoni-grid">

            <?php if (mysqli_num_rows($query_testimoni) > 0): ?>

                <?php
                $delay = 0.1;
                ?>

                <?php while ($testimoni = mysqli_fetch_assoc($query_testimoni)): ?>

                    <div
                        class="testimoni-card fade-up"
                        style="transition-delay: <?php echo $delay; ?>s;"
                    >

                        <div class="testimoni-user">

                            <img
                                src="assets/images/<?php echo htmlspecialchars($testimoni['foto']); ?>"
                                alt="<?php echo htmlspecialchars($testimoni['nama']); ?>"
                            >

                            <div>

                                <h3>
                                    <?php echo htmlspecialchars($testimoni['nama']); ?>
                                </h3>

                            </div>

                        </div>


                        <div class="rating">

                            <?php

                            for (
                                $i = 1;
                                $i <= 5;
                                $i++
                            ) {

                                if (
                                    $i <=
                                    $testimoni['rating']
                                ) {

                                    echo "★";

                                } else {

                                    echo "☆";

                                }

                            }

                            ?>

                        </div>


                        <p>

                            "<?php
                            echo htmlspecialchars(
                                $testimoni['isi_testimoni']
                            );
                            ?>"

                        </p>

                    </div>

                    <?php
                    $delay += 0.15;
                    ?>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="empty-data">

                    Belum ada testimoni.

                </div>

            <?php endif; ?>

        </div>


        <div
            style="text-align:center; margin-top:40px;"
            class="fade-up"
        >

            <a
                href="testimoni.php"
                class="btn-detail"
            >
                Lihat Semua Testimoni
            </a>

        </div>

    </div>

</section>


<!-- ==================================================
     CTA
================================================== -->

<section class="section">

    <div class="container">

        <div class="contact-box fade-up">

            <h2>
                Let's Create Your
                Beautiful Day
            </h2>

            <p>
                Punya konsep pernikahan impian?
                Ceritakan kepada kami dan biarkan
                Luxora Organizer membantu mewujudkannya.
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


<?php

include "includes/footer.php";

?>