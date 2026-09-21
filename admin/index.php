<?php

session_start();

include "auth.php";
include "../config/koneksi.php";

$judul = "Dashboard Admin - Luxora Organizer";

/* =========================
   HITUNG DATA
========================= */

$query_paket = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM paket"
);
$total_paket = mysqli_fetch_assoc($query_paket)['total'];

$query_layanan = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM layanan"
);
$total_layanan = mysqli_fetch_assoc($query_layanan)['total'];

$query_galeri = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM galeri"
);
$total_galeri = mysqli_fetch_assoc($query_galeri)['total'];

$query_testimoni = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM testimoni"
);
$total_testimoni = mysqli_fetch_assoc($query_testimoni)['total'];

$query_pengguna = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM users"
);
$total_pengguna = mysqli_fetch_assoc($query_pengguna)['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title><?php echo $judul; ?></title>

    <!-- BOOTSTRAP -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- ICON -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <!-- GOOGLE FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Style+Script&display=swap"
        rel="stylesheet"
    >

    <style>

        body {
            background: #fff8f3;
            color: #4a302b;
            font-family: "Crimson Text", serif;
        }

        /* SIDEBAR */

        .sidebar {
    height: 100vh;
    box-sizing: border-box;
    background: #4a302b;
    padding: 25px 15px;
    position: fixed;
    width: 250px;
    left: 0;
    top: 0;
    overflow-y: auto;
}

        .sidebar-title {
            color: white;
            font-family: "Style Script", cursive;
            font-size: 38px;
            text-align: center;
            margin-bottom: 5px;
        }

        .sidebar-subtitle {
            color: #ead5ca;
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 12px 15px;

            color: #fff8f3;
            text-decoration: none;

            border-radius: 10px;

            transition: 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #c99f96;
        }

        .sidebar-menu i {
            font-size: 18px;
        }

        .logout-menu {
            margin-top: 25px;
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 20px;
        }


        /* CONTENT */

        .main-content {
            margin-left: 250px;
            padding: 35px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 30px;
        }

        .topbar h1 {
            font-family: "Style Script", cursive;
            font-size: 45px;
            font-weight: 400;
            margin: 0;
        }

        .admin-name {
            background: white;
            padding: 10px 18px;
            border-radius: 30px;

            box-shadow:
                0 5px 20px rgba(74, 48, 43, 0.08);
        }


        /* STATISTIC CARD */

        .stat-card {
            background: white;
            border: none;
            border-radius: 18px;

            padding: 25px;

            height: 100%;

            box-shadow:
                0 8px 25px rgba(74, 48, 43, 0.08);

            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #ead5ca;
            color: #765b54;

            border-radius: 12px;

            font-size: 22px;

            margin-bottom: 18px;
        }

        .stat-card h2 {
            font-family: "Crimson Text", serif;
            font-size: 34px;
            font-weight: 700;

            margin-bottom: 2px;
        }

        .stat-card p {
            color: #765b54;
            margin: 0;
            font-size: 17px;
        }


        /* WELCOME CARD */

        .welcome-card {
            background: #ead5ca;
            border-radius: 20px;

            padding: 30px;

            margin-top: 30px;
            margin-bottom: 30px;
        }

        .welcome-card h2 {
            font-family: "Style Script", cursive;
            font-size: 40px;
            font-weight: 400;
        }

        .welcome-card p {
            margin-bottom: 0;
            font-size: 17px;
        }


        /* QUICK MENU */

        .quick-card {
            background: white;
            border-radius: 18px;
            padding: 25px;

            height: 100%;

            box-shadow:
                0 8px 25px rgba(74, 48, 43, 0.08);
        }

        .quick-card h3 {
            font-family: "Style Script", cursive;
            font-size: 32px;
            margin-bottom: 20px;
        }

        .quick-btn {
            display: flex;
            align-items: center;
            gap: 10px;

            padding: 12px 15px;

            margin-bottom: 10px;

            background: #fff8f3;
            color: #4a302b;

            text-decoration: none;

            border-radius: 10px;

            transition: 0.3s;
        }

        .quick-btn:hover {
            background: #ead5ca;
            color: #4a302b;
        }


        /* RESPONSIVE */

        @media (max-width: 900px) {

            .sidebar {
                width: 210px;
            }

            .main-content {
                margin-left: 210px;
                padding: 25px;
            }

        }

        @media (max-width: 700px) {

            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .logout-menu {
    margin-top: 25px;
    border-top: 1px solid rgba(255,255,255,0.2);
    padding-top: 20px;
}

.logout-menu a {
    color: #fff8f3;
}

.logout-menu a:hover {
    background: #b88980;
    color: #ffffff;
}

        }

    </style>

</head>

<body>


<!-- =========================
     SIDEBAR
========================= -->

<aside class="sidebar">

    <div class="sidebar-title">
        Luxora
    </div>

    <div class="sidebar-subtitle">
        Admin Panel
    </div>


    <ul class="sidebar-menu">

        <li>
            <a href="index.php" class="active">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="paket/index.php">
                <i class="bi bi-box-seam"></i>
                Paket
            </a>
        </li>

        <li>
            <a href="layanan/index.php">
                <i class="bi bi-stars"></i>
                Layanan
            </a>
        </li>

        <li>
            <a href="galeri/index.php">
                <i class="bi bi-images"></i>
                Galeri
            </a>
        </li>

        <li>
            <a href="testimoni/index.php">
                <i class="bi bi-chat-heart"></i>
                Testimoni
            </a>
        </li>

        <li>
            <a href="pengguna/index.php">
                <i class="bi bi-people"></i>
                Pengguna
            </a>
        </li>

        <li>
            <a href="pengaturan/index.php">
                <i class="bi bi-gear"></i>
                Pengaturan
            </a>
        </li>

        <li class="logout-menu">
            <a href="logout.php">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </li>

    </ul>

</aside>


<!-- =========================
     MAIN CONTENT
========================= -->

<main class="main-content">

    <div class="topbar">

        <h1>
            Dashboard
        </h1>

        <div class="admin-name">

            <i class="bi bi-person-circle"></i>

           Halo,
<strong>
    <?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Admin'); ?>
</strong>

        </div>

    </div>


    <!-- WELCOME -->

    <div class="welcome-card">

        <h2>
            Selamat Datang di Luxora Organizer
        </h2>

        <p>
            Kelola seluruh data website wedding organizer
            melalui halaman admin ini.
        </p>

    </div>


    <!-- STATISTICS -->

    <div class="row g-4">


        <!-- PAKET -->

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-box-seam"></i>
                </div>

                <h2>
                    <?php echo $total_paket; ?>
                </h2>

                <p>
                    Total Paket
                </p>

            </div>

        </div>


        <!-- LAYANAN -->

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-stars"></i>
                </div>

                <h2>
                    <?php echo $total_layanan; ?>
                </h2>

                <p>
                    Total Layanan
                </p>

            </div>

        </div>


        <!-- GALERI -->

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-images"></i>
                </div>

                <h2>
                    <?php echo $total_galeri; ?>
                </h2>

                <p>
                    Total Galeri
                </p>

            </div>

        </div>


        <!-- TESTIMONI -->

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-chat-heart"></i>
                </div>

                <h2>
                    <?php echo $total_testimoni; ?>
                </h2>

                <p>
                    Total Testimoni
                </p>

            </div>

        </div>


        <!-- PENGGUNA -->

        <div class="col-xl-3 col-md-6">

            <div class="stat-card">

                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>

                <h2>
                    <?php echo $total_pengguna; ?>
                </h2>

                <p>
                    Total Pengguna
                </p>

            </div>

        </div>

    </div>


    <!-- QUICK MENU -->

    <div class="row g-4 mt-2">

        <div class="col-lg-6">

            <div class="quick-card">

                <h3>
                    Kelola Website
                </h3>

                <a
                    href="paket/index.php"
                    class="quick-btn"
                >
                    <i class="bi bi-box-seam"></i>
                    Kelola Paket
                </a>

                <a
                    href="layanan/index.php"
                    class="quick-btn"
                >
                    <i class="bi bi-stars"></i>
                    Kelola Layanan
                </a>

                <a
                    href="galeri/index.php"
                    class="quick-btn"
                >
                    <i class="bi bi-images"></i>
                    Kelola Galeri
                </a>

            </div>

        </div>


        <div class="col-lg-6">

            <div class="quick-card">

                <h3>
                    Lainnya
                </h3>

                <a
                    href="testimoni/index.php"
                    class="quick-btn"
                >
                    <i class="bi bi-chat-heart"></i>
                    Kelola Testimoni
                </a>

                <a
                    href="pengguna/index.php"
                    class="quick-btn"
                >
                    <i class="bi bi-people"></i>
                    Kelola Pengguna
                </a>

                <a
                    href="pengaturan/index.php"
                    class="quick-btn"
                >
                    <i class="bi bi-gear"></i>
                    Pengaturan Website
                </a>

            </div>

        </div>

    </div>

</main>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>