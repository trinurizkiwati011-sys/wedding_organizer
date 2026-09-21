<?php
session_start();

include "../auth.php";
include "../../config/koneksi.php";

$error = "";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM layanan WHERE id_layanan = $id LIMIT 1"
);

if (mysqli_num_rows($query) == 0) {
    header("Location: index.php");
    exit;
}

$layanan = mysqli_fetch_assoc($query);


if (isset($_POST['update'])) {

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


    if (empty($nama_layanan) || empty($deskripsi)) {

        $error = "Nama layanan dan deskripsi wajib diisi.";

    } else {

        $gambar_baru = $layanan['gambar'];


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

                $error = "Format gambar tidak valid.";

            } elseif ($ukuran > 5 * 1024 * 1024) {

                $error = "Ukuran gambar maksimal 5 MB.";

            } else {

                $gambar_baru =
                    uniqid('layanan_') . '.' . $ekstensi;

                $folder_upload = "../../assets/images/";

                if (!is_dir($folder_upload)) {
                    mkdir($folder_upload, 0777, true);
                }

                move_uploaded_file(
                    $tmp_file,
                    $folder_upload . $gambar_baru
                );


                if (
                    !empty($layanan['gambar']) &&
                    file_exists(
                        $folder_upload . $layanan['gambar']
                    )
                ) {

                    unlink(
                        $folder_upload . $layanan['gambar']
                    );
                }
            }
        }


        if (empty($error)) {

            $update = mysqli_query(
                $koneksi,
                "UPDATE layanan SET
                    nama_layanan = '$nama_layanan',
                    deskripsi = '$deskripsi',
                    gambar = '$gambar_baru',
                    status = '$status'
                WHERE id_layanan = $id"
            );


            if ($update) {

                header("Location: index.php?pesan=edit");
                exit;

            } else {

                $error =
                    "Layanan gagal diperbarui: "
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

    <title>Edit Layanan - Luxora Organizer</title>

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

        .gambar-lama {
            width: 180px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .btn-update {
            background: #c99f96;
            border: none;
            color: white;
            border-radius: 25px;
            padding: 11px 25px;
        }

        .btn-update:hover {
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
        Edit Layanan
    </h2>

    <p class="text-muted mb-4">
        Ubah informasi layanan.
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
                    value="<?php echo htmlspecialchars($layanan['nama_layanan']); ?>"
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
                    required
                ><?php echo htmlspecialchars($layanan['deskripsi']); ?></textarea>

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Gambar Saat Ini
                </label>

                <?php if (!empty($layanan['gambar'])): ?>

                    <img
                        src="../../assets/images/<?php echo htmlspecialchars($layanan['gambar']); ?>"
                        class="gambar-lama"
                        alt="Gambar Layanan"
                    >

                <?php else: ?>

                    <p class="text-muted">
                        Belum ada gambar.
                    </p>

                <?php endif; ?>

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Ganti Gambar
                </label>

                <input
                    type="file"
                    name="gambar"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti gambar.
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

                    <option
                        value="aktif"
                        <?php echo $layanan['status'] == 'aktif' ? 'selected' : ''; ?>
                    >
                        Aktif
                    </option>

                    <option
                        value="nonaktif"
                        <?php echo $layanan['status'] == 'nonaktif' ? 'selected' : ''; ?>
                    >
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
                    name="update"
                    class="btn btn-update"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>