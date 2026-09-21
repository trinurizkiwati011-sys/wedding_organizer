<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <div class="navbar-container">

        <a href="index.php" class="logo">
            Luxora Organizer
        </a>

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