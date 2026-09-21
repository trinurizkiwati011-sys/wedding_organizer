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
    "SELECT * FROM users
     WHERE id_user = $id
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

    $email = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['email'])
    );

    $no_whatsapp = mysqli_real_escape_string(
        $koneksi,
        trim($_POST['no_whatsapp'])
    );

    $status = mysqli_real_escape_string(
        $koneksi,
        $_POST['status']
    );


    if ($nama == "") {

        $error = "Nama wajib diisi.";

    } elseif ($email == "") {

        $error = "Email wajib diisi.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Format email tidak valid.";

    } else {

        /* CEK EMAIL */

        $cek_email = mysqli_query(
            $koneksi,
            "SELECT id_user
             FROM users
             WHERE email = '$email'
             AND id_user != $id
             LIMIT 1"
        );


        if (mysqli_num_rows($cek_email) > 0) {

            $error = "Email sudah digunakan oleh pengguna lain.";

        } else {

            $foto_lama = $data['foto'];
            $foto = $foto_lama;


            /* PASSWORD */

            $password_lama = $data['password'];

            if (!empty($_POST['password'])) {

                $password = mysqli_real_escape_string(
                    $koneksi,
                    $_POST['password']
                );

            } else {

                $password = $password_lama;

            }


            /* GANTI FOTO */

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
                            $foto_lama != "user-default.jpg" &&
                            file_exists($folder . $foto_lama)
                        ) {

                            unlink($folder . $foto_lama);

                        }

                    } else {

                        $error = "Foto baru gagal diupload.";

                    }

                }

            }


            /* UPDATE DATABASE */

            if ($error == "") {

                $update = mysqli_query(
                    $koneksi,
                    "UPDATE users SET

                        nama = '$nama',
                        email = '$email',
                        no_whatsapp = '$no_whatsapp',
                        password = '$password',
                        foto = '$foto',
                        status = '$status'

                    WHERE id_user = $id"
                );


                if ($update) {

                    header("Location: index.php?pesan=edit");
                    exit;

                } else {

                    $error = "Data pengguna gagal diperbarui.";

                }

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

    <title>Edit Pengguna - Luxora Organizer</title>

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
        ← Kembali ke Pengguna
    </a>


    <div class="card-form">

        <h2 class="mb-2">
            Edit Pengguna
        </h2>

        <p class="text-muted mb-4">
            Perbarui data pengguna Luxora Organizer.
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


            <!-- EMAIL -->

            <div class="mb-3">

                <label class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="<?php echo htmlspecialchars($data['email']); ?>"
                    required
                >

            </div>


            <!-- WHATSAPP -->

            <div class="mb-3">

                <label class="form-label">
                    No. WhatsApp
                </label>

                <input
                    type="text"
                    name="no_whatsapp"
                    class="form-control"
                    value="<?php echo htmlspecialchars($data['no_whatsapp'] ?? ''); ?>"
                >

            </div>


            <!-- PASSWORD -->

            <div class="mb-3">

                <label class="form-label">
                    Password Baru
                </label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Kosongkan jika tidak ingin mengganti password"
                >

                <small class="text-muted">
                    Kosongkan jika password tetap.
                </small>

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
                        value="aktif"
                        <?php echo ($data['status'] == 'aktif') ? 'selected' : ''; ?>
                    >
                        Aktif
                    </option>

                    <option
                        value="nonaktif"
                        <?php echo ($data['status'] == 'nonaktif') ? 'selected' : ''; ?>
                    >
                        Nonaktif
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
                    Update Pengguna
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>