<?php
session_start();

include "config/koneksi.php";

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah ID paket dikirim
if (!isset($_POST['id_paket'])) {
    header("Location: paket.php");
    exit;
}

$id_user = $_SESSION['user_id'];
$id_paket = (int) $_POST['id_paket'];

// Cek apakah paket tersedia
$query_paket = mysqli_query(
    $koneksi,
    "SELECT * FROM paket
     WHERE id_paket = '$id_paket'
     AND status = 'aktif'
     LIMIT 1"
);

if (mysqli_num_rows($query_paket) == 0) {
    header("Location: paket.php");
    exit;
}

// Cek apakah paket sudah menjadi favorit
$query_cek = mysqli_query(
    $koneksi,
    "SELECT * FROM favorit
     WHERE id_user = '$id_user'
     AND id_paket = '$id_paket'
     LIMIT 1"
);

if (mysqli_num_rows($query_cek) > 0) {

    // Kalau sudah favorit → hapus
    mysqli_query(
        $koneksi,
        "DELETE FROM favorit
         WHERE id_user = '$id_user'
         AND id_paket = '$id_paket'"
    );

} else {

    // Kalau belum favorit → tambahkan
    mysqli_query(
        $koneksi,
        "INSERT INTO favorit (id_user, id_paket)
         VALUES ('$id_user', '$id_paket')"
    );
}

// Kembali ke halaman paket
header("Location: paket.php");
exit;
?>