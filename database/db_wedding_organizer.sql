-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260730.a0d1231b75
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 03, 2026 at 03:06 AM
-- Server version: 8.4.3
-- PHP Version: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_wedding_organizer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `nama_admin` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'admin-default.jpg',
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `email`, `password`, `foto`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin luxora', 'admin@gmail.com', 'admin123', 'admin.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 10:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int NOT NULL,
  `judul` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('akad','resepsi','dekorasi','makeup','prewedding','lamaran','lainnya') COLLATE utf8mb4_unicode_ci DEFAULT 'lainnya',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul`, `gambar`, `kategori`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Akad Pernikahan', '1788360549_6a98376521197.jpg', 'akad', 'Dokumentasi acara akad pernikahan dengan konsep elegan.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:49:09'),
(2, 'Resepsi Pernikahan', '1788360463_6a98370f71504.jpg', 'resepsi', 'Dokumentasi acara resepsi pernikahan.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:47:43'),
(3, 'Dekorasi Pelaminan', '1788360426_6a9836ea379ed.jpg', 'dekorasi', 'Dekorasi pelaminan dengan konsep elegan dan modern.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:47:06'),
(4, 'Makeup Pengantin', '1788360383_6a9836bfe1741.jpg', 'makeup', 'Hasil makeup pengantin untuk acara pernikahan.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:46:23'),
(5, 'Prewedding Session', '1788360325_6a983685b9fa5.jpg', 'prewedding', 'Dokumentasi sesi foto prewedding pasangan.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:45:25'),
(6, 'Acara Lamaran', '1788360287_6a98365f4bdab.jpg', 'akad', 'Dekorasi dan dokumentasi acara lamaran.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:44:47'),
(7, 'Wedding Moment', '1788360232_6a983628d9a34.jpg', 'lainnya', 'Momen bahagia pasangan bersama keluarga.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:43:52'),
(8, 'Dekorasi Meja Tamu', '1788360142_6a9835cee1474.jpg', 'dekorasi', 'Dekorasi meja tamu untuk acara resepsi.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:42:22'),
(9, 'Busana Pengantin', '1788359944_6a9835086a7c5.jpg', 'makeup', 'Koleksi busana pengantin untuk acara pernikahan.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:39:04'),
(10, 'Wedding Outdoor', '1788359888_6a9834d0910a1.jpg', 'resepsi', 'Konsep resepsi outdoor dengan suasana yang elegan.', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:38:08');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id_layanan` int NOT NULL,
  `nama_layanan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id_layanan`, `nama_layanan`, `deskripsi`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Wedding Organizer', 'Tim profesional Luxora Organizer yang membantu merencanakan dan mengatur seluruh rangkaian acara pernikahan.', 'layanan_6a983a4d5586a.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 15:01:33'),
(2, 'Makeup & Busana', 'Menyediakan makeup pengantin dan berbagai pilihan busana yang disesuaikan dengan konsep pernikahan.', 'layanan_6a9839f834c14.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 15:00:08'),
(3, 'Catering', 'Menyediakan berbagai pilihan makanan dan minuman untuk acara pernikahan dengan kualitas dan pelayanan terbaik.', 'layanan_6a9839d7f3c5d.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:59:35'),
(4, 'Dekorasi', 'Menyediakan dekorasi dengan berbagai konsep mulai dari modern, elegan hingga tradisional.', 'layanan_6a9839b101848.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:58:57'),
(5, 'Venue', 'Membantu memilih tempat acara yang sesuai dengan konsep, jumlah tamu dan kebutuhan pernikahan.', 'layanan_6a983959eb88c.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:57:29'),
(6, 'Dokumentasi', 'Mengabadikan berbagai momen penting melalui layanan foto dan video profesional.', 'layanan_6a983923b81e7.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:56:35'),
(7, 'Entertainment', 'Menyediakan hiburan dan musik untuk membuat acara pernikahan semakin meriah.', 'layanan_6a9838d222e02.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:55:14'),
(8, 'MC', 'Menyediakan MC profesional untuk memandu jalannya acara agar berlangsung teratur dan menyenangkan.', 'layanan_6a983835f1fac.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:52:37'),
(9, 'Upacara Adat', 'Membantu mempersiapkan dan melaksanakan berbagai rangkaian upacara adat sesuai kebutuhan pasangan.', 'layanan_6a9837e1f36e7.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 14:51:13');

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `id_paket` int NOT NULL,
  `nama_paket` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fasilitas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`id_paket`, `nama_paket`, `harga`, `deskripsi`, `fasilitas`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Paket Silver', 15000000.00, 'Paket pernikahan sederhana dan elegan untuk pasangan yang menginginkan acara hangat dan berkesan.', 'Dekorasi sederhana, Makeup pengantin, Busana pengantin, Dokumentasi foto, MC, Sound system', 'paket_6a98407895779.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 15:27:52'),
(2, 'Paket Gold', 25000000.00, 'Paket wedding lengkap dengan konsep elegan dan pelayanan profesional dari awal hingga acara selesai.', 'Dekorasi premium, Makeup pengantin, Busana pengantin, Dokumentasi foto dan video, MC, Sound system, Catering', 'paket_6a983ff9ed528.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 15:25:45'),
(3, 'Paket Platinum', 40000000.00, 'Paket wedding eksklusif dengan pelayanan lengkap untuk mewujudkan pernikahan impian.', 'Dekorasi premium, Makeup premium, Busana pengantin, Dokumentasi foto dan video, MC profesional, Sound system, Catering, Entertainment, Wedding coordinator', 'paket_6a983fd98e5ee.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 15:25:13'),
(4, 'Paket Intimate', 20000000.00, 'Paket pernikahan intimate dengan konsep sederhana, nyaman dan elegan.', 'Dekorasi intimate, Makeup pengantin, Busana pengantin, Dokumentasi, Catering, MC', 'paket_6a983fb8dce46.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 15:24:40'),
(5, 'Paket Akad', 10000000.00, 'Paket khusus untuk acara akad nikah dengan konsep sederhana dan elegan.', 'Dekorasi akad, Makeup, Busana pengantin, Dokumentasi, Sound system', 'paket_6a983f907565f.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 15:24:00'),
(6, 'Paket Luxury', 55000000.00, 'Paket pernikahan mewah dengan layanan premium dan konsep yang dapat disesuaikan dengan keinginan pasangan.', 'Dekorasi luxury, Makeup premium, Busana premium, Foto dan video, Catering premium, Entertainment, MC profesional, Wedding coordinator', 'paket_6a983f507d6a5.jpg', 'aktif', '2026-09-02 10:01:40', '2026-09-02 15:22:56');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id_pengaturan` int NOT NULL,
  `nama_wo` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_whatsapp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jam_operasional` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maps` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id_pengaturan`, `nama_wo`, `slogan`, `deskripsi`, `alamat`, `no_whatsapp`, `email`, `instagram`, `facebook`, `jam_operasional`, `maps`, `updated_at`) VALUES
(1, 'Luxora Organizer', 'Mewujudkan Pernikahan Impian Anda', 'Luxora Organizer adalah wedding organizer profesional yang membantu pasangan mewujudkan pernikahan yang indah, elegan dan berkesan.', 'Jl. Raya Wedding No. 123, Bandung, Jawa Barat', '6283121710740', 'luxoraorganizer@gmail.com', '@luxoraorganizer', 'Luxora Organizer', 'Senin - Sabtu, 09.00 - 17.00 WIB', 'https://maps.google.com/', '2026-09-02 16:12:26');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE `testimoni` (
  `id_testimoni` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'testimoni-default.jpg',
  `rating` tinyint NOT NULL,
  `isi_testimoni` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('menunggu','ditampilkan','disembunyikan') COLLATE utf8mb4_unicode_ci DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`id_testimoni`, `nama`, `foto`, `rating`, `isi_testimoni`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Dinda & Fajar', '1788362431_6a983ebf174aa.jpg', 5, 'Pelayanannya sangat membantu dari awal persiapan sampai acara selesai. Semua berjalan dengan lancar dan sesuai dengan konsep yang kami inginkan.', 'ditampilkan', '2026-09-02 10:01:40', '2026-09-02 15:20:31'),
(2, 'Nadia & Reza', '1788362397_6a983e9d58a7a.jpg', 5, 'Dekorasinya sangat bagus dan tim Luxora Organizer sangat ramah serta profesional.', 'ditampilkan', '2026-09-02 10:01:40', '2026-09-02 15:19:57'),
(3, 'Salsa & Andi', '1788362345_6a983e699dbf0.jpg', 5, 'Kami sangat terbantu dalam mempersiapkan acara pernikahan. Timnya responsif dan hasilnya memuaskan.', 'ditampilkan', '2026-09-02 10:01:40', '2026-09-02 15:19:05'),
(4, 'Putri & Dimas', '1788362320_6a983e505d441.jpg', 4, 'Pelayanan baik dan hasil dekorasi sesuai dengan konsep yang kami pilih.', 'ditampilkan', '2026-09-02 10:01:40', '2026-09-02 15:18:40'),
(5, 'Ayu & Rian', '1788362287_6a983e2f78648.jpg', 5, 'Terima kasih Luxora Organizer sudah membantu membuat acara pernikahan kami menjadi lebih berkesan.', 'ditampilkan', '2026-09-02 10:01:40', '2026-09-02 15:18:07'),
(6, 'Nisa & Arif', '1788362210_6a983de262fd4.jpg', 5, 'Konsep pernikahan kami dapat diwujudkan dengan sangat baik oleh Luxora Organizer.', 'ditampilkan', '2026-09-02 10:01:40', '2026-09-02 15:16:50');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_whatsapp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `no_whatsapp`, `password`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tri Nurrizkiwati', 'tri@gmail.com', '6281234567891', '123456', 'aktif', '2026-09-02 10:01:40', '2026-09-02 10:01:40'),
(2, 'Aulia Rahma', 'aulia@gmail.com', '6281234567892', '123456', 'aktif', '2026-09-02 10:01:40', '2026-09-02 10:01:40'),
(3, 'Rizky Maulana', 'rizky@gmail.com', '6281234567893', '123456', 'aktif', '2026-09-02 10:01:40', '2026-09-02 10:01:40'),
(4, 'Salsa Putri', 'salsa@gmail.com', '6281234567894', '123456', 'aktif', '2026-09-02 10:01:40', '2026-09-02 10:01:40'),
(5, 'Dinda Maharani', 'dinda@gmail.com', '6281234567895', '123456', 'aktif', '2026-09-02 10:01:40', '2026-09-02 10:01:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id_pengaturan`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id_testimoni`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id_layanan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `paket`
--
ALTER TABLE `paket`
  MODIFY `id_paket` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id_pengaturan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id_testimoni` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
