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


/* AMBIL FOTO */

$query = mysqli_query(
    $koneksi,
    "SELECT foto
     FROM testimoni
     WHERE id_testimoni = $id
     LIMIT 1"
);


if (mysqli_num_rows($query) == 0) {

    header("Location: index.php");
    exit;

}


$data = mysqli_fetch_assoc($query);

$foto = $data['foto'];


/* HAPUS DATA */

$hapus = mysqli_query(
    $koneksi,
    "DELETE FROM testimoni
     WHERE id_testimoni = $id"
);


if ($hapus) {

    /* HAPUS FOTO */

    if (
        !empty($foto) &&
        $foto != "testimoni-default.jpg" &&
        file_exists("../../assets/images/" . $foto)
    ) {

        unlink("../../assets/images/" . $foto);

    }


    header("Location: index.php?pesan=hapus");
    exit;

} else {

    echo "Testimoni gagal dihapus.";

}

?>
