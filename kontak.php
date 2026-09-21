<?php

include "config/koneksi.php";

$judul = "Kontak - Luxora Organizer";

include "includes/header.php";
include "includes/navbar.php";


// ==================================================
// AMBIL DATA PENGATURAN
// ==================================================

$query_pengaturan = mysqli_query(
    $koneksi,
    "SELECT *
     FROM pengaturan
     LIMIT 1"
);

$pengaturan = mysqli_fetch_assoc($query_pengaturan);


// ==================================================
// DATA KONTAK
// ==================================================

$nama_website = !empty($pengaturan['nama_wo'])
    ? $pengaturan['nama_wo']
    : "Luxora Organizer";

$alamat = !empty($pengaturan['alamat'])
    ? $pengaturan['alamat']
    : "Bandung, Jawa Barat";

$no_whatsapp = !empty($pengaturan['no_whatsapp'])
    ? $pengaturan['no_whatsapp']
    : "6283121710740";

$email = !empty($pengaturan['email'])
    ? $pengaturan['email']
    : "info@luxoraorganizer.com";

$instagram = !empty($pengaturan['instagram'])
    ? $pengaturan['instagram']
    : "@luxoraorganizer";


// ==================================================
// NOMOR WHATSAPP
// ==================================================

// Hilangkan spasi, +, strip, dan karakter lainnya
$nomor_whatsapp = preg_replace(
    '/[^0-9]/',
    '',
    $no_whatsapp
);


// Jika nomor dimulai dengan 0, ubah menjadi 62
if (
    substr($nomor_whatsapp, 0, 1) == '0'
) {

    $nomor_whatsapp =
        '62' .
        substr(
            $nomor_whatsapp,
            1
        );

}


// ==================================================
// PESAN WHATSAPP UNTUK TOMBOL CTA
// ==================================================

$pesan_whatsapp =
    "Halo " . $nama_website . ",\n\n" .
    "Saya ingin berkonsultasi mengenai layanan pernikahan.\n\n" .
    "Terima kasih.";


$link_whatsapp =
    "https://wa.me/" .
    $nomor_whatsapp .
    "?text=" .
    urlencode($pesan_whatsapp);

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
                LUXORA ORGANIZER
            </p>

            <h1>
                Let's Talk
            </h1>

            <p>
                Ceritakan rencana pernikahan impian
                Anda kepada kami.
            </p>

        </div>

    </div>

</section>


<!-- ==================================================
     CONTACT
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
                GET IN TOUCH
            </p>

            <h2>
                We'd Love To Hear From You
            </h2>

            <p>
                Jangan ragu untuk menghubungi kami.
                Tim Luxora siap membantu menjawab
                pertanyaan dan kebutuhan pernikahan Anda.
            </p>

        </div>


        <div
            class="contact-grid"
            style="
                display:grid;
                grid-template-columns:
                minmax(0, 1fr)
                minmax(0, 1.3fr);
                gap:40px;
                align-items:start;
            "
        >

            <!-- ==================================================
                 INFORMASI KONTAK
            ================================================== -->

            <div class="fade-left">

                <div class="card">

                    <div class="card-content">

                        <p
                            style="
                                color:#b88980;
                                letter-spacing:3px;
                            "
                        >
                            CONTACT US
                        </p>

                        <h2>
                            <?php
                            echo htmlspecialchars(
                                $nama_website
                            );
                            ?>
                        </h2>


                        <!-- ALAMAT -->

                        <div
                            style="
                                margin-top:30px;
                                padding-bottom:20px;
                                border-bottom:
                                1px solid #ead8d0;
                            "
                        >

                            <h3>
                                Address
                            </h3>

                            <p>
                                <?php
                                echo nl2br(
                                    htmlspecialchars(
                                        $alamat
                                    )
                                );
                                ?>
                            </p>

                        </div>


                        <!-- WHATSAPP -->

                        <div
                            style="
                                padding:20px 0;
                                border-bottom:
                                1px solid #ead8d0;
                            "
                        >

                            <h3>
                                WhatsApp
                            </h3>

                            <p>
                                <?php
                                echo htmlspecialchars(
                                    $no_whatsapp
                                );
                                ?>
                            </p>

                            <br>

                            <?php if (!empty($nomor_whatsapp)): ?>

                                <a
                                    href="https://wa.me/<?php echo $nomor_whatsapp; ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="btn-detail"
                                >
                                    Chat WhatsApp
                                </a>

                            <?php endif; ?>

                        </div>


                        <!-- EMAIL -->

                        <div
                            style="
                                padding:20px 0;
                                border-bottom:
                                1px solid #ead8d0;
                            "
                        >

                            <h3>
                                Email
                            </h3>

                            <p>
                                <?php
                                echo htmlspecialchars(
                                    $email
                                );
                                ?>
                            </p>

                        </div>


                        <!-- INSTAGRAM -->

                        <div
                            style="
                                padding-top:20px;
                            "
                        >

                            <h3>
                                Instagram
                            </h3>

                            <p>
                                <?php
                                echo htmlspecialchars(
                                    $instagram
                                );
                                ?>
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ==================================================
                 FORM KONSULTASI
            ================================================== -->

            <div class="fade-right">

                <div class="card">

                    <div class="card-content">

                        <p
                            style="
                                color:#b88980;
                                letter-spacing:3px;
                            "
                        >
                            CONSULTATION
                        </p>

                        <h2>
                            Tell Us About Your Wedding
                        </h2>

                        <p>
                            Isi informasi singkat berikut,
                            kemudian lanjutkan konsultasi
                            melalui WhatsApp.
                        </p>


                        <form
                            id="formKonsultasi"
                            style="
                                margin-top:25px;
                            "
                        >

                            <!-- NAMA -->

                            <div class="form-group">

                                <label for="nama">
                                    Nama Lengkap
                                </label>

                                <input
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    placeholder="Masukkan nama Anda"
                                    required
                                >

                            </div>


                            <!-- TANGGAL -->

                            <div class="form-group">

                                <label for="tanggal">
                                    Tanggal Acara
                                </label>

                                <input
                                    type="date"
                                    id="tanggal"
                                    name="tanggal"
                                    required
                                >

                            </div>


                            <!-- KONSEP -->

                            <div class="form-group">

                                <label for="konsep">
                                    Konsep Pernikahan
                                </label>

                                <select
                                    id="konsep"
                                    name="konsep"
                                    required
                                >

                                    <option value="">
                                        Pilih konsep
                                    </option>

                                    <option value="Indoor">
                                        Indoor
                                    </option>

                                    <option value="Outdoor">
                                        Outdoor
                                    </option>

                                    <option value="Intimate">
                                        Intimate
                                    </option>

                                    <option value="Traditional">
                                        Traditional
                                    </option>

                                    <option value="Modern">
                                        Modern
                                    </option>

                                    <option value="Custom">
                                        Custom
                                    </option>

                                </select>

                            </div>


                            <!-- JUMLAH TAMU -->

                            <div class="form-group">

                                <label for="tamu">
                                    Perkiraan Jumlah Tamu
                                </label>

                                <input
                                    type="number"
                                    id="tamu"
                                    name="tamu"
                                    min="1"
                                    placeholder="Contoh: 300"
                                    required
                                >

                            </div>


                            <!-- PESAN -->

                            <div class="form-group">

                                <label for="pesan">
                                    Pesan Tambahan
                                </label>

                                <textarea
                                    id="pesan"
                                    name="pesan"
                                    rows="5"
                                    placeholder="Ceritakan kebutuhan atau konsep pernikahan Anda..."
                                ></textarea>

                            </div>


                            <button
                                type="submit"
                                class="btn-detail"
                                style="
                                    border:none;
                                    cursor:pointer;
                                    width:100%;
                                "
                            >
                                Konsultasi via WhatsApp
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     JAM PELAYANAN
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
                OUR AVAILABILITY
            </p>

            <h2>
                We're Here For You
            </h2>

        </div>


        <div class="card-grid">

            <div
                class="card fade-up"
                style="
                    text-align:center;
                    transition-delay:0.1s;
                "
            >

                <div class="card-content">

                    <h3>
                        Monday - Friday
                    </h3>

                    <p>
                        09.00 - 17.00 WIB
                    </p>

                </div>

            </div>


            <div
                class="card fade-up"
                style="
                    text-align:center;
                    transition-delay:0.2s;
                "
            >

                <div class="card-content">

                    <h3>
                        Saturday
                    </h3>

                    <p>
                        09.00 - 15.00 WIB
                    </p>

                </div>

            </div>


            <div
                class="card fade-up"
                style="
                    text-align:center;
                    transition-delay:0.3s;
                "
            >

                <div class="card-content">

                    <h3>
                        Sunday
                    </h3>

                    <p>
                        By Appointment
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ==================================================
     WHATSAPP CTA
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
                HAVE A QUESTION?
            </p>

            <h2>
                Let's Start Your Story
            </h2>

            <p>
                Klik tombol di bawah dan langsung
                terhubung dengan Luxora Organizer
                melalui WhatsApp.
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
                    Chat via WhatsApp
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


<!-- ==================================================
     JAVASCRIPT
================================================== -->

<script>

document
    .getElementById("formKonsultasi")
    .addEventListener(
        "submit",
        function(event) {

            event.preventDefault();


            const nama =
                document.getElementById("nama").value;

            const tanggal =
                document.getElementById("tanggal").value;

            const konsep =
                document.getElementById("konsep").value;

            const tamu =
                document.getElementById("tamu").value;

            const pesan =
                document.getElementById("pesan").value;


            const tanggalFormat =
                tanggal
                    ? tanggal.split("-").reverse().join("-")
                    : "-";


            const pesanWA =
                "Halo Luxora Organizer,%0A%0A" +

                "Saya ingin berkonsultasi mengenai " +
                "pernikahan.%0A%0A" +

                "Nama: " +
                encodeURIComponent(nama) +
                "%0A" +

                "Tanggal Acara: " +
                encodeURIComponent(tanggalFormat) +
                "%0A" +

                "Konsep: " +
                encodeURIComponent(konsep) +
                "%0A" +

                "Jumlah Tamu: " +
                encodeURIComponent(tamu) +
                "%0A" +

                "Pesan: " +
                encodeURIComponent(pesan) +
                "%0A%0A" +

                "Terima kasih.";


            const nomor =
                "<?php echo $nomor_whatsapp; ?>";


            const url =
                "https://wa.me/" +
                nomor +
                "?text=" +
                pesanWA;


            window.open(
                url,
                "_blank"
            );

        }
    );

</script>


<?php

include "includes/footer.php";

?>