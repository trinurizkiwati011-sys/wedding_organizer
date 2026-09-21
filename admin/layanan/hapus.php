<?php

session_start();

include "../auth.php";
include "../../config/koneksi.php";


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];


$query = mysqli_query(
    $koneksi,
    "SELECT * FROM layanan
     WHERE id_layanan = $id
     LIMIT 1"
);


if (mysqli_num_rows($query) == 0) {
    header("Location: index.php");
    exit;
}


$layanan = mysqli_fetch_assoc($query);


// Hapus gambar
if (!empty($layanan['gambar'])) {

    $file_gambar =
        "../../assets/images/" . $layanan['gambar'];

    if (file_exists($file_gambar)) {
        unlink($file_gambar);
    }
}


// Hapus data
$hapus = mysqli_query(
    $koneksi,
    "DELETE FROM layanan
     WHERE id_layanan = $id"
);


if ($hapus) {

    header("Location: index.php?pesan=hapus");
    exit;

} else {

    die(
        "Layanan gagal dihapus: "
        . mysqli_error($koneksi)
    );
}

?>