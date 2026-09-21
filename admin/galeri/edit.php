<?php
include "../auth.php";
include "../../config/koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM galeri WHERE id_galeri = $id LIMIT 1"
);

if (mysqli_num_rows($query) == 0) {
    header("Location: index.php");
    exit;
}

$data = mysqli_fetch_assoc($query);

$error = "";


if (isset($_POST['update'])) {

    $judul = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['judul'])
    );

    $kategori = mysqli_real_escape_string(
        $koneksi,
        $_POST['kategori']
    );

    $deskripsi = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['deskripsi'])
    );

    $status = mysqli_real_escape_string(
        $koneksi,
        $_POST['status']
    );


    if ($judul == "") {

        $error = "Judul galeri wajib diisi.";

    } else {

        $gambar_lama = $data['gambar'];
        $nama_baru = $gambar_lama;


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

            $ekstensi_diperbolehkan = [
                'jpg',
                'jpeg',
                'png',
                'webp'
            ];


            if (!in_array($ekstensi, $ekstensi_diperbolehkan)) {

                $error = "Format gambar harus JPG, JPEG, PNG, atau WEBP.";

            } elseif ($ukuran > 5 * 1024 * 1024) {

                $error = "Ukuran gambar maksimal 5 MB.";

            } else {

                $nama_baru = time() . '_' . uniqid() . '.' . $ekstensi;

                $folder = "../../assets/images/";

                if (move_uploaded_file($tmp_file, $folder . $nama_baru)) {

                    if (
                        !empty($gambar_lama) &&
                        file_exists($folder . $gambar_lama)
                    ) {
                        unlink($folder . $gambar_lama);
                    }

                } else {

                    $error = "Gambar baru gagal diupload.";
                    $nama_baru = $gambar_lama;
                }
            }
        }


        if ($error == "") {

            $update = mysqli_query(
                $koneksi,
                "UPDATE galeri SET
                    judul = '$judul',
                    gambar = '$nama_baru',
                    kategori = '$kategori',
                    deskripsi = '$deskripsi',
                    status = '$status'
                WHERE id_galeri = $id"
            );


            if ($update) {

                header("Location: index.php?pesan=edit");
                exit;

            } else {

                $error = "Data gagal diperbarui.";
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

    <title>Edit Galeri - Luxora Organizer</title>

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
            width: 180px;
            height: 130px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .form-label {
            font-weight: 600;
        }

    </style>

</head>

<body>

<div class="container-admin">

    <a href="index.php" class="btn btn-kembali mb-4">
        ← Kembali ke Galeri
    </a>


    <div class="card-form">

        <h2 class="mb-2">
            Edit Galeri
        </h2>

        <p class="text-muted mb-4">
            Perbarui data galeri Luxora Organizer.
        </p>


        <?php if ($error != ""): ?>

            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST" enctype="multipart/form-data">


            <div class="mb-3">

                <label class="form-label">
                    Judul Galeri
                </label>

                <input
                    type="text"
                    name="judul"
                    class="form-control"
                    value="<?php echo htmlspecialchars($data['judul']); ?>"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Kategori
                </label>

                <select name="kategori" class="form-select">

                    <option value="akad"
                        <?php echo ($data['kategori'] == 'akad') ? 'selected' : ''; ?>>
                        Akad
                    </option>

                    <option value="resepsi"
                        <?php echo ($data['kategori'] == 'resepsi') ? 'selected' : ''; ?>>
                        Resepsi
                    </option>

                    <option value="dekorasi"
                        <?php echo ($data['kategori'] == 'dekorasi') ? 'selected' : ''; ?>>
                        Dekorasi
                    </option>

                    <option value="makeup"
                        <?php echo ($data['kategori'] == 'makeup') ? 'selected' : ''; ?>>
                        Makeup
                    </option>

                    <option value="prewedding"
                        <?php echo ($data['kategori'] == 'prewedding') ? 'selected' : ''; ?>>
                        Prewedding
                    </option>

                    <option value="lainnya"
                        <?php echo ($data['kategori'] == 'lainnya') ? 'selected' : ''; ?>>
                        Lainnya
                    </option>

                </select>

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Deskripsi
                </label>

                <textarea
                    name="deskripsi"
                    class="form-control"
                    rows="5"
                ><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>

            </div>


            <div class="mb-3">

                <label class="form-label d-block">
                    Gambar Saat Ini
                </label>

                <?php if (!empty($data['gambar'])): ?>

                    <img
                        src="../../assets/images/<?php echo htmlspecialchars($data['gambar']); ?>"
                        class="preview"
                        alt="Gambar Galeri"
                    >

                <?php else: ?>

                    <p class="text-muted">
                        Tidak ada gambar.
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

                <select name="status" class="form-select">

                    <option value="aktif"
                        <?php echo ($data['status'] == 'aktif') ? 'selected' : ''; ?>>
                        Aktif
                    </option>

                    <option value="nonaktif"
                        <?php echo ($data['status'] == 'nonaktif') ? 'selected' : ''; ?>>
                        Nonaktif
                    </option>

                </select>

            </div>


            <div class="d-flex gap-2">

                <a href="index.php" class="btn btn-secondary">
                    Batal
                </a>

                <button
                    type="submit"
                    name="update"
                    class="btn btn-update"
                >
                    Update Galeri
                </button>

            </div>


        </form>

    </div>

</div>

</body>
</html>