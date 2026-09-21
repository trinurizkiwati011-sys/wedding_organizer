<?php

session_start();

include "../auth.php";
include "../../config/koneksi.php";


// Cek ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];


// Ambil data paket terlebih dahulu
$query = mysqli_query(
    $koneksi,
    "SELECT * FROM paket WHERE id_paket = $id LIMIT 1"
);

if (mysqli_num_rows($query) == 0) {

    header("Location: index.php");
    exit;
}

$paket = mysqli_fetch_assoc($query);


// Hapus file gambar
if (!empty($paket['gambar'])) {

    $file_gambar =
        "../../assets/images/" . $paket['gambar'];

    if (file_exists($file_gambar)) {

        unlink($file_gambar);
    }
}


// Hapus data dari database
$hapus = mysqli_query(
    $koneksi,
    "DELETE FROM paket WHERE id_paket = $id"
);


if ($hapus) {

    header("Location: index.php?pesan=hapus");
    exit;

} else {

    die(
        "Paket gagal dihapus: "
        . mysqli_error($koneksi)
    );
}

?>