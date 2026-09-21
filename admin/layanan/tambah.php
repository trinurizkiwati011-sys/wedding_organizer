<?php
session_start();

include "../auth.php";
include "../../config/koneksi.php";

$error = "";

if (isset($_POST['simpan'])) {

    $nama_layanan = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['nama_layanan'])
    );

    $deskripsi = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['deskripsi'])
    );

    $status = mysqli_real_escape_string(
        $koneksi,
        $_POST['status']
    );

    $gambar = "";


    if (empty($nama_layanan) || empty($deskripsi)) {

        $error = "Nama layanan dan deskripsi wajib diisi.";

    } else {

        if (
            isset($_FILES['gambar']) &&
            $_FILES['gambar']['error'] == 0
        ) {

            $nama_file = $_FILES['gambar']['name'];
            $tmp_file = $_FILES['gambar']['tmp_name'];
            $ukuran = $_FILES['gambar']['size'];

            $ekstensi = strtolower(
                pathinfo($nama_file, PATHINFO_EXTENSION)
            );

            $ekstensi_valid = [
                'jpg',
                'jpeg',
                'png',
                'webp'
            ];

            if (!in_array($ekstensi, $ekstensi_valid)) {

                $error = "Format gambar harus JPG, JPEG, PNG, atau WEBP.";

            } elseif ($ukuran > 5 * 1024 * 1024) {

                $error = "Ukuran gambar maksimal 5 MB.";

            } else {

                $gambar = uniqid('layanan_') . '.' . $ekstensi;

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
                "INSERT INTO layanan
                (nama_layanan, deskripsi, gambar, status)
                VALUES
                ('$nama_layanan', '$deskripsi', '$gambar', '$status')"
            );

            if ($query) {

                header("Location: index.php?pesan=tambah");
                exit;

            } else {

                $error =
                    "Layanan gagal disimpan: "
                    . mysqli_error($koneksi);
            }
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

    <title>Tambah Layanan - Luxora Organizer</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: #fff8f3;
            color: #4a302b;
        }

        .container-admin {
            width: 92%;
            max-width: 850px;
            margin: 40px auto;
        }

        .form-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(74,48,43,.08);
        }

        .form-label {
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border: 1px solid #d9bbb2;
            border-radius: 10px;
            padding: 11px 14px;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        .btn-simpan {
            background: #c99f96;
            border: none;
            color: white;
            border-radius: 25px;
            padding: 11px 25px;
        }

        .btn-simpan:hover {
            background: #b88980;
            color: white;
        }

        .btn-kembali {
            background: #ead5ca;
            border: none;
            color: #4a302b;
            border-radius: 25px;
            padding: 11px 25px;
        }

    </style>

</head>

<body>

<div class="container-admin">

    <h2 class="mb-1">
        Tambah Layanan
    </h2>

    <p class="text-muted mb-4">
        Tambahkan layanan baru.
    </p>


    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">
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
                    Nama Layanan
                </label>

                <input
                    type="text"
                    name="nama_layanan"
                    class="form-control"
                    placeholder="Contoh: Wedding Organizer"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    placeholder="Tuliskan deskripsi layanan..."
                    required
                ></textarea>

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Gambar
                </label>

                <input
                    type="file"
                    name="gambar"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="text-muted">
                    Maksimal 5 MB.
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
                    Kembali
                </a>

                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-simpan"
                >
                    Simpan Layanan
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>