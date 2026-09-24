<?php
include "../auth.php";
include "../../config/koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM testimoni ORDER BY id_testimoni DESC"
);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Testimoni - Luxora Organizer</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

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
            max-width: 1250px;
            margin: 40px auto;
        }

        .page-title {
            color: #4a302b;
            font-weight: 600;
        }

        .btn-kembali {
            background: #ead5ca;
            border: none;
            color: #4a302b;
            padding: 8px 18px;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-kembali:hover {
            background: #d9bbb2;
            color: #4a302b;
        }

        .table-container {
            background: white;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(74, 48, 43, 0.08);
        }

        .testimonial-img {
            width: 65px;
            height: 65px;
            object-fit: cover;
            border-radius: 50%;
        }

        .btn-edit {
            background: #ead5ca;
            color: #4a302b;
            border: none;
        }

        .btn-edit:hover {
            background: #d9bbb2;
            color: #4a302b;
        }

        .btn-hapus {
            background: #c98f87;
            color: white;
            border: none;
        }

        .btn-hapus:hover {
            background: #b87870;
            color: white;
        }

        .status-menunggu {
            background: #fff0c7;
            color: #856404;
        }

        .status-ditampilkan {
            background: #d8ead8;
            color: #356335;
        }

        .status-disembunyikan {
            background: #f2d4d0;
            color: #8a4038;
        }

        .rating {
            color: #c99f96;
            white-space: nowrap;
        }

        .isi-testimoni {
            max-width: 350px;
        }

        .btn-tambah {
            background: #c99f96;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
        }

        .btn-tambah:hover {
            background: #b88980;
            color: white;
        }

    </style>

</head>

<body>

<div class="container-admin">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <a href="../index.php" class="btn btn-kembali mb-3">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Dashboard
            </a>

            <h2 class="page-title mb-1">
                <i class="bi bi-chat-heart"></i>
                Kelola Testimoni
            </h2>

            <p class="text-muted mb-0">
                Kelola testimoni dari pelanggan Luxora Organizer.
            </p>

        </div>

        <a href="tambah.php" class="btn btn-tambah">
            <i class="bi bi-plus-lg"></i>
            Tambah Testimoni
        </a>

    </div>


    <!-- PESAN -->

    <?php if (isset($_GET['pesan'])): ?>

        <?php if ($_GET['pesan'] == 'tambah'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Testimoni berhasil ditambahkan.
            </div>

        <?php elseif ($_GET['pesan'] == 'edit'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Testimoni berhasil diperbarui.
            </div>

        <?php elseif ($_GET['pesan'] == 'hapus'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Testimoni berhasil dihapus.
            </div>

        <?php endif; ?>

    <?php endif; ?>


    <!-- TABLE -->

    <div class="table-container">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                    <tr>
                        <th width="60">No</th>
                        <th width="100">Foto</th>
                        <th>Nama</th>
                        <th>Rating</th>
                        <th>Isi Testimoni</th>
                        <th>Status</th>
                        <th width="130">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php if (mysqli_num_rows($query) > 0): ?>

                    <?php $no = 1; ?>

                    <?php while ($data = mysqli_fetch_assoc($query)): ?>

                        <tr>

                            <td>
                                <?php echo $no++; ?>
                            </td>


                            <!-- FOTO -->

                            <td>

                                <?php

                                $foto = $data['foto'] ?? '';

                                if (
                                    !empty($foto) &&
                                    $foto != 'testimoni-default.jpg'
                                ):

                                ?>

                                    <img
                                        src="../../assets/images/<?php echo htmlspecialchars($foto); ?>"
                                        class="testimonial-img"
                                        alt="Foto <?php echo htmlspecialchars($data['nama']); ?>"
                                    >

                                <?php else: ?>

                                    <img
                                        src="../../assets/images/testimoni-default.jpg"
                                        class="testimonial-img"
                                        alt="Foto default"
                                    >

                                <?php endif; ?>

                            </td>


                            <!-- NAMA -->

                            <td>

                                <strong>
                                    <?php echo htmlspecialchars($data['nama']); ?>
                                </strong>

                            </td>


                            <!-- RATING -->

                            <td>

                                <div class="rating">

                                    <?php

                                    $rating = (int) $data['rating'];

                                    for ($i = 1; $i <= 5; $i++) {

                                        if ($i <= $rating) {
                                            echo '<i class="bi bi-star-fill"></i>';
                                        } else {
                                            echo '<i class="bi bi-star"></i>';
                                        }

                                    }

                                    ?>

                                    <small class="text-muted">
                                        (<?php echo $rating; ?>)
                                    </small>

                                </div>

                            </td>


                            <!-- ISI -->

                            <td class="isi-testimoni">

                                <?php

                                $isi = $data['isi_testimoni'];

                                if (strlen($isi) > 100) {

                                    echo htmlspecialchars(
                                        substr($isi, 0, 100)
                                    ) . '...';

                                } else {

                                    echo htmlspecialchars($isi);

                                }

                                ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <?php if ($data['status'] == 'menunggu'): ?>

                                    <span class="badge status-menunggu">
                                        Menunggu
                                    </span>

                                <?php elseif ($data['status'] == 'ditampilkan'): ?>

                                    <span class="badge status-ditampilkan">
                                        Ditampilkan
                                    </span>

                                <?php else: ?>

                                    <span class="badge status-disembunyikan">
                                        Disembunyikan
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- AKSI -->

                            <td>

                                <a
                                    href="edit.php?id=<?php echo $data['id_testimoni']; ?>"
                                    class="btn btn-sm btn-edit"
                                    title="Edit"
                                >
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a
                                    href="hapus.php?id=<?php echo $data['id_testimoni']; ?>"
                                    class="btn btn-sm btn-hapus"
                                    title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus testimoni ini?');"
                                >
                                    <i class="bi bi-trash"></i>
                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-5 text-muted"
                        >

                            <i class="bi bi-chat-heart fs-1 d-block mb-2"></i>

                            Belum ada data testimoni.

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>