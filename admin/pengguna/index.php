<?php
include "../auth.php";
include "../../config/koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM users ORDER BY id_user DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Pengguna - Luxora Organizer</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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
        }

        .btn-kembali:hover {
            background: #d9bbb2;
            color: #4a302b;
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

        .table-container {
            background: white;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(74, 48, 43, 0.08);
        }

        .user-img {
            width: 60px;
            height: 60px;
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

        .status-aktif {
            background: #d8ead8;
            color: #356335;
        }

        .status-nonaktif {
            background: #f2d4d0;
            color: #8a4038;
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
                <i class="bi bi-people"></i>
                Kelola Pengguna
            </h2>

            <p class="text-muted mb-0">
                Kelola data pengguna Luxora Organizer.
            </p>

        </div>

        <a href="tambah.php" class="btn btn-tambah">
            <i class="bi bi-plus-lg"></i>
            Tambah Pengguna
        </a>

    </div>


    <!-- PESAN -->

    <?php if (isset($_GET['pesan'])): ?>

        <?php if ($_GET['pesan'] == 'tambah'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Pengguna berhasil ditambahkan.
            </div>

        <?php elseif ($_GET['pesan'] == 'edit'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Pengguna berhasil diperbarui.
            </div>

        <?php elseif ($_GET['pesan'] == 'hapus'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Pengguna berhasil dihapus.
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
    
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. WhatsApp</th>
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



                            <!-- NAMA -->

                            <td>
                                <strong>
                                    <?php echo htmlspecialchars($data['nama']); ?>
                                </strong>
                            </td>


                            <!-- EMAIL -->

                            <td>
                                <?php echo htmlspecialchars($data['email']); ?>
                            </td>


                            <!-- WHATSAPP -->

                            <td>

                                <?php if (!empty($data['no_whatsapp'])): ?>

                                    <?php echo htmlspecialchars($data['no_whatsapp']); ?>

                                <?php else: ?>

                                    <span class="text-muted">
                                        Belum diisi
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <?php if ($data['status'] == 'aktif'): ?>

                                    <span class="badge status-aktif">
                                        Aktif
                                    </span>

                                <?php else: ?>

                                    <span class="badge status-nonaktif">
                                        Nonaktif
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- AKSI -->

                            <td>

                                <a
                                    href="edit.php?id=<?php echo $data['id_user']; ?>"
                                    class="btn btn-sm btn-edit"
                                    title="Edit"
                                >
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a
                                    href="hapus.php?id=<?php echo $data['id_user']; ?>"
                                    class="btn btn-sm btn-hapus"
                                    title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus pengguna ini?');"
                                >
                                    <i class="bi bi-trash"></i>
                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="7" class="text-center py-5 text-muted">

                            <i class="bi bi-people fs-1 d-block mb-2"></i>

                            Belum ada data pengguna.

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