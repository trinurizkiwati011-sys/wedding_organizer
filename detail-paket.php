<?php

include "config/koneksi.php";

$judul = "Detail Paket - Luxora Organizer";

include "includes/header.php";
include "includes/navbar.php";


// ==================================================
// AMBIL ID PAKET
// ==================================================

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    echo "
    <section class='section'>
        <div class='container'>
            <div class='empty-data'>
                <h3>Paket Tidak Ditemukan</h3>
                <p>ID paket tidak valid.</p>
                <br>
                <a href='paket.php' class='btn-detail'>
                    Kembali ke Paket
                </a>
            </div>
        </div>
    </section>
    ";

    include "includes/footer.php";
    exit;
}


$id_paket = (int) $_GET['id'];


// ==================================================
// AMBIL DATA PAKET DARI DATABASE
// ==================================================

$query = mysqli_query(
    $koneksi,
    "SELECT *
     FROM paket
     WHERE id_paket = $id_paket
     AND status = 'aktif'
     LIMIT 1"
);


// ==================================================
// CEK DATA PAKET
// ==================================================

if (mysqli_num_rows($query) == 0) {

    echo "
    <section class='section'>
        <div class='container'>
            <div class='empty-data'>
                <h3>Paket Tidak Ditemukan</h3>
                <p>Paket yang Anda cari tidak tersedia.</p>
                <br>
                <a href='paket.php' class='btn-detail'>
                    Kembali ke Paket
                </a>
            </div>
        </div>
    </section>
    ";

    include "includes/footer.php";
    exit;
}


$paket = mysqli_fetch_assoc($query);


// ==================================================
// DATA PAKET
// ==================================================

$nama_paket = $paket['nama_paket'];
$harga = $paket['harga'];
$deskripsi = $paket['deskripsi'];
$gambar = $paket['gambar'];
$fasilitas = explode(',', $paket['fasilitas']);


// ==================================================
// AMBIL NOMOR WHATSAPP DARI PENGATURAN
// ==================================================

$query_pengaturan = mysqli_query(
    $koneksi,
    "SELECT no_whatsapp
     FROM pengaturan
     LIMIT 1"
);

$pengaturan = mysqli_fetch_assoc($query_pengaturan);

$nomor_whatsapp = $pengaturan['no_whatsapp'] ?? '';


// ==================================================
// BERSIHKAN NOMOR WHATSAPP
// ==================================================

// Menghilangkan spasi, tanda +, strip, dan karakter lainnya
$nomor_whatsapp = preg_replace(
    '/[^0-9]/',
    '',
    $nomor_whatsapp
);


// Jika nomor diawali 0, ubah menjadi 62
if (substr($nomor_whatsapp, 0, 1) === '0') {

    $nomor_whatsapp = '62' . substr(
        $nomor_whatsapp,
        1
    );
}


// ==================================================
// PESAN WHATSAPP
// ==================================================

$pesan_whatsapp =
    "Halo Luxora Organizer,\n\n" .
    "Saya tertarik dengan paket pernikahan:\n" .
    "Paket: " . $nama_paket . "\n" .
    "Harga: Rp " . number_format(
        $harga,
        0,
        ',',
        '.'
    ) . "\n\n" .
    "Saya ingin berkonsultasi mengenai paket tersebut. " .
    "Terima kasih.";


// ==================================================
// LINK WHATSAPP
// ==================================================

$link_whatsapp =
    "https://wa.me/" .
    $nomor_whatsapp .
    "?text=" .
    urlencode($pesan_whatsapp);

?>

<!-- ==================================================
     HERO DETAIL
================================================== -->

<section
    class="hero"
    style="
        min-height:430px;
        background-position:center;
    "
>

    <div class="container">

        <div class="hero-content fade-left">

            <p>
                LUXORA WEDDING COLLECTION
            </p>

            <h1>
                <?php echo htmlspecialchars($nama_paket); ?>
            </h1>

            <p>
                Discover every detail of your
                perfect wedding package.
            </p>

        </div>

    </div>

</section>


<!-- ==================================================
     DETAIL PAKET
================================================== -->

<section class="section">

    <div class="container">

        <div
            class="detail-paket"
            style="
                display:grid;
                grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1fr);
                gap:50px;
                align-items:center;
            "
        >


            <!-- ==============================
                 GAMBAR
            =============================== -->

            <div class="fade-left">

                <img
                    src="assets/images/<?php
                        echo htmlspecialchars($gambar);
                    ?>"
                    alt="<?php
                        echo htmlspecialchars($nama_paket);
                    ?>"
                    style="
                        width:100%;
                        height:520px;
                        object-fit:cover;
                        border-radius:20px;
                        display:block;
                    "
                >

            </div>


            <!-- ==============================
                 INFORMASI
            =============================== -->

            <div class="fade-right">

                <p
                    style="
                        color:#b88980;
                        letter-spacing:3px;
                        font-size:17px;
                    "
                >
                    LUXORA PACKAGE
                </p>


                <h2
                    style="
                        font-size:48px;
                        margin-bottom:10px;
                    "
                >
                    <?php
                    echo htmlspecialchars($nama_paket);
                    ?>
                </h2>


                <!-- HARGA -->

                <div
                    style="
                        font-size:32px;
                        font-weight:700;
                        color:#b88980;
                        margin-bottom:25px;
                    "
                >

                    Rp
                    <?php
                    echo number_format(
                        $harga,
                        0,
                        ',',
                        '.'
                    );
                    ?>

                </div>


                <!-- DESKRIPSI -->

                <p
                    style="
                        font-size:19px;
                        line-height:1.8;
                    "
                >

                    <?php
                    echo htmlspecialchars($deskripsi);
                    ?>

                </p>


                <!-- GARIS -->

                <div
                    style="
                        width:80px;
                        height:2px;
                        background:#c99f96;
                        margin:25px 0;
                    "
                ></div>


                <!-- ==============================
                     FASILITAS
                =============================== -->

                <h3
                    style="
                        font-size:32px;
                        margin-bottom:15px;
                    "
                >
                    What's Included
                </h3>


                <ul
                    style="
                        list-style:none;
                        padding:0;
                        margin:0 0 30px 0;
                    "
                >

                    <?php foreach ($fasilitas as $item): ?>

                        <?php
                        $item = trim($item);

                        if ($item == '') {
                            continue;
                        }
                        ?>

                        <li
                            style="
                                padding:10px 0;
                                border-bottom:
                                1px solid #ead8d0;
                                font-size:18px;
                            "
                        >

                            <span
                                style="
                                    color:#b88980;
                                    margin-right:8px;
                                "
                            >
                                ✦
                            </span>

                            <?php
                            echo htmlspecialchars($item);
                            ?>

                        </li>

                    <?php endforeach; ?>

                </ul>


                <!-- ==============================
                     BUTTON
                =============================== -->

                <div
                    style="
                        display:flex;
                        gap:12px;
                        flex-wrap:wrap;
                    "
                >

                    <?php if (!empty($nomor_whatsapp)): ?>

                        <a
                            href="<?php
                                echo htmlspecialchars(
                                    $link_whatsapp
                                );
                            ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-detail"
                        >
                            Booking via WhatsApp
                        </a>

                    <?php else: ?>

                        <span
                            class="btn-detail"
                            style="
                                opacity:0.6;
                                cursor:not-allowed;
                            "
                        >
                            WhatsApp Belum Diatur
                        </span>

                    <?php endif; ?>


                    <a
                        href="paket.php"
                        class="btn-favorit"
                    >
                        ← Kembali
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     WHY CHOOSE THIS PACKAGE
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
                YOUR SPECIAL DAY
            </p>

            <h2>
                Made With Love
            </h2>

            <p>
                Kami percaya setiap pernikahan memiliki
                cerita yang berbeda. Karena itu, setiap
                detail kami persiapkan dengan penuh
                perhatian agar hari istimewa Anda
                terasa lebih berkesan.
            </p>

        </div>


        <div class="card-grid">


            <!-- CARD 1 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.1s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <h3>
                        Beautiful Details
                    </h3>

                    <p>
                        Setiap elemen dipersiapkan
                        dengan memperhatikan detail
                        agar sesuai dengan konsep
                        pernikahan Anda.
                    </p>

                </div>

            </div>


            <!-- CARD 2 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.2s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <h3>
                        Personal Planning
                    </h3>

                    <p>
                        Kami membantu merancang
                        pernikahan sesuai kebutuhan,
                        konsep dan keinginan Anda.
                    </p>

                </div>

            </div>


            <!-- CARD 3 -->

            <div
                class="card fade-up"
                style="
                    transition-delay:0.3s;
                    text-align:center;
                "
            >

                <div class="card-content">

                    <h3>
                        Precious Memories
                    </h3>

                    <p>
                        Kami membantu menciptakan
                        momen indah yang dapat
                        dikenang sepanjang waktu.
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
                READY TO CREATE?
            </p>

            <h2>
                Let's Make It Beautiful
            </h2>

            <p>
                Sudah menemukan paket yang sesuai?
                Hubungi Luxora Organizer untuk
                konsultasi lebih lanjut.
            </p>

            <br>

            <?php if (!empty($nomor_whatsapp)): ?>

                <a
                    href="<?php
                        echo htmlspecialchars(
                            $link_whatsapp
                        );
                    ?>"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-detail"
                >
                    Konsultasi Sekarang
                </a>

            <?php else: ?>

                <span
                    class="btn-detail"
                    style="
                        opacity:0.6;
                        cursor:not-allowed;
                    "
                >
                    WhatsApp Belum Diatur
                </span>

            <?php endif; ?>

        </div>

    </div>

</section>


<?php

include "includes/footer.php";

?>