<?php
include "../auth.php";
include "../../config/koneksi.php";

$error = "";

if (isset($_POST['simpan'])) {

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

    } elseif (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] != 0) {

        $error = "Gambar galeri wajib dipilih.";

    } else {

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

            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            if (move_uploaded_file($tmp_file, $folder . $nama_baru)) {

                $query = mysqli_query(
                    $koneksi,
                    "INSERT INTO galeri
                    (judul, gambar, kategori, deskripsi, status)
                    VALUES
                    ('$judul', '$nama_baru', '$kategori', '$deskripsi', '$status')"
                );

                if ($query) {

                    header("Location: index.php?pesan=tambah");
                    exit;

                } else {

                    unlink($folder . $nama_baru);

                    $error = "Data gagal disimpan ke database.";
                }

            } else {

                $error = "Gambar gagal diupload.";
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

    <title>Tambah Galeri - Luxora Organizer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

        .btn-simpan {
            background: #c99f96;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
        }

        .btn-simpan:hover {
            background: #b88980;
            color: white;
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
            Tambah Galeri
        </h2>

        <p class="text-muted mb-4">
            Tambahkan foto baru ke galeri Luxora Organizer.
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
                    placeholder="Contoh: Dekorasi Pernikahan"
                    value="<?php echo htmlspecialchars($_POST['judul'] ?? ''); ?>"
                    required
                >

            </div>


            <div class="mb-3">

                <label class="form-label">
                    Kategori
                </label>

                <select name="kategori" class="form-select" required>

                    <option value="akad">Akad</option>
                    <option value="resepsi">Resepsi</option>
                    <option value="dekorasi">Dekorasi</option>
                    <option value="makeup">Makeup</option>
                    <option value="prewedding">Prewedding</option>
                    <option value="lainnya" selected>Lainnya</option>

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
                    placeholder="Masukkan deskripsi foto..."
                ><?php echo htmlspecialchars($_POST['deskripsi'] ?? ''); ?></textarea>

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
                    required
                >

                <small class="text-muted">
                    Format JPG, JPEG, PNG, WEBP. Maksimal 5 MB.
                </small>

            </div>


            <div class="mb-4">

                <label class="form-label">
                    Status
                </label>

                <select name="status" class="form-select">

                    <option value="aktif">
                        Aktif
                    </option>

                    <option value="nonaktif">
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
                    name="simpan"
                    class="btn btn-simpan"
                >
                    Simpan Galeri
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>