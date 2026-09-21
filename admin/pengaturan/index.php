<?php

include "../auth.php";
include "../../config/koneksi.php";

$error = "";
$success = "";


/* =========================
   AMBIL DATA PENGATURAN
========================= */

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM pengaturan
     ORDER BY id_pengaturan ASC
     LIMIT 1"
);

$data = mysqli_fetch_assoc($query);


/* =========================
   JIKA DATA BELUM ADA
========================= */

if (!$data) {

    $insert_awal = mysqli_query(
        $koneksi,
        "INSERT INTO pengaturan (nama_wo)
         VALUES ('Luxora Organizer')"
    );

    if ($insert_awal) {

        $query = mysqli_query(
            $koneksi,
            "SELECT * FROM pengaturan
             ORDER BY id_pengaturan ASC
             LIMIT 1"
        );

        $data = mysqli_fetch_assoc($query);

    }

}


/* =========================
   PROSES UPDATE
========================= */

if (isset($_POST['simpan'])) {

    $id_pengaturan = (int) $_POST['id_pengaturan'];

    $nama_wo = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['nama_wo'])
    );

    $slogan = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['slogan'])
    );

    $deskripsi = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['deskripsi'])
    );

    $alamat = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['alamat'])
    );

    $no_whatsapp = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['no_whatsapp'])
    );

    $email = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['email'])
    );

    $instagram = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['instagram'])
    );

    $facebook = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['facebook'])
    );

    $jam_operasional = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['jam_operasional'])
    );

    $maps = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['maps'])
    );


    /* =========================
       VALIDASI
    ========================= */

    if ($nama_wo == "") {

        $error = "Nama WO wajib diisi.";

    } elseif (
        !empty($email) &&
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {

        $error = "Format email tidak valid.";

    }




    /* =========================
       UPDATE DATA
    ========================= */

    if ($error == "") {

        $update = mysqli_query(
            $koneksi,
            "UPDATE pengaturan SET

                nama_wo = '$nama_wo',
                slogan = '$slogan',
                deskripsi = '$deskripsi',
                alamat = '$alamat',
                no_whatsapp = '$no_whatsapp',
                email = '$email',
                instagram = '$instagram',
                facebook = '$facebook',
                jam_operasional = '$jam_operasional',
                maps = '$maps'

             WHERE id_pengaturan = $id_pengaturan"
        );


        if ($update) {

            $success = "Pengaturan berhasil disimpan.";


            /* AMBIL ULANG DATA */

            $query = mysqli_query(
                $koneksi,
                "SELECT * FROM pengaturan
                 WHERE id_pengaturan = $id_pengaturan
                 LIMIT 1"
            );

            $data = mysqli_fetch_assoc($query);

        } else {

            $error = "Pengaturan gagal disimpan.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pengaturan - Luxora Organizer
    </title>


    <!-- BOOTSTRAP -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- BOOTSTRAP ICON -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    <style>

        body {

            background: #fff8f3;

            color: #4a302b;

        }


        .container-admin {

            width: 92%;

            max-width: 1000px;

            margin: 40px auto;

        }


        .page-title {

            color: #4a302b;

            font-weight: 600;

        }


        .page-description {

            color: #765b54;

        }


        .card-form {

            background: white;

            border-radius: 20px;

            padding: 30px;

            box-shadow:
                0 5px 20px
                rgba(74, 48, 43, 0.08);

        }


        .section-title {

            font-size: 20px;

            font-weight: 600;

            color: #4a302b;

            margin-bottom: 20px;

            padding-bottom: 10px;

            border-bottom:
                1px solid #ead5ca;

        }


        .form-label {

            font-weight: 600;

            color: #4a302b;

        }


        .form-control,
        .form-select {

            border-radius: 10px;

            border:
                1px solid #d9bbb2;

            padding: 10px 13px;

        }


        .form-control:focus,
        .form-select:focus {

            border-color: #c99f96;

            box-shadow:
                0 0 0 0.2rem
                rgba(201, 159, 150, 0.2);

        }


        textarea {

            min-height: 120px;

            resize: vertical;

        }


        .btn-kembali {

            background: #ead5ca;

            border: none;

            color: #4a302b;

            padding: 8px 18px;

            border-radius: 25px;

            text-decoration: none;

        }


        .btn-kembali:hover {

            background: #d9bbb2;

            color: #4a302b;

        }


        .btn-simpan {

            background: #c99f96;

            color: white;

            border: none;

            padding: 11px 28px;

            border-radius: 25px;

        }


        .btn-simpan:hover {

            background: #b88980;

            color: white;

        }


        .logo-preview {

            width: 130px;

            height: 130px;

            object-fit: contain;

            border-radius: 15px;

            border:
                1px solid #ead5ca;

            background: #fff8f3;

            padding: 10px;

            margin-bottom: 15px;

        }


        .logo-empty {

            width: 130px;

            height: 130px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 15px;

            border:
                1px dashed #d9bbb2;

            background: #fff8f3;

            color: #b88980;

            margin-bottom: 15px;

        }


        .info-box {

            background: #fff8f3;

            border-left:
                4px solid #c99f96;

            padding: 15px;

            border-radius: 10px;

            color: #765b54;

        }


        .required {

            color: #b88980;

        }

    </style>

</head>


<body>


<div class="container-admin">


    <!-- KEMBALI -->

    <a
        href="../index.php"
        class="btn btn-kembali mb-4"
    >

        <i class="bi bi-arrow-left"></i>

        Kembali ke Dashboard

    </a>


    <!-- JUDUL -->

    <div class="mb-4">

        <h2 class="page-title mb-1">

            <i class="bi bi-gear"></i>

            Pengaturan Website

        </h2>

        <p class="page-description mb-0">

            Atur informasi utama Luxora Organizer yang ditampilkan pada website.

        </p>

    </div>


    <!-- PESAN BERHASIL -->

    <?php if ($success != ""): ?>

        <div
            class="alert alert-success alert-dismissible fade show"
            role="alert"
        >

            <i class="bi bi-check-circle-fill"></i>

            <?php echo htmlspecialchars($success); ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <!-- PESAN ERROR -->

    <?php if ($error != ""): ?>

        <div
            class="alert alert-danger alert-dismissible fade show"
            role="alert"
        >

            <i class="bi bi-exclamation-circle-fill"></i>

            <?php echo htmlspecialchars($error); ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            ></button>

        </div>

    <?php endif; ?>


    <!-- FORM -->

    <div class="card-form">


        <form
            method="POST"
            enctype="multipart/form-data"
        >


            <input
                type="hidden"
                name="id_pengaturan"
                value="<?php echo (int) $data['id_pengaturan']; ?>"
            >


            <!-- =====================
                 INFORMASI UTAMA
            ====================== -->

            <div class="section-title">

                <i class="bi bi-building"></i>

                Informasi Utama

            </div>


            <!-- NAMA WO -->

            <div class="mb-3">

                <label class="form-label">

                    Nama WO

                    <span class="required">*</span>

                </label>

                <input
                    type="text"
                    name="nama_wo"
                    class="form-control"
                    value="<?php echo htmlspecialchars($data['nama_wo'] ?? ''); ?>"
                    placeholder="Contoh: Luxora Organizer"
                    required
                >

            </div>


            <!-- SLOGAN -->

            <div class="mb-3">

                <label class="form-label">

                    Slogan

                </label>

                <input
                    type="text"
                    name="slogan"
                    class="form-control"
                    value="<?php echo htmlspecialchars($data['slogan'] ?? ''); ?>"
                    placeholder="Contoh: We Design. You Celebrate."
                >

            </div>


            <!-- DESKRIPSI -->

            <div class="mb-4">

                <label class="form-label">

                    Deskripsi

                </label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    placeholder="Tuliskan deskripsi tentang wedding organizer..."
                ><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>

            </div>
            <div class="mb-4">

                <label class="form-label">

                    Ganti Logo

                </label>

                <input
                    type="file"
                    name="logo"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="text-muted">

                    Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.

                </small>

            </div>


            <!-- =====================
                 KONTAK
            ====================== -->

            <div class="section-title mt-4">

                <i class="bi bi-telephone"></i>

                Informasi Kontak

            </div>


            <div class="row">


                <!-- WHATSAPP -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        No. WhatsApp

                    </label>

                    <input
                        type="text"
                        name="no_whatsapp"
                        class="form-control"
                        value="<?php echo htmlspecialchars($data['no_whatsapp'] ?? ''); ?>"
                        placeholder="Contoh: 628123456789"
                    >

                </div>


                <!-- EMAIL -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>"
                        placeholder="Contoh: info@luxora.com"
                    >

                </div>


            </div>


            <!-- ALAMAT -->

            <div class="mb-4">

                <label class="form-label">

                    Alamat

                </label>

                <textarea
                    name="alamat"
                    class="form-control"
                    placeholder="Masukkan alamat Luxora Organizer..."
                ><?php echo htmlspecialchars($data['alamat'] ?? ''); ?></textarea>

            </div>


            <!-- =====================
                 SOSIAL MEDIA
            ====================== -->

            <div class="section-title mt-4">

                <i class="bi bi-share"></i>

                Sosial Media

            </div>


            <div class="row">


                <!-- INSTAGRAM -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        <i class="bi bi-instagram"></i>

                        Instagram

                    </label>

                    <input
                        type="text"
                        name="instagram"
                        class="form-control"
                        value="<?php echo htmlspecialchars($data['instagram'] ?? ''); ?>"
                        placeholder="@luxoraorganizer"
                    >

                </div>


                <!-- FACEBOOK -->

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        <i class="bi bi-facebook"></i>

                        Facebook

                    </label>

                    <input
                        type="text"
                        name="facebook"
                        class="form-control"
                        value="<?php echo htmlspecialchars($data['facebook'] ?? ''); ?>"
                        placeholder="Luxora Organizer"
                    >

                </div>


            </div>


            <!-- =====================
                 OPERASIONAL
            ====================== -->

            <div class="section-title mt-4">

                <i class="bi bi-clock"></i>

                Jam Operasional

            </div>


            <div class="mb-4">

                <label class="form-label">

                    Jam Operasional

                </label>

                <input
                    type="text"
                    name="jam_operasional"
                    class="form-control"
                    value="<?php echo htmlspecialchars($data['jam_operasional'] ?? ''); ?>"
                    placeholder="Contoh: Senin - Sabtu, 08.00 - 17.00"
                >

            </div>


            <!-- =====================
                 GOOGLE MAPS
            ====================== -->

            <div class="section-title mt-4">

                <i class="bi bi-geo-alt"></i>

                Lokasi / Google Maps

            </div>


            <div class="mb-4">

                <label class="form-label">

                    Link Google Maps / Embed Maps

                </label>

                <textarea
                    name="maps"
                    class="form-control"
                    placeholder="Masukkan link Google Maps atau kode embed Google Maps..."
                ><?php echo htmlspecialchars($data['maps'] ?? ''); ?></textarea>

            </div>


            <!-- INFO -->

            <div class="info-box mb-4">

                <i class="bi bi-info-circle"></i>

                Data pengaturan ini dapat digunakan pada halaman
                <strong>Beranda, Tentang, Kontak, Navbar,</strong>
                dan bagian website lainnya.

            </div>


            <!-- BUTTON -->

            <div class="d-flex gap-2">

                <a
                    href="../index.php"
                    class="btn btn-secondary"
                >

                    Batal

                </a>


                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-simpan"
                >

                    <i class="bi bi-save"></i>

                    Simpan Pengaturan

                </button>

            </div>


        </form>


    </div>


</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


</body>

</html>