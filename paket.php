<?php

session_start();

include "config/koneksi.php";

$judul = "Paket Pernikahan - Luxora Organizer";

include "includes/header.php";
include "includes/navbar.php";


$query_paket = mysqli_query(
    $koneksi,
    "SELECT * FROM paket
     WHERE status = 'aktif'
     ORDER BY id_paket ASC"
);

?>


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
                LUXORA COLLECTION
            </p>

            <h1>
                Wedding Packages
            </h1>

            <p>
                Temukan paket yang sesuai dengan
                impian dan kebutuhan pernikahan Anda.
            </p>

        </div>

    </div>

</section>


<section class="section">

    <div class="container">

        <div class="section-title fade-up">

            <p
                style="
                    color:#b88980;
                    letter-spacing:3px;
                "
            >
                OUR PACKAGES
            </p>

            <h2>
                Choose Your Perfect Package
            </h2>

            <p>
                Setiap paket dirancang untuk memberikan
                pengalaman pernikahan yang indah,
                nyaman dan berkesan.
            </p>

        </div>


        <!-- ==================================================
             PAKET GRID
        ================================================== -->

        <div class="paket-grid">

            <?php if (mysqli_num_rows($query_paket) > 0): ?>

                <?php

                $delay = 0.1;
                $nomor = 1;

                while (
                    $paket = mysqli_fetch_assoc(
                        $query_paket
                    )
                ):

                ?>

                    <div
                        class="paket-card fade-up"
                        style="
                            transition-delay:
                            <?php echo $delay; ?>s;
                        "
                    >

                        <!-- ==========================
                             LABEL POPULAR
                        =========================== -->

                        <?php if ($nomor == 2): ?>

                            <div
                                style="
                                    background:#c99f96;
                                    color:#ffffff;
                                    padding:8px;
                                    text-align:center;
                                    font-size:15px;
                                    letter-spacing:2px;
                                "
                            >
                                MOST POPULAR
                            </div>

                        <?php endif; ?>


                        <!-- ==========================
                             GAMBAR
                        =========================== -->

                        <img
                            src="assets/images/<?php
                                echo htmlspecialchars(
                                    $paket['gambar']
                                );
                            ?>"
                            alt="<?php
                                echo htmlspecialchars(
                                    $paket['nama_paket']
                                );
                            ?>"
                        >


                        <!-- ==========================
                             CONTENT
                        =========================== -->

                        <div class="paket-content">

                            <h3>

                                <?php

                                echo htmlspecialchars(
                                    $paket['nama_paket']
                                );

                                ?>

                            </h3>


                            <!-- HARGA -->

                            <div class="harga">

                                Rp

                                <?php

                                echo number_format(
                                    $paket['harga'],
                                    0,
                                    ',',
                                    '.'
                                );

                                ?>

                            </div>


                            <!-- DESKRIPSI -->

                            <p>

                                <?php

                                echo htmlspecialchars(
                                    $paket['deskripsi']
                                );

                                ?>

                            </p>


                            <!-- ==========================
                                 FASILITAS
                            =========================== -->

                            <div
                                style="
                                    text-align:left;
                                    margin:20px 0;
                                "
                            >

                                <p
                                    style="
                                        font-weight:700;
                                        margin-bottom:8px;
                                    "
                                >
                                    Fasilitas:
                                </p>


                                <?php

                                $fasilitas = explode(
                                    ',',
                                    $paket['fasilitas']
                                );

                                ?>


                                <ul
                                    style="
                                        padding-left:20px;
                                    "
                                >

                                    <?php foreach (
                                        $fasilitas
                                        as $item
                                    ): ?>

                                        <li
                                            style="
                                                margin-bottom:5px;
                                            "
                                        >

                                            <?php

                                            echo htmlspecialchars(
                                                trim($item)
                                            );

                                            ?>

                                        </li>

                                    <?php endforeach; ?>

                                </ul>

                            </div>


                            <!-- ==========================
                                 BUTTON
                            =========================== -->

                            <div
                                style="
                                    display:flex;
                                    flex-wrap:wrap;
                                    gap:8px;
                                    justify-content:center;
                                "
                            >

                                <a
                                    href="detail-paket.php?id=<?php echo $paket['id_paket']; ?>"
                                    class="btn-detail"
                                >
                                    Lihat Detail
                                </a>

                            </div>

                        </div>

                    </div>


                    <?php

                    $delay += 0.1;
                    $nomor++;

                    ?>

                <?php endwhile; ?>


            <?php else: ?>

                <div class="empty-data">

                    <h3>
                        Paket Belum Tersedia
                    </h3>

                    <p>
                        Saat ini belum ada paket
                        yang dapat ditampilkan.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>


<!-- ==================================================
     INFO
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
                NEED SOMETHING CUSTOM?
            </p>

            <h2>
                Your Wedding,
                Your Way.
            </h2>

            <p>
                Tidak menemukan paket yang sesuai?
                Jangan khawatir. Kami dapat membantu
                menyesuaikan konsep dan kebutuhan
                pernikahan Anda.
            </p>

            <br>

            <a
                href="kontak.php"
                class="btn-detail"
            >
                Konsultasikan Dengan Kami
            </a>

        </div>

    </div>

</section>


<?php

include "includes/footer.php";

?>