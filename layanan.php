<?php

include "config/koneksi.php";

$judul = "Layanan - Luxora Organizer";

include "includes/header.php";
include "includes/navbar.php";


// ==========================================
// AMBIL DATA LAYANAN
// ==========================================

$query_layanan = mysqli_query(
    $koneksi,
    "SELECT * FROM layanan
     WHERE status = 'aktif'
     ORDER BY id_layanan ASC"
);

?>

<!-- ==================================================
     HERO LAYANAN
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
                LUXORA SERVICES
            </p>

            <h1>
                Our Services
            </h1>

            <p>
                Everything you need to create
                your perfect wedding day.
            </p>

        </div>

    </div>

</section>


<!-- ==================================================
     INTRO
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
                WHAT WE OFFER
            </p>

            <h2>
                Designed For Your Day
            </h2>

            <p>
                Kami menyediakan berbagai layanan
                yang dapat disesuaikan dengan konsep
                dan kebutuhan pernikahan Anda.
            </p>

        </div>


        <!-- ==================================================
             LIST LAYANAN
        ================================================== -->

        <div class="layanan-grid">

            <?php if (mysqli_num_rows($query_layanan) > 0): ?>

                <?php

                $delay = 0.1;

                while (
                    $layanan = mysqli_fetch_assoc(
                        $query_layanan
                    )
                ):

                ?>

                    <div
                        class="layanan-card fade-up"
                        style="
                            transition-delay:
                            <?php echo $delay; ?>s;
                        "
                    >

                        <!-- FOTO -->

                        <img
                            src="assets/images/<?php
                                echo htmlspecialchars(
                                    $layanan['gambar']
                                );
                            ?>"
                            alt="<?php
                                echo htmlspecialchars(
                                    $layanan['nama_layanan']
                                );
                            ?>"
                        >


                        <!-- ISI -->

                        <h3>
                            <?php

                            echo htmlspecialchars(
                                $layanan['nama_layanan']
                            );

                            ?>
                        </h3>


                        <p>
                            <?php

                            echo htmlspecialchars(
                                $layanan['deskripsi']
                            );

                            ?>
                        </p>

                    </div>


                <?php

                    $delay += 0.1;

                endwhile;

                ?>


            <?php else: ?>

                <div class="empty-data">

                    <h3>
                        Layanan Belum Tersedia
                    </h3>

                    <p>
                        Saat ini belum ada layanan
                        yang dapat ditampilkan.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>


<!-- ==================================================
     PROCESS
================================================== -->

<section
    class="section"
    style="
        background:#ead8d0;
    "
>

    <div class="container">

        <div class="section-title fade-up">

            <p
                style="
                    color:#b88980;
                    letter-spacing:3px;
                "
            >
                OUR PROCESS
            </p>

            <h2>
                How We Work
            </h2>

            <p>
                Kami membantu Anda melalui setiap tahap
                persiapan pernikahan dengan proses yang
                terarah dan nyaman.
            </p>

        </div>


        <div class="card-grid">

            <!-- STEP 1 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.1s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <p
                        style="
                            color:#b88980;
                            font-size:18px;
                            letter-spacing:2px;
                        "
                    >
                        STEP 01
                    </p>

                    <h3>
                        Consultation
                    </h3>

                    <p>
                        Ceritakan konsep, kebutuhan,
                        dan impian pernikahan Anda
                        kepada tim Luxora Organizer.
                    </p>

                </div>

            </div>


            <!-- STEP 2 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.2s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <p
                        style="
                            color:#b88980;
                            font-size:18px;
                            letter-spacing:2px;
                        "
                    >
                        STEP 02
                    </p>

                    <h3>
                        Planning
                    </h3>

                    <p>
                        Kami membantu menyusun konsep
                        dan berbagai kebutuhan agar
                        persiapan menjadi lebih terarah.
                    </p>

                </div>

            </div>


            <!-- STEP 3 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.3s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <p
                        style="
                            color:#b88980;
                            font-size:18px;
                            letter-spacing:2px;
                        "
                    >
                        STEP 03
                    </p>

                    <h3>
                        Preparation
                    </h3>

                    <p>
                        Setiap detail dipersiapkan
                        sesuai konsep yang telah
                        disepakati bersama.
                    </p>

                </div>

            </div>

        </div>


        <br><br>


        <div class="card-grid">

            <!-- STEP 4 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.1s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <p
                        style="
                            color:#b88980;
                            font-size:18px;
                            letter-spacing:2px;
                        "
                    >
                        STEP 04
                    </p>

                    <h3>
                        Coordination
                    </h3>

                    <p>
                        Tim kami melakukan koordinasi
                        dengan berbagai pihak yang
                        terlibat dalam acara.
                    </p>

                </div>

            </div>


            <!-- STEP 5 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.2s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <p
                        style="
                            color:#b88980;
                            font-size:18px;
                            letter-spacing:2px;
                        "
                    >
                        STEP 05
                    </p>

                    <h3>
                        Your Wedding Day
                    </h3>

                    <p>
                        Saatnya Anda menikmati hari
                        istimewa sementara kami membantu
                        memastikan acara berjalan lancar.
                    </p>

                </div>

            </div>


            <!-- STEP 6 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.3s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <p
                        style="
                            color:#b88980;
                            font-size:18px;
                            letter-spacing:2px;
                        "
                    >
                        STEP 06
                    </p>

                    <h3>
                        Beautiful Memories
                    </h3>

                    <p>
                        Semua momen indah menjadi
                        kenangan yang dapat Anda
                        simpan selamanya.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     CTA
================================================== -->

<section class="section">

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
                READY TO START?
            </p>

            <h2>
                Let's Plan Your
                Dream Wedding
            </h2>

            <p>
                Konsultasikan kebutuhan dan konsep
                pernikahan Anda bersama kami.
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