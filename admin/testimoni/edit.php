<?php
include "../auth.php";
include "../../config/koneksi.php";


if (
    !isset($_GET['id']) ||
    !is_numeric($_GET['id'])
) {
    header("Location: index.php");
    exit;
}


$id = (int) $_GET['id'];


$query = mysqli_query(
    $koneksi,
    "SELECT * FROM testimoni
     WHERE id_testimoni = $id
     LIMIT 1"
);


if (mysqli_num_rows($query) == 0) {

    header("Location: index.php");
    exit;

}


$data = mysqli_fetch_assoc($query);

$error = "";


if (isset($_POST['update'])) {

    $nama = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['nama'])
    );

    $rating = (int) $_POST['rating'];

    $isi_testimoni = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['isi_testimoni'])
    );

    $status = mysqli_real_escape_string(
        $koneksi,
        $_POST['status']
    );


    if ($nama == "") {

        $error = "Nama wajib diisi.";

    } elseif ($rating < 1 || $rating > 5) {

        $error = "Rating harus antara 1 sampai 5.";

    } elseif ($isi_testimoni == "") {

        $error = "Isi testimoni wajib diisi.";

    } else {

        $foto_lama = $data['foto'];

        $foto = $foto_lama;


        /* JIKA GANTI FOTO */

        if (
            isset($_FILES['foto']) &&
            $_FILES['foto']['error'] == 0
        ) {

            $nama_file = $_FILES['foto']['name'];
            $tmp_file = $_FILES['foto']['tmp_name'];
            $ukuran = $_FILES['foto']['size'];

            $ekstensi = strtolower(
                pathinfo($nama_file, PATHINFO_EXTENSION)
            );

            $ekstensi_diperbolehkan = [
                'jpg',
                'jpeg',
                'png',
                'webp'
            ];


            if (!in_array($ekstensi, $ekstensi_diperbolehkan)) {

                $error = "Format foto harus JPG, JPEG, PNG, atau WEBP.";

            } elseif ($ukuran > 5 * 1024 * 1024) {

                $error = "Ukuran foto maksimal 5 MB.";

            } else {

                $foto_baru =
                    time() . '_' .
                    uniqid() . '.' .
                    $ekstensi;

                $folder = "../../assets/images/";


                if (
                    move_uploaded_file(
                        $tmp_file,
                        $folder . $foto_baru
                    )
                ) {

                    $foto = $foto_baru;


                    /* HAPUS FOTO LAMA */

                    if (
                        !empty($foto_lama) &&
                        $foto_lama != "testimoni-default.jpg" &&
                        file_exists($folder . $foto_lama)
                    ) {

                        unlink($folder . $foto_lama);

                    }

                } else {

                    $error = "Foto baru gagal diupload.";

                }

            }

        }


        /* UPDATE */

        if ($error == "") {

            $update = mysqli_query(
                $koneksi,
                "UPDATE testimoni SET

                    nama = '$nama',
                    foto = '$foto',
                    rating = '$rating',
                    isi_testimoni = '$isi_testimoni',
                    status = '$status'

                WHERE id_testimoni = $id"
            );


            if ($update) {

                header("Location: index.php?pesan=edit");
                exit;

            } else {

                $error = "Data testimoni gagal diperbarui.";

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

    <title>Edit Testimoni - Luxora Organizer</title>

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

        .card-form {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(74,48,43,.08);
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

        .btn-update {
            background: #c99f96;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
        }

        .btn-update:hover {
            background: #b88980;
            color: white;
        }

        .preview {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .form-label {
            font-weight: 600;
        }

    </style>

</head>

<body>

<div class="container-admin">


    <a
        href="index.php"
        class="btn btn-kembali mb-4"
    >
        ← Kembali ke Testimoni
    </a>


    <div class="card-form">

        <h2 class="mb-2">
            Edit Testimoni
        </h2>

        <p class="text-muted mb-4">
            Perbarui data testimoni pelanggan.
        </p>


        <?php if ($error != ""): ?>

            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
            enctype="multipart/form-data"
        >


            <!-- NAMA -->

            <div class="mb-3">

                <label class="form-label">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="<?php echo htmlspecialchars($data['nama']); ?>"
                    required
                >

            </div>


            <!-- FOTO LAMA -->

            <div class="mb-3">

                <label class="form-label d-block">
                    Foto Saat Ini
                </label>


                <?php

                $foto_sekarang = $data['foto'] ?? '';

                if (
                    empty($foto_sekarang) ||
                    $foto_sekarang == "testimoni-default.jpg"
                ):

                ?>

                    <img
                        src="../../assets/images/testimoni-default.jpg"
                        class="preview"
                        alt="Foto default"
                    >

                <?php else: ?>

                    <img
                        src="../../assets/images/<?php echo htmlspecialchars($foto_sekarang); ?>"
                        class="preview"
                        alt="Foto <?php echo htmlspecialchars($data['nama']); ?>"
                    >

                <?php endif; ?>

            </div>


            <!-- GANTI FOTO -->

            <div class="mb-3">

                <label class="form-label">
                    Ganti Foto
                </label>

                <input
                    type="file"
                    name="foto"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="text-muted">
                    Kosongkan jika tidak ingin mengganti foto.
                </small>

            </div>


            <!-- RATING -->

            <div class="mb-3">

                <label class="form-label">
                    Rating
                </label>

                <select
                    name="rating"
                    class="form-select"
                    required
                >

                    <option
                        value="5"
                        <?php echo ($data['rating'] == 5) ? 'selected' : ''; ?>
                    >
                        ★★★★★ - 5
                    </option>

                    <option
                        value="4"
                        <?php echo ($data['rating'] == 4) ? 'selected' : ''; ?>
                    >
                        ★★★★☆ - 4
                    </option>

                    <option
                        value="3"
                        <?php echo ($data['rating'] == 3) ? 'selected' : ''; ?>
                    >
                        ★★★☆☆ - 3
                    </option>

                    <option
                        value="2"
                        <?php echo ($data['rating'] == 2) ? 'selected' : ''; ?>
                    >
                        ★★☆☆☆ - 2
                    </option>

                    <option
                        value="1"
                        <?php echo ($data['rating'] == 1) ? 'selected' : ''; ?>
                    >
                        ★☆☆☆☆ - 1
                    </option>

                </select>

            </div>


            <!-- ISI -->

            <div class="mb-3">

                <label class="form-label">
                    Isi Testimoni
                </label>

                <textarea
                    name="isi_testimoni"
                    class="form-control"
                    rows="6"
                    required
                ><?php echo htmlspecialchars($data['isi_testimoni']); ?></textarea>

            </div>


            <!-- STATUS -->

            <div class="mb-4">

                <label class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    class="form-select"
                >

                    <option
                        value="menunggu"
                        <?php echo ($data['status'] == 'menunggu') ? 'selected' : ''; ?>
                    >
                        Menunggu
                    </option>

                    <option
                        value="ditampilkan"
                        <?php echo ($data['status'] == 'ditampilkan') ? 'selected' : ''; ?>
                    >
                        Ditampilkan
                    </option>

                    <option
                        value="disembunyikan"
                        <?php echo ($data['status'] == 'disembunyikan') ? 'selected' : ''; ?>
                    >
                        Disembunyikan
                    </option>

                </select>

            </div>


            <!-- BUTTON -->

            <div class="d-flex gap-2">

                <a
                    href="index.php"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    name="update"
                    class="btn btn-update"
                >
                    Update Testimoni
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>