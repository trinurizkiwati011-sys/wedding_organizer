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
    "SELECT gambar FROM galeri WHERE id_galeri = $id LIMIT 1"
);


if (mysqli_num_rows($query) == 0) {
    header("Location: index.php");
    exit;
}


$data = mysqli_fetch_assoc($query);

$gambar = $data['gambar'];


$folder = "../../assets/images/";


if (!empty($gambar) && file_exists($folder . $gambar)) {
    unlink($folder . $gambar);
}


$hapus = mysqli_query(
    $koneksi,
    "DELETE FROM galeri WHERE id_galeri = $id"
);


if ($hapus) {

    header("Location: index.php?pesan=hapus");
    exit;

} else {

    echo "Data galeri gagal dihapus.";

}

?>