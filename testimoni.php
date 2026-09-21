<?php

session_start();

include "config/koneksi.php";

$judul = "Testimoni - Luxora Organizer";

$error = "";
$success = "";


// ==================================================
// CEK LOGIN USER
// ==================================================

$user_login = isset($_SESSION['user_id']);


// ==================================================
// PROSES TAMBAH TESTIMONI
// ==================================================

if (isset($_POST['kirim_testimoni'])) {

    if (!$user_login) {

        $error = "Silakan login terlebih dahulu untuk memberikan testimoni.";

    } else {

        // ==========================================
        // AMBIL DATA FORM
        // ==========================================

        $nama = mysqli_real_escape_string(
            $koneksi,
            trim($_POST['nama'] ?? '')
        );

        $rating = intval($_POST['rating'] ?? 0);

        $isi_testimoni = mysqli_real_escape_string(
            $koneksi,
            trim($_POST['isi_testimoni'] ?? '')
        );

        $foto = "";


        // ==========================================
        // VALIDASI DATA DASAR
        // ==========================================

        if (
            $nama == "" ||
            $rating == 0 ||
            $isi_testimoni == ""
        ) {

            $error = "Semua data testimoni wajib diisi.";

        }

        elseif ($rating < 1 || $rating > 5) {

            $error = "Rating harus antara 1 sampai 5.";

        }

        elseif (strlen($isi_testimoni) < 5) {

            $error = "Testimoni terlalu singkat.";

        }

        // ==========================================
        // VALIDASI FOTO
        // ==========================================

        elseif (
            !isset($_FILES['foto']) ||
            $_FILES['foto']['error'] == UPLOAD_ERR_NO_FILE
        ) {

            $error = "Foto wajib diupload.";

        }

        elseif ($_FILES['foto']['error'] != UPLOAD_ERR_OK) {

            $error = "Foto gagal diupload. Silakan coba lagi.";

        }

        else {

            $nama_file = $_FILES['foto']['name'];

            $tmp_file = $_FILES['foto']['tmp_name'];

            $ukuran_file = $_FILES['foto']['size'];


            // ======================================
            // CEK EKSTENSI FOTO
            // ======================================

            $ekstensi = strtolower(
                pathinfo($nama_file, PATHINFO_EXTENSION)
            );

            $ekstensi_diizinkan = [
                'jpg',
                'jpeg',
                'png',
                'webp'
            ];


            if (!in_array($ekstensi, $ekstensi_diizinkan)) {

                $error =
                    "Format foto harus JPG, JPEG, PNG, atau WEBP.";

            }

            // ======================================
            // CEK UKURAN FOTO
            // ======================================

            elseif ($ukuran_file > 2 * 1024 * 1024) {

                $error =
                    "Ukuran foto maksimal 2 MB.";

            }

            // ======================================
            // CEK FILE BENAR-BENAR GAMBAR
            // ======================================

            elseif (getimagesize($tmp_file) === false) {

                $error =
                    "File yang diupload bukan gambar yang valid.";

            }

            else {

                // ==================================
                // FOLDER UPLOAD
                // ==================================

                $folder_upload = "assets/images/";


                if (!is_dir($folder_upload)) {

                    mkdir(
                        $folder_upload,
                        0777,
                        true
                    );

                }


                // ==================================
                // BUAT NAMA FOTO BARU
                // ==================================

                $nama_foto_baru =
                    "testimoni_" .
                    time() .
                    "_" .
                    uniqid() .
                    "." .
                    $ekstensi;


                // ==================================
                // PINDAHKAN FOTO
                // ==================================

                if (
                    move_uploaded_file(
                        $tmp_file,
                        $folder_upload . $nama_foto_baru
                    )
                ) {

                    $foto = $nama_foto_baru;

                } else {

                    $error =
                        "Foto gagal disimpan.";

                }

            }

        }


        // ==========================================
        // SIMPAN KE DATABASE
        // ==========================================

        if ($error == "" && $foto != "") {

            $query_tambah = mysqli_query(
                $koneksi,
                "INSERT INTO testimoni
                (
                    nama,
                    foto,
                    rating,
                    isi_testimoni,
                    status
                )
                VALUES
                (
                    '$nama',
                    '$foto',
                    '$rating',
                    '$isi_testimoni',
                    'menunggu'
                )"
            );


            if ($query_tambah) {

                $success =
                    "Testimoni berhasil dikirim dan sedang menunggu persetujuan admin.";

            } else {

                // ==================================
                // HAPUS FOTO JIKA DATABASE GAGAL
                // ==================================

                if (
                    file_exists(
                        $folder_upload . $foto
                    )
                ) {

                    unlink(
                        $folder_upload . $foto
                    );

                }

                $error =
                    "Testimoni gagal dikirim. Silakan coba lagi.";

            }

        }

    }

}


// ==================================================
// AMBIL DATA TESTIMONI
// HANYA YANG SUDAH DITAMPILKAN ADMIN
// ==================================================

$query_testimoni = mysqli_query(
    $koneksi,
    "SELECT *
     FROM testimoni
     WHERE status = 'ditampilkan'
     ORDER BY id_testimoni DESC"
);

?>


<?php include "includes/header.php"; ?>

<?php include "includes/navbar.php"; ?>


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
                LUXORA STORIES
            </p>

            <h1>
                What Our Clients Say
            </h1>

            <p>
                Cerita dan pengalaman dari pasangan
                yang telah mempercayakan hari istimewa
                mereka kepada Luxora Organizer.
            </p>

        </div>

    </div>

</section>


<!-- ==================================================
     FORM TESTIMONI
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
                SHARE YOUR STORY
            </p>

            <h2>
                Bagikan Pengalaman Anda
            </h2>

            <p>
                Ceritakan pengalaman Anda bersama
                Luxora Organizer.
            </p>

        </div>


        <!-- ==========================================
             PESAN ERROR
        =========================================== -->

        <?php if ($error != ""): ?>

            <div class="testimoni-message error-message">

                <?php
                echo htmlspecialchars($error);
                ?>

            </div>

        <?php endif; ?>


        <!-- ==========================================
             PESAN SUCCESS
        =========================================== -->

        <?php if ($success != ""): ?>

            <div class="testimoni-message success-message">

                <?php
                echo htmlspecialchars($success);
                ?>

            </div>

        <?php endif; ?>


        <?php if ($user_login): ?>


            <!-- ======================================
                 FORM USER
            ======================================= -->

            <div class="testimoni-form-card fade-up">

                <form
                    method="POST"
                    action=""
                    enctype="multipart/form-data"
                >


                    <!-- ==============================
                         NAMA
                    =============================== -->

                    <div class="form-group">

                        <label for="nama">
                            Nama
                        </label>

                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="<?php
                                echo htmlspecialchars(
                                    $_SESSION['user_nama'] ?? ''
                                );
                            ?>"
                            placeholder="Masukkan nama Anda"
                            required
                        >

                    </div>


                    <!-- ==============================
                         FOTO
                    =============================== -->

                    <div class="form-group">

                        <label for="foto">
                            Foto
                        </label>

                        <input
                            type="file"
                            id="foto"
                            name="foto"
                            accept="image/jpeg,image/png,image/webp"
                            required
                        >

                        <small class="foto-note">
                            Format JPG, JPEG, PNG, atau WEBP.
                            Maksimal 2 MB.
                        </small>

                    </div>


                    <!-- ==============================
                         PREVIEW FOTO
                    =============================== -->

                    <div
                        id="preview-container"
                        class="preview-container"
                    >

                        <img
                            id="preview-foto"
                            src=""
                            alt="Preview Foto"
                        >

                    </div>


                    <!-- ==============================
                         RATING
                    =============================== -->

                    <div class="form-group">

                        <label>
                            Rating
                        </label>

                        <div class="rating-input">

                            <label>

                                <input
                                    type="radio"
                                    name="rating"
                                    value="1"
                                    required
                                >

                                <span>★</span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="rating"
                                    value="2"
                                >

                                <span>★★</span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="rating"
                                    value="3"
                                >

                                <span>★★★</span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="rating"
                                    value="4"
                                >

                                <span>★★★★</span>

                            </label>


                            <label>

                                <input
                                    type="radio"
                                    name="rating"
                                    value="5"
                                >

                                <span>★★★★★</span>

                            </label>

                        </div>

                    </div>


                    <!-- ==============================
                         TESTIMONI
                    =============================== -->

                    <div class="form-group">

                        <label for="isi_testimoni">
                            Testimoni
                        </label>

                        <textarea
                            id="isi_testimoni"
                            name="isi_testimoni"
                            rows="6"
                            placeholder="Ceritakan pengalaman Anda bersama Luxora Organizer..."
                            required
                        ></textarea>

                    </div>


                    <!-- ==============================
                         BUTTON
                    =============================== -->

                    <button
                        type="submit"
                        name="kirim_testimoni"
                        class="btn-detail testimoni-button"
                    >
                        Kirim Testimoni
                    </button>


                    <p class="testimoni-note">

                        Testimoni Anda akan diperiksa oleh
                        admin sebelum ditampilkan.

                    </p>

                </form>

            </div>


        <?php else: ?>


            <!-- ======================================
                 BELUM LOGIN
            ======================================= -->

            <div class="testimoni-login-box fade-up">

                <h3>
                    Ingin memberikan testimoni?
                </h3>

                <p>
                    Silakan login terlebih dahulu untuk
                    membagikan pengalaman Anda bersama
                    Luxora Organizer.
                </p>

                <a
                    href="login.php"
                    class="btn-detail"
                >
                    Login untuk Memberikan Testimoni
                </a>

            </div>


        <?php endif; ?>

    </div>

</section>


<!-- ==================================================
     TESTIMONI
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
                KIND WORDS
            </p>

            <h2>
                Love From Our Clients
            </h2>

            <p>
                Kepuasan dan kebahagiaan setiap pasangan
                menjadi bagian penting dari perjalanan
                Luxora Organizer.
            </p>

        </div>


        <!-- ==================================================
             GRID TESTIMONI
        ================================================== -->

        <div class="testimoni-grid">

            <?php if (mysqli_num_rows($query_testimoni) > 0): ?>

                <?php

                $delay = 0.1;

                while (
                    $testimoni = mysqli_fetch_assoc(
                        $query_testimoni
                    )
                ):

                ?>

                    <div
                        class="testimoni-card fade-up"
                        style="
                            transition-delay:
                            <?php echo $delay; ?>s;
                        "
                    >

                        <!-- ==============================
                             FOTO
                        =============================== -->

                        <div class="testimoni-photo">

                            <img
                                src="assets/images/<?php
                                    echo htmlspecialchars(
                                        $testimoni['foto']
                                        ?: 'testimoni-default.jpg'
                                    );
                                ?>"
                                alt="<?php
                                    echo htmlspecialchars(
                                        $testimoni['nama']
                                    );
                                ?>"
                            >

                        </div>


                        <!-- ==============================
                             BINTANG
                        =============================== -->

                        <div class="testimoni-rating">

                            <?php

                            $rating = intval(
                                $testimoni['rating']
                            );

                            for (
                                $i = 1;
                                $i <= 5;
                                $i++
                            ) {

                                if ($i <= $rating) {

                                    echo "★";

                                } else {

                                    echo "☆";

                                }

                            }

                            ?>

                        </div>


                        <!-- ==============================
                             KOMENTAR
                        =============================== -->

                        <p class="testimoni-text">

                            “<?php

                            echo htmlspecialchars(
                                $testimoni['isi_testimoni']
                            );

                            ?>”

                        </p>


                        <!-- ==============================
                             NAMA
                        =============================== -->

                        <h3>

                            <?php

                            echo htmlspecialchars(
                                $testimoni['nama']
                            );

                            ?>

                        </h3>


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
                        Testimoni Belum Tersedia
                    </h3>

                    <p>
                        Belum ada testimoni yang
                        dapat ditampilkan.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>


<!-- ==================================================
     TESTIMONI FEATURE
================================================== -->

<section
    class="section"
    style="
        background:#ead8d0;
    "
>

    <div class="container">

        <div
            class="intro-grid"
            style="
                align-items:center;
            "
        >

            <!-- ==============================
                 TEKS
            =============================== -->

            <div class="fade-left">

                <p
                    style="
                        color:#b88980;
                        letter-spacing:3px;
                    "
                >
                    OUR PROMISE
                </p>

                <h2>
                    Your Happiness
                    Is Our Success
                </h2>

                <p>
                    Bagi kami, pernikahan bukan hanya
                    sebuah acara. Pernikahan adalah
                    cerita, perasaan, dan momen yang
                    akan dikenang sepanjang hidup.
                </p>

                <p>
                    Karena itu, kami berusaha memberikan
                    pelayanan terbaik dari tahap
                    perencanaan hingga hari pernikahan
                    Anda.
                </p>

            </div>


            <!-- ==============================
                 KARTU
            =============================== -->

            <div class="fade-right">

                <div
                    class="card"
                    style="
                        text-align:center;
                        padding:35px;
                    "
                >

                    <div
                        style="
                            font-size:45px;
                            color:#c99f96;
                            margin-bottom:10px;
                        "
                    >
                        “
                    </div>

                    <h3>
                        Every Love Story
                        Deserves A Beautiful Beginning
                    </h3>

                    <p>
                        Kami siap membantu mewujudkan
                        hari pernikahan yang sesuai
                        dengan cerita dan impian Anda.
                    </p>

                    <div
                        style="
                            font-size:45px;
                            color:#c99f96;
                            margin-top:10px;
                        "
                    >
                        ”
                    </div>

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
                YOUR STORY COULD BE NEXT
            </p>

            <h2>
                Let's Create Something Beautiful
            </h2>

            <p>
                Mari mulai merencanakan pernikahan
                impian Anda bersama Luxora Organizer.
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
     CSS FORM TESTIMONI
================================================== -->

<style>

.testimoni-form-card {

    max-width: 700px;

    margin: 0 auto 60px;

    background: #ffffff;

    padding: 40px;

    border-radius: 22px;

    box-shadow:
        0 10px 35px
        rgba(74, 48, 43, 0.10);

}


.testimoni-form-card .form-group {

    margin-bottom: 22px;

}


.testimoni-form-card label {

    display: block;

    margin-bottom: 8px;

    color: #4a302b;

    font-weight: 600;

}


.testimoni-form-card input[type="text"],
.testimoni-form-card textarea {

    width: 100%;

    box-sizing: border-box;

    padding: 13px 15px;

    border: 1px solid #d9bbb2;

    border-radius: 10px;

    background: #ffffff;

    color: #4a302b;

    font-family: "Crimson Text", serif;

    font-size: 16px;

    outline: none;

}


.testimoni-form-card textarea {

    resize: vertical;

}


.testimoni-form-card input[type="text"]:focus,
.testimoni-form-card textarea:focus {

    border-color: #c99f96;

    box-shadow:
        0 0 0 3px
        rgba(201, 159, 150, 0.15);

}


/* ==========================================
   INPUT FOTO
========================================== */

.testimoni-form-card input[type="file"] {

    width: 100%;

    box-sizing: border-box;

    padding: 12px;

    border: 1px solid #d9bbb2;

    border-radius: 10px;

    background: #fff8f3;

    color: #4a302b;

    font-family: "Crimson Text", serif;

    cursor: pointer;

}


.testimoni-form-card input[type="file"]:focus {

    border-color: #c99f96;

    outline: none;

    box-shadow:
        0 0 0 3px
        rgba(201, 159, 150, 0.15);

}


.foto-note {

    display: block;

    margin-top: 7px;

    color: #765b54;

    font-size: 13px;

}


/* ==========================================
   PREVIEW FOTO
========================================== */

.preview-container {

    display: none;

    margin-top: -5px;

    margin-bottom: 25px;

    text-align: center;

}


.preview-container img {

    width: 150px;

    height: 150px;

    object-fit: cover;

    border-radius: 50%;

    border: 4px solid #ead5ca;

    box-shadow:
        0 8px 20px
        rgba(74, 48, 43, 0.12);

}


/* ==========================================
   RATING
========================================== */

.rating-input {

    display: flex;

    flex-wrap: wrap;

    gap: 8px;

}


.rating-input label {

    margin: 0;

}


.rating-input input {

    display: none;

}


.rating-input span {

    display: inline-block;

    padding: 8px 12px;

    border: 1px solid #d9bbb2;

    border-radius: 8px;

    color: #c99f96;

    cursor: pointer;

    background: #fff8f3;

    transition: 0.3s ease;

}


.rating-input span:hover {

    background: #ead8d0;

    border-color: #c99f96;

}


.rating-input input:checked + span {

    background: #c99f96;

    color: #ffffff;

    border-color: #c99f96;

}


/* ==========================================
   BUTTON
========================================== */

.testimoni-button {

    width: 100%;

    border: none;

    cursor: pointer;

}


/* ==========================================
   NOTE
========================================== */

.testimoni-note {

    text-align: center;

    color: #765b54;

    font-size: 14px;

    margin-top: 15px;

}


/* ==========================================
   MESSAGE
========================================== */

.testimoni-message {

    max-width: 700px;

    margin: 0 auto 25px;

    padding: 15px 20px;

    border-radius: 10px;

    text-align: center;

}


.error-message {

    background: #f8e1dc;

    color: #8a4b42;

}


.success-message {

    background: #e4f2e8;

    color: #496b54;

}


/* ==========================================
   LOGIN BOX
========================================== */

.testimoni-login-box {

    max-width: 700px;

    margin: 0 auto 60px;

    padding: 35px;

    text-align: center;

    background: #ffffff;

    border-radius: 22px;

    box-shadow:
        0 10px 35px
        rgba(74, 48, 43, 0.10);

}


.testimoni-login-box h3 {

    margin-bottom: 10px;

}


.testimoni-login-box p {

    color: #765b54;

    margin-bottom: 25px;

}


/* ==========================================
   RESPONSIVE
========================================== */

@media (max-width: 600px) {

    .testimoni-form-card {

        padding: 25px 20px;

    }


    .rating-input {

        gap: 5px;

    }


    .rating-input span {

        padding: 7px 9px;

        font-size: 14px;

    }


    .preview-container img {

        width: 120px;

        height: 120px;

    }

}

</style>


<!-- ==================================================
     JAVASCRIPT PREVIEW FOTO
================================================== -->

<script>

const inputFoto = document.getElementById("foto");

const previewContainer =
    document.getElementById("preview-container");

const previewFoto =
    document.getElementById("preview-foto");


if (inputFoto) {

    inputFoto.addEventListener(
        "change",
        function () {

            const file = this.files[0];

            if (!file) {

                previewContainer.style.display = "none";

                previewFoto.src = "";

                return;

            }


            // ======================================
            // CEK UKURAN
            // ======================================

            if (file.size > 2 * 1024 * 1024) {

                alert("Ukuran foto maksimal 2 MB.");

                this.value = "";

                previewContainer.style.display = "none";

                previewFoto.src = "";

                return;

            }


            // ======================================
            // CEK FORMAT
            // ======================================

            const formatDiizinkan = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];


            if (!formatDiizinkan.includes(file.type)) {

                alert(
                    "Format foto harus JPG, JPEG, PNG, atau WEBP."
                );

                this.value = "";

                previewContainer.style.display = "none";

                previewFoto.src = "";

                return;

            }


            // ======================================
            // TAMPILKAN PREVIEW
            // ======================================

            const reader = new FileReader();


            reader.onload = function (e) {

                previewFoto.src = e.target.result;

                previewContainer.style.display = "block";

            };


            reader.readAsDataURL(file);

        }
    );

}

</script>


<?php

include "includes/footer.php";

?>