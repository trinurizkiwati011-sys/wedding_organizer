<?php
session_start();

include "../auth.php";
include "../../config/koneksi.php";

$error = "";

if (isset($_POST['simpan'])) {

    $nama_paket = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['nama_paket'])
    );

    $harga = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['harga'])
    );

    $deskripsi = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['deskripsi'])
    );

    $fasilitas = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['fasilitas'])
    );

    $status = mysqli_real_escape_string(
        $koneksi,
        $_POST['status']
    );

    // Validasi
    if (
        empty($nama_paket) ||
        empty($harga) ||
        empty($deskripsi) ||
        empty($fasilitas)
    ) {

        $error = "Semua data wajib diisi.";

    } else {

        // Upload gambar
        $gambar = "";

        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

            $nama_file = $_FILES['gambar']['name'];
            $tmp_file = $_FILES['gambar']['tmp_name'];
            $ukuran = $_FILES['gambar']['size'];

            $ekstensi = strtolower(
                pathinfo($nama_file, PATHINFO_EXTENSION)
            );

            $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];

            if (!in_array($ekstensi, $ekstensi_valid)) {

                $error = "Format gambar harus JPG, JPEG, PNG, atau WEBP.";

            } elseif ($ukuran > 5 * 1024 * 1024) {

                $error = "Ukuran gambar maksimal 5 MB.";

            } else {

                $gambar = uniqid('paket_') . '.' . $ekstensi;

                $folder_upload = "../../assets/images/";

                if (!is_dir($folder_upload)) {
                    mkdir($folder_upload, 0777, true);
                }

                move_uploaded_file(
                    $tmp_file,
                    $folder_upload . $gambar
                );
            }
        }

        if (empty($error)) {

            $query = mysqli_query(
                $koneksi,
                "INSERT INTO paket
                (nama_paket, harga, deskripsi, fasilitas, gambar, status)
                VALUES
                ('$nama_paket', '$harga', '$deskripsi', '$fasilitas', '$gambar', '$status')"
            );

            if ($query) {

                header("Location: index.php?pesan=tambah");
                exit;

            } else {

                $error = "Data paket gagal disimpan: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Paket - Luxora Organizer</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #fff8f3;
            color: #4a302b;
        }

        .container-admin {
            width: 92%;
            max-width: 900px;
            margin: 40px auto;
        }

        .form-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(74, 48, 43, 0.08);
        }

        .page-title {
            color: #4a302b;
            font-weight: 600;
        }

        .form-label {
            font-weight: 600;
            color: #4a302b;
        }

        .form-control,
        .form-select {
            border: 1px solid #d9bbb2;
            border-radius: 10px;
            padding: 11px 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #c99f96;
            box-shadow: 0 0 0 0.2rem rgba(201, 159, 150, 0.2);
        }

        textarea {
            min-height: 130px;
            resize: vertical;
        }

        .btn-simpan {
            background: #c99f96;
            border: none;
            color: white;
            padding: 11px 25px;
            border-radius: 25px;
        }

        .btn-simpan:hover {
            background: #b88980;
            color: white;
        }

        .btn-kembali {
            background: #ead5ca;
            border: none;
            color: #4a302b;
            padding: 11px 25px;
            border-radius: 25px;
        }

        .btn-kembali:hover {
            background: #d9bbb2;
            color: #4a302b;
        }

    </style>

</head>

<body>

<div class="container-admin">

    <div class="mb-4">

        <h2 class="page-title">
            <i class="bi bi-plus-circle"></i>
            Tambah Paket
        </h2>

        <p class="text-muted">
            Tambahkan paket wedding organizer baru.
        </p>

    </div>


    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle"></i>
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <div class="form-card">

        <form
            method="POST"
            enctype="multipart/form-data"
        >

            <div class="mb-3">

                <label class="form-label">
                    Nama Paket
                </label>

                <input
                    type="text"
                    name="nama_paket"
                    class="form-control"
                    placeholder="Contoh: Paket Gold"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Harga
                </label>

                <input
                    type="number"
                    name="harga"
                    class="form-control"
                    placeholder="Contoh: 25000000"
                    min="0"
                    required
                >

                <small class="text-muted">
                    Masukkan harga tanpa titik atau koma.
                </small>

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    placeholder="Tuliskan deskripsi paket..."
                    required
                ></textarea>

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Fasilitas
                </label>

                <textarea
                    name="fasilitas"
                    class="form-control"
                    placeholder="Contoh: Dekorasi, catering, makeup, dokumentasi..."
                    required
                ></textarea>

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Gambar Paket
                </label>

                <input
                    type="file"
                    name="gambar"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="text-muted">
                    Format JPG, JPEG, PNG, WEBP. Maksimal 5 MB.
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    class="form-select"
                >

                    <option value="aktif">
                        Aktif
                    </option>

                    <option value="nonaktif">
                        Nonaktif
                    </option>

                </select>

            </div>


            <div class="d-flex gap-2">

                <a
                    href="index.php"
                    class="btn btn-kembali"
                >
                    <i class="bi bi-arrow-left"></i>
                    Kembali
                </a>

                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-simpan"
                >
                    <i class="bi bi-save"></i>
                    Simpan Paket
                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>