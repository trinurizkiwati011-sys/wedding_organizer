<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil data pengaturan dari database
$query_pengaturan = mysqli_query(
    $koneksi,
    "SELECT nama_wo, logo
     FROM pengaturan
     LIMIT 1"
);

$pengaturan = mysqli_fetch_assoc($query_pengaturan);

$nama_wo = $pengaturan['nama_wo'] ?? 'Luxora Organizer';
$logo = $pengaturan['logo.jpg'] ?? '';
?>

<nav class="navbar">
    <div class="navbar-container">

        <!-- BRAND -->
        <a href="index.php" class="navbar-brand">

            <?php if (!empty($logo)): ?>
                <img
                    src="assets/images/<?php echo htmlspecialchars($logo); ?>"
                    alt="<?php echo htmlspecialchars($nama_wo); ?>"
                >
            <?php endif; ?>

            <span>
                <?php echo htmlspecialchars($nama_wo); ?>
            </span>

        </a>

        <!-- MENU -->
        <div class="navbar-menu">

            <a href="index.php">Home</a>
            <a href="tentang.php">Tentang</a>
            <a href="layanan.php">Layanan</a>
            <a href="paket.php">Paket</a>
            <a href="galeri.php">Galeri</a>
            <a href="testimoni.php">Testimoni</a>
            <a href="kontak.php">Kontak</a>

            <?php if (isset($_SESSION['user_id'])): ?>

                <span class="navbar-user">
                    Halo, <?php echo htmlspecialchars($_SESSION['user_nama']); ?>
                </span>

                <a href="logout.php" class="btn-login">
                    Logout
                </a>

            <?php else: ?>

                <a href="login.php" class="btn-login">
                    Login
                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>