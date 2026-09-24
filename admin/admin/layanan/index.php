<?php
session_start();

include "../auth.php";
include "../../config/koneksi.php";

$query = mysqli_query(
    $koneksi,
    "SELECT * FROM layanan ORDER BY id_layanan DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Layanan - Luxora Organizer</title>

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
            max-width: 1200px;
            margin: 40px auto;
        }

        .page-title {
            color: #4a302b;
            font-weight: 600;
        }

        .table-container {
            background: white;
            border-radius: 18px;
            padding: 20px;
            box-shadow: 0 5px 25px rgba(74,48,43,.08);
            overflow-x: auto;
        }

        .btn-tambah {
            background: #c99f96;
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
        }

        .btn-tambah:hover {
            background: #b88980;
            color: white;
        }

        .gambar-layanan {
            width: 90px;
            height: 65px;
            object-fit: cover;
            border-radius: 10px;
        }

        .badge-aktif {
            background: #d9ead3;
            color: #3c6e32;
        }

        .badge-nonaktif {
            background: #f4cccc;
            color: #8b3a3a;
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
            background: #f4cccc;
            color: #8b3a3a;
            border: none;
        }

        .btn-hapus:hover {
            background: #e6b8b8;
            color: #8b3a3a;
        }

        btn-kembali {
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
    </style>
</head>

<body>

<div class="container-admin">

    <?php if (isset($_GET['pesan'])): ?>

        <?php if ($_GET['pesan'] == 'tambah'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Layanan berhasil ditambahkan.
            </div>

        <?php elseif ($_GET['pesan'] == 'edit'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Layanan berhasil diperbarui.
            </div>

        <?php elseif ($_GET['pesan'] == 'hapus'): ?>

            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                Layanan berhasil dihapus.
            </div>

        <?php endif; ?>

    <?php endif; ?>


    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <a href="../index.php" class="btn btn-kembali">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Dashboard
</a>
            <h2 class="page-title mb-1">
                <i class="bi bi-stars"></i>
                Kelola Layanan
            </h2>

            <p class="text-muted mb-0">
                Kelola layanan yang tersedia di Luxora Organizer.
            </p>
        </div>

        <a href="tambah.php" class="btn btn-tambah">
            <i class="bi bi-plus-lg"></i>
            Tambah Layanan
        </a>

    </div>


    <div class="table-container">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>

            <?php if (mysqli_num_rows($query) > 0): ?>

                <?php $no = 1; ?>

                <?php while ($layanan = mysqli_fetch_assoc($query)): ?>

                    <tr>

                        <td>
                            <?php echo $no++; ?>
                        </td>

                        <td>

                            <?php if (!empty($layanan['gambar'])): ?>

                                <img
                                    src="../../assets/images/<?php echo htmlspecialchars($layanan['gambar']); ?>"
                                    class="gambar-layanan"
                                    alt="<?php echo htmlspecialchars($layanan['nama_layanan']); ?>"
                                >

                            <?php else: ?>

                                <span class="text-muted">
                                    Tidak ada gambar
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>
                            <strong>
                                <?php echo htmlspecialchars($layanan['nama_layanan']); ?>
                            </strong>
                        </td>

                        <td>
                            <?php
                            $deskripsi = $layanan['deskripsi'];

                            if (strlen($deskripsi) > 100) {
                                echo htmlspecialchars(
                                    substr($deskripsi, 0, 100)
                                ) . '...';
                            } else {
                                echo htmlspecialchars($deskripsi);
                            }
                            ?>
                        </td>

                        <td>

                            <?php if ($layanan['status'] == 'aktif'): ?>

                                <span class="badge badge-aktif px-3 py-2">
                                    Aktif
                                </span>

                            <?php else: ?>

                                <span class="badge badge-nonaktif px-3 py-2">
                                    Nonaktif
                                </span>

                            <?php endif; ?>

                        </td>

                        <td>

                            <a
                                href="edit.php?id=<?php echo $layanan['id_layanan']; ?>"
                                class="btn btn-sm btn-edit"
                                title="Edit"
                            >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a
                                href="hapus.php?id=<?php echo $layanan['id_layanan']; ?>"
                                class="btn btn-sm btn-hapus"
                                title="Hapus"
                                onclick="return confirm('Yakin ingin menghapus layanan ini?');"
                            >
                                <i class="bi bi-trash"></i>
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="6" class="text-center py-5">

                        <i class="bi bi-stars fs-1 text-muted"></i>

                        <p class="mt-3">
                            Belum ada data layanan.
                        </p>

                    </td>
                </tr>

            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>