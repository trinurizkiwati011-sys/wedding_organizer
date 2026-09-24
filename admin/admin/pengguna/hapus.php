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


/* AMBIL DATA FOTO */

$query = mysqli_query(
    $koneksi,
    "SELECT foto
     FROM users
     WHERE id_user = $id
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
    "DELETE FROM users
     WHERE id_user = $id"
);


if ($hapus) {

    /* HAPUS FOTO */

    if (
        !empty($foto) &&
        $foto != "user-default.jpg" &&
        file_exists("../../assets/images/" . $foto)
    ) {

        unlink("../../assets/images/" . $foto);

    }


    header("Location: index.php?pesan=hapus");
    exit;

} else {

    echo "Pengguna gagal dihapus.";

}

?>