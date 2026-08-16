-- =========================================================
-- SKEMA DATABASE HMSE — untuk hosting MySQL (import lewat phpMyAdmin / XAMPP)
-- =========================================================

CREATE TABLE admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ================= PROGRAM KERJA =================
CREATE TABLE periode (
  id INT AUTO_INCREMENT PRIMARY KEY,
  start_year INT NOT NULL,
  end_year INT NOT NULL,
  sort_order INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE program_kerja (
  id INT AUTO_INCREMENT PRIMARY KEY,
  periode_id INT NOT NULL,
  title VARCHAR(200) NOT NULL,
  description TEXT NULL,
  sort_order INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (periode_id) REFERENCES periode(id) ON DELETE CASCADE
);

-- ================= EVENT SCHEDULE =================
-- Maksimal 5 baris aktif ditahan dari sisi aplikasi (form admin), bukan
-- dari database. Event yang event_date-nya sudah lewat TETAP ada di
-- tabel ini (supaya admin masih bisa lihat riwayatnya) -- yang
-- menyembunyikannya dari halaman publik adalah query publiknya
-- (WHERE event_date >= CURDATE()), bukan penghapusan baris.
CREATE TABLE events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  place VARCHAR(200) NULL,
  event_time VARCHAR(100) NULL,
  event_date DATE NOT NULL,
  photo VARCHAR(255) NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ================= STRUKTUR ORGANISASI =================
-- Satu tabel pohon (adjacency list). group_type cuma diisi utk baris
-- "kepala/akar" (parent_id NULL): 'leader' utk rantai Kaprodi/Ketua/
-- Wakil Ketua, 'branch' utk Sekretaris/Bendahara, 'division' utk tiap
-- divisi (Kominfo dst -- admin bebas nambah divisi baru). Baris anggota
-- biasa (parent_id mengarah ke salah satu baris kepala) punya
-- group_type NULL. instagram/whatsapp/email disimpan POLOS (bukan URL
-- lengkap) -- link dibentuk otomatis saat ditampilkan.
CREATE TABLE struktur_nodes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  parent_id INT NULL,
  group_type ENUM('leader','branch','division') NULL,
  node_key VARCHAR(50) NULL,
  label VARCHAR(100) NULL,
  name VARCHAR(200) NOT NULL,
  npm VARCHAR(30) NULL,
  semester VARCHAR(10) NULL,
  alamat VARCHAR(150) NULL,
  instagram VARCHAR(150) NULL,
  whatsapp VARCHAR(30) NULL,
  email VARCHAR(150) NULL,
  photo VARCHAR(255) NULL,
  icon VARCHAR(50) NULL,
  sort_order INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (parent_id) REFERENCES struktur_nodes(id) ON DELETE CASCADE
);

-- ================= GALLERY =================
-- Flat -- satu baris = satu foto + satu kategori, tanpa pengelompokan album.
CREATE TABLE gallery_photos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  photo VARCHAR(255) NOT NULL,
  category ENUM('olahraga','belajar','event') NOT NULL,
  sort_order INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ================= NEWS =================
CREATE TABLE news (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(150) NOT NULL UNIQUE,
  title VARCHAR(200) NOT NULL,
  event_datetime DATETIME NOT NULL,
  author VARCHAR(150) NULL,
  body_html LONGTEXT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE news_photos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  news_id INT NOT NULL,
  filename VARCHAR(255) NOT NULL,
  sort_order INT DEFAULT 0,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE
);
