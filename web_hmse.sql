-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Agu 2026 pada 05.43
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_hmse`
--
CREATE DATABASE IF NOT EXISTS `web_hmse` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_hmse`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `admin_users`:
--

--
-- Dumping data untuk tabel `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'admin', '$2y$10$Pxj7yfmsb4y7tstLd1gsmuNEa1k7FDT1joqT7xCP5xOmh1oj4d1se', '2026-07-28 16:57:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `place` varchar(200) DEFAULT NULL,
  `event_time` varchar(100) DEFAULT NULL,
  `event_date` date NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `events`:
--

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id`, `title`, `place`, `event_time`, `event_date`, `photo`, `created_at`) VALUES
(1, 'Makrab (Malam Keakraban)', 'Villa Puncak, Bogor', '08.00 - selesai', '2025-06-25', NULL, '2026-07-28 16:57:26'),
(2, 'Bootcamp Web Development', 'Lab Komputer Kampus', '13.00 - 16.00', '2026-08-14', 'home.png', '2026-07-28 16:57:26'),
(3, 'Seminar Teknologi & Karir', 'Aula Saba Karya', '09.00 - 12.00', '2026-09-05', 'foto.jpg', '2026-07-28 16:57:26'),
(4, 'Tes Fungsi', 'Rumag', '07.30', '2026-07-29', 'img_6a6881858a6623.62110999.jpeg', '2026-07-28 17:16:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gallery_photos`
--

DROP TABLE IF EXISTS `gallery_photos`;
CREATE TABLE `gallery_photos` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `category` enum('olahraga','belajar','event') NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `gallery_photos`:
--

--
-- Dumping data untuk tabel `gallery_photos`
--

INSERT INTO `gallery_photos` (`id`, `photo`, `category`, `sort_order`, `created_at`) VALUES
(1, 'motif_biru.jpg', 'olahraga', 1, '2026-07-28 16:57:26'),
(2, 'home.png', 'belajar', 2, '2026-07-28 16:57:26'),
(3, 'computer_1.jpg', 'belajar', 3, '2026-07-28 16:57:26'),
(4, 'foto.jpg', 'event', 4, '2026-07-28 16:57:26'),
(5, 'img_6a6880182ee7c0.37363060.png', 'event', 0, '2026-07-28 17:10:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `title` varchar(200) NOT NULL,
  `event_datetime` datetime NOT NULL,
  `author` varchar(150) DEFAULT NULL,
  `body_html` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `news`:
--

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `slug`, `title`, `event_datetime`, `author`, `body_html`, `created_at`, `updated_at`) VALUES
(1, 'trinitycamp-iot-series', 'Trinitycamp: IoT Series', '2026-07-10 18:52:00', 'Fahri Haidar Daffa, Aflahal Bambang Jaya', '<p>Tangerang, 28 Juni & 05 Juli 2026 - Kolaborasi tiga himpunan mahasiswa, yaitu <strong>Himpunan Mahasiswa Software Engineering (HMSE)</strong>, <strong>Himpunan Mahasiswa Sistem Informasi (HMSI)</strong>, dan <strong>Himpunan Mahasiswa Teknologi Informasi (HMTI)</strong>, sukses menyelenggarakan kegiatan <strong>TrinityCamp: IoT Series</strong> dengan mengusung tema <strong>\"From Coin to Screen\"</strong>.</p><p>Kegiatan yang berlangsung selama dua hari, pada tanggal 28 Juni 2026 dan 05 Juli 2026, bertempat di Universitas Insan Pembangunan Indonesia.</p>', '2026-07-28 16:57:26', '2026-07-28 16:57:26'),
(2, 'acara-makrab-v3-2026', 'Acara Makrab V3 HMSE 2026', '2026-06-25 16:53:00', NULL, '<p>Bogor, 20-21 Juni 2026 - <strong>Himpunan Mahasiswa Software Engineering (HMSE)</strong> sukses menggelar acara Malam Keakraban (Makrab) V3 sekaligus merayakan Milad ke-2 HMSE.</p>', '2026-07-28 16:57:26', '2026-07-28 16:57:26'),
(4, 'tes-fungsi-37566', 'Tes Fungsi', '2026-07-28 12:14:00', 'Rinkin', 'Tes', '2026-07-28 17:14:58', '2026-07-28 17:14:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news_photos`
--

DROP TABLE IF EXISTS `news_photos`;
CREATE TABLE `news_photos` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `news_photos`:
--   `news_id`
--       `news` -> `id`
--

--
-- Dumping data untuk tabel `news_photos`
--

INSERT INTO `news_photos` (`id`, `news_id`, `filename`, `sort_order`, `created_at`) VALUES
(1, 1, 'foto.jpg', 1, '2026-07-28 16:57:26'),
(2, 1, 'computer_1.jpg', 2, '2026-07-28 16:57:26'),
(3, 2, 'foto.jpg', 1, '2026-07-28 16:57:26'),
(5, 4, 'img_6a688122381687.16091491.jpeg', 0, '2026-07-28 17:14:58'),
(6, 4, 'img_6a6881223855c9.21645020.jpg', 0, '2026-07-28 17:14:58'),
(7, 4, 'img_6a688122389629.74399279.jpg', 0, '2026-07-28 17:14:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

DROP TABLE IF EXISTS `periode`;
CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `start_year` int(11) NOT NULL,
  `end_year` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `periode`:
--

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`id`, `start_year`, `end_year`, `sort_order`, `created_at`) VALUES
(6, 2024, 2025, 0, '2026-08-01 20:59:19'),
(9, 2025, 2026, 0, '2026-08-02 23:38:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `program_kerja`
--

DROP TABLE IF EXISTS `program_kerja`;
CREATE TABLE `program_kerja` (
  `id` int(11) NOT NULL,
  `periode_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `program_kerja`:
--   `periode_id`
--       `periode` -> `id`
--

--
-- Dumping data untuk tabel `program_kerja`
--

INSERT INTO `program_kerja` (`id`, `periode_id`, `title`, `description`, `sort_order`, `created_at`) VALUES
(7, 6, 'Tarung AYam', 'Ayam Jago', 0, '2026-08-01 21:17:36'),
(8, 6, 'Tes 1', 'Tes ulang', 0, '2026-08-02 23:27:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur_nodes`
--

DROP TABLE IF EXISTS `struktur_nodes`;
CREATE TABLE `struktur_nodes` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `group_type` enum('leader','branch','division') DEFAULT NULL,
  `node_key` varchar(50) DEFAULT NULL,
  `label` varchar(100) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `npm` varchar(30) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `instagram` varchar(150) DEFAULT NULL,
  `whatsapp` varchar(30) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `nid` varchar(30) DEFAULT NULL,
  `masa_jabatan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- RELATIONSHIPS FOR TABLE `struktur_nodes`:
--   `parent_id`
--       `struktur_nodes` -> `id`
--

--
-- Dumping data untuk tabel `struktur_nodes`
--

INSERT INTO `struktur_nodes` (`id`, `parent_id`, `group_type`, `node_key`, `label`, `name`, `npm`, `semester`, `alamat`, `instagram`, `whatsapp`, `email`, `photo`, `icon`, `sort_order`, `created_at`, `nid`, `masa_jabatan`) VALUES
(1, NULL, 'leader', 'kaprodi', 'Kepala Program Studi', 'Gusti Nyoman Budiadnyana, S.Kom., MM.', '', '', 'Telaga Bestari', '@gustibudiadnyana', '085717296717', '', 'img_6a717d11180fa3.59241067.jpg', NULL, 1, '2026-07-28 16:57:26', '04-2804-7602', ''),
(2, NULL, 'leader', 'ketua', 'Ketua Umum', 'Ahmad Nurohman', '2024807033', '4', 'Pasar Kemis', 'ahmadnurohman', '083845656653', 'ahmad@example.com', 'img_6a717f29d33147.95855272.jpg', NULL, 2, '2026-07-28 16:57:26', NULL, NULL),
(3, NULL, 'leader', 'wakil', 'Wakil Ketua Umum', 'Ramadhan Putra Adi Nugraha Bangaskrama', '2025807042', '2', 'Cikupa', '@rambngskrm', '081586738381', '', 'img_6a7180786cc5d5.87912368.jpg', NULL, 3, '2026-07-28 16:57:26', NULL, NULL),
(4, NULL, 'branch', 'sekretaris', 'Cabang', 'Sekretaris', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'edit_note', 4, '2026-07-28 16:57:26', NULL, NULL),
(5, 4, NULL, NULL, 'Anggota Sekretaris', 'Nur Ramadhani', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2026-07-28 16:57:26', NULL, NULL),
(6, 4, NULL, NULL, 'Anggota Sekretaris', 'Chika Anggi Taryana', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2026-07-28 16:57:26', NULL, NULL),
(7, NULL, 'branch', 'bendahara', 'Cabang', 'Bendahara', '', '', '', '', '', '', 'img_6a7180b6c79755.08107768.jpg', 'account_balance_wallet', 5, '2026-07-28 16:57:26', NULL, NULL),
(8, 7, NULL, NULL, 'Anggota Bendahara', 'Sahriyal Riza Saputra', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2026-07-28 16:57:26', NULL, NULL),
(9, 7, NULL, NULL, 'Anggota Bendahara', 'Dilla Alvena', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, '2026-07-28 16:57:26', NULL, NULL),
(10, NULL, 'division', 'kominfo', 'Divisi', 'Kominfo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'campaign', 6, '2026-07-28 16:57:26', NULL, NULL),
(11, NULL, 'division', 'humas', 'Divisi', 'Humas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'groups', 7, '2026-07-28 16:57:26', NULL, NULL),
(12, NULL, 'division', 'litbang', 'Divisi', 'Litbang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'science', 8, '2026-07-28 16:57:26', NULL, NULL),
(13, NULL, 'division', 'sapras', 'Divisi', 'Sapras', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'construction', 9, '2026-07-28 16:57:26', NULL, NULL),
(14, NULL, 'division', 'olahraga', 'Divisi', 'Olahraga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sports_soccer', 10, '2026-07-28 16:57:26', NULL, NULL),
(15, NULL, 'division', 'sdm', 'Divisi', 'SDM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'badge', 11, '2026-07-28 16:57:26', NULL, NULL),
(16, 10, NULL, NULL, 'Ketua Kominfo', 'Didik', '2024807041', '4', 'rumah sakit', 'rinx2_7', '081218390639', 'shiryumin27@gmail.com', 'img_6a699ce78b7a58.90249166.jpg', NULL, 0, '2026-07-29 13:25:43', NULL, NULL),
(17, 4, NULL, NULL, 'Sekretaris', 'Sherly Mila Saputri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 17:23:09', NULL, NULL),
(18, 7, NULL, NULL, 'Bendahara', 'Amelia Virnada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2026-07-31 17:23:09', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gallery_photos`
--
ALTER TABLE `gallery_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `news_photos`
--
ALTER TABLE `news_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indeks untuk tabel `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `program_kerja`
--
ALTER TABLE `program_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periode_id` (`periode_id`);

--
-- Indeks untuk tabel `struktur_nodes`
--
ALTER TABLE `struktur_nodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `gallery_photos`
--
ALTER TABLE `gallery_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `news_photos`
--
ALTER TABLE `news_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `program_kerja`
--
ALTER TABLE `program_kerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `struktur_nodes`
--
ALTER TABLE `struktur_nodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `news_photos`
--
ALTER TABLE `news_photos`
  ADD CONSTRAINT `news_photos_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `program_kerja`
--
ALTER TABLE `program_kerja`
  ADD CONSTRAINT `program_kerja_ibfk_1` FOREIGN KEY (`periode_id`) REFERENCES `periode` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `struktur_nodes`
--
ALTER TABLE `struktur_nodes`
  ADD CONSTRAINT `struktur_nodes_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `struktur_nodes` (`id`) ON DELETE CASCADE;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
