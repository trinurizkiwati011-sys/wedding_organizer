<?php
include "../auth.php";
include "../../config/koneksi.php";

$error = "";

if (isset($_POST['simpan'])) {

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

        $foto = "testimoni-default.jpg";


        /* UPLOAD FOTO */

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


                if (!is_dir($folder)) {
                    mkdir($folder, 0777, true);
                }


                if (
                    move_uploaded_file(
                        $tmp_file,
                        $folder . $foto_baru
                    )
                ) {

                    $foto = $foto_baru;

                } else {

                    $error = "Foto gagal diupload.";

                }

            }

        }


        /* INSERT DATABASE */

        if ($error == "") {

            $query = mysqli_query(
                $koneksi,
                "INSERT INTO testimoni
                (nama, foto, rating, isi_testimoni, status)
                VALUES
                ('$nama', '$foto', '$rating', '$isi_testimoni', '$status')"
            );


            if ($query) {

                header("Location: index.php?pesan=tambah");
                exit;

            } else {

                if (
                    $foto != "testimoni-default.jpg" &&
                    file_exists("../../assets/images/" . $foto)
                ) {
                    unlink("../../assets/images/" . $foto);
                }

                $error = "Data testimoni gagal disimpan.";

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

    <title>Tambah Testimoni - Luxora Organizer</title>

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
        ← Kembali ke Testimoni
    </a>


    <div class="card-form">

        <h2 class="mb-2">
            Tambah Testimoni
        </h2>

        <p class="text-muted mb-4">
            Tambahkan testimoni pelanggan Luxora Organizer.
        </p>


        <?php if ($error != ""): ?>

            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="POST" enctype="multipart/form-data">


            <!-- NAMA -->

            <div class="mb-3">

                <label class="form-label">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    placeholder="Contoh: Aulia & Rizky"
                    value="<?php echo htmlspecialchars($_POST['nama'] ?? ''); ?>"
                    required
                >

            </div>


            <!-- FOTO -->

            <div class="mb-3">

                <label class="form-label">
                    Foto
                </label>

                <input
                    type="file"
                    name="foto"
                    class="form-control"
                    accept=".jpg,.jpeg,.png,.webp"
                >

                <small class="text-muted">
                    Opsional. Format JPG, JPEG, PNG, WEBP. Maksimal 5 MB.
                </small>

            </div>


            <!-- RATING -->

            <div class="mb-3">

                <label class="form-label">
                    Rating
                </label>

                <select name="rating" class="form-select" required>

                    <option value="5">★★★★★ - 5</option>
                    <option value="4">★★★★☆ - 4</option>
                    <option value="3">★★★☆☆ - 3</option>
                    <option value="2">★★☆☆☆ - 2</option>
                    <option value="1">★☆☆☆☆ - 1</option>

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
                    placeholder="Tulis testimoni pelanggan..."
                    required
                ><?php echo htmlspecialchars($_POST['isi_testimoni'] ?? ''); ?></textarea>

            </div>


            <!-- STATUS -->

            <div class="mb-4">

                <label class="form-label">
                    Status
                </label>

                <select name="status" class="form-select">

                    <option value="menunggu">
                        Menunggu
                    </option>

                    <option value="ditampilkan">
                        Ditampilkan
                    </option>

                    <option value="disembunyikan">
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
                    name="simpan"
                    class="btn btn-simpan"
                >
                    Simpan Testimoni
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>