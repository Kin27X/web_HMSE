<?php
/**
 * setup_sqlite.php — jalankan SEKALI buat bikin database percobaan
 * lokal (data/hmse.sqlite) berisi semua tabel + beberapa data contoh,
 * supaya admin panel & halaman publik bisa langsung dicoba sebelum
 * pindah ke MySQL/XAMPP asli. Aman dijalankan berkali-kali (akan
 * menghapus & membuat ulang tabel tiap kali).
 */

require __DIR__ . '/config.php';

if (DB_DRIVER !== 'sqlite') {
    die("Script ini cuma untuk mode sqlite. DB_DRIVER saat ini: " . DB_DRIVER);
}

@mkdir(__DIR__ . '/data', 0777, true);

$pdo = getDbConnection();
$pdo->exec('PRAGMA foreign_keys = OFF;');

foreach (['admin_users','periode','program_kerja','events','struktur_nodes','gallery_photos','news_photos','news'] as $t) {
    $pdo->exec("DROP TABLE IF EXISTS $t");
}

$pdo->exec("CREATE TABLE admin_users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL UNIQUE,
  password_hash TEXT NOT NULL,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE periode (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  start_year INTEGER NOT NULL,
  end_year INTEGER NOT NULL,
  sort_order INTEGER DEFAULT 0,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE program_kerja (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  periode_id INTEGER NOT NULL,
  title TEXT NOT NULL,
  description TEXT,
  sort_order INTEGER DEFAULT 0,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (periode_id) REFERENCES periode(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE events (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  place TEXT,
  event_time TEXT,
  event_date TEXT NOT NULL,
  photo TEXT,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE struktur_nodes (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  parent_id INTEGER,
  group_type TEXT,
  node_key TEXT,
  label TEXT,
  name TEXT NOT NULL,
  npm TEXT,
  semester TEXT,
  alamat TEXT,
  instagram TEXT,
  whatsapp TEXT,
  email TEXT,
  photo TEXT,
  icon TEXT,
  sort_order INTEGER DEFAULT 0,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (parent_id) REFERENCES struktur_nodes(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE gallery_photos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  photo TEXT NOT NULL,
  category TEXT NOT NULL,
  sort_order INTEGER DEFAULT 0,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE news (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  slug TEXT NOT NULL UNIQUE,
  title TEXT NOT NULL,
  event_datetime TEXT NOT NULL,
  author TEXT,
  body_html TEXT,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP,
  updated_at TEXT DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE news_photos (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  news_id INTEGER NOT NULL,
  filename TEXT NOT NULL,
  sort_order INTEGER DEFAULT 0,
  created_at TEXT DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE
)");

$pdo->exec('PRAGMA foreign_keys = ON;');

// ---------- SEED: akun admin ----------
$stmt = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
$stmt->execute(['admin', password_hash('hmse2026', PASSWORD_DEFAULT)]);

// ---------- SEED: periode + program kerja ----------
$periodeStmt = $pdo->prepare('INSERT INTO periode (start_year, end_year, sort_order) VALUES (?,?,?)');
$periodeStmt->execute([2025, 2026, 1]);
$periode1 = $pdo->lastInsertId();
$periodeStmt->execute([2024, 2025, 2]);
$periode2 = $pdo->lastInsertId();

$prokerStmt = $pdo->prepare('INSERT INTO program_kerja (periode_id, title, description, sort_order) VALUES (?,?,?,?)');
$prokerStmt->execute([$periode1, 'Makrab (Malam Keakraban)', 'Refreshing/jalan-jalan bersama Kaprodi SE dalam rangka belajar & mengajak kepada mahasiswa/i yang ada di prodi SE untuk ikut serta berkontribusi dalam acara makrab tersebut.', 1]);
$prokerStmt->execute([$periode1, 'Bootcamp', 'Pelatihan intensif seputar pengembangan perangkat lunak untuk mahasiswa/i SE.', 2]);
$prokerStmt->execute([$periode1, 'LDKO', 'Latihan Dasar Kepemimpinan Organisasi bagi calon pengurus dan anggota aktif HMSE.', 3]);

// ---------- SEED: events (contoh: 1 sudah lewat, 2 akan datang) ----------
$eventStmt = $pdo->prepare('INSERT INTO events (title, place, event_time, event_date, photo) VALUES (?,?,?,?,?)');
$eventStmt->execute(['Makrab (Malam Keakraban)', 'Villa Puncak, Bogor', '08.00 - selesai', '2025-06-25', null]);
$eventStmt->execute(['Bootcamp Web Development', 'Lab Komputer Kampus', '13.00 - 16.00', '2026-08-14', 'home.png']);
$eventStmt->execute(['Seminar Teknologi & Karir', 'Aula Saba Karya', '09.00 - 12.00', '2026-09-05', 'foto.jpg']);

// ---------- SEED: struktur organisasi ----------
$nodeStmt = $pdo->prepare('INSERT INTO struktur_nodes (parent_id, group_type, node_key, label, name, npm, semester, alamat, instagram, whatsapp, email, photo, icon, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

$nodeStmt->execute([null, 'leader', 'kaprodi', 'Kaprodi', 'Gusti Nyoman Budiadnyana, S.Kom., MM.', null, null, null, null, null, null, null, null, 1]);
$nodeStmt->execute([null, 'leader', 'ketua', 'Ketua Umum', 'Ahmad Nurohman', '2024807033', '4', 'Pasar Kemis', 'ahmadnurohman', '081234567890', 'ahmad@example.com', null, null, 2]);
$nodeStmt->execute([null, 'leader', 'wakil', 'Wakil Ketua Umum', 'Ramadhan Putra Adi Nugraha Bangaskrama', null, null, null, null, null, null, 'Rama2.jpeg', null, 3]);

// Sekretaris & Bendahara sekarang jadi "kategori" (persis pola Divisi):
// kepala cabang cuma label ("Sekretaris"/"Bendahara" + ikon), BUKAN data
// orang -- orang yang menjabat jadi ANGGOTA di dalamnya (biar konsisten
// sama Divisi, dan supaya nama JABATAN yang tampil, bukan nama orang).
$nodeStmt->execute([null, 'branch', 'sekretaris', 'Cabang', 'Sekretaris', null, null, null, null, null, null, null, 'edit_note', 4]);
$sekId = $pdo->lastInsertId();
$nodeStmt->execute([$sekId, null, null, 'Sekretaris', 'Sherly Mila Saputri', null, null, null, null, null, null, null, null, 1]);
$nodeStmt->execute([$sekId, null, null, 'Anggota Sekretaris', 'Nur Ramadhani', null, null, null, null, null, null, null, null, 2]);
$nodeStmt->execute([$sekId, null, null, 'Anggota Sekretaris', 'Chika Anggi Taryana', null, null, null, null, null, null, null, null, 3]);

$nodeStmt->execute([null, 'branch', 'bendahara', 'Cabang', 'Bendahara', null, null, null, null, null, null, null, 'account_balance_wallet', 5]);
$benId = $pdo->lastInsertId();
$nodeStmt->execute([$benId, null, null, 'Bendahara', 'Amelia Virnada', null, null, null, null, null, null, null, null, 1]);
$nodeStmt->execute([$benId, null, null, 'Anggota Bendahara', 'Sahriyal Riza Saputra', null, null, null, null, null, null, null, null, 2]);
$nodeStmt->execute([$benId, null, null, 'Anggota Bendahara', 'Dilla Alvena', null, null, null, null, null, null, null, null, 3]);

$divisions = [
  ['kominfo', 'Kominfo', 'campaign', 6],
  ['humas', 'Humas', 'groups', 7],
  ['litbang', 'Litbang', 'science', 8],
  ['sapras', 'Sapras', 'construction', 9],
  ['olahraga', 'Olahraga', 'sports_soccer', 10],
  ['sdm', 'SDM', 'badge', 11],
];
foreach ($divisions as [$key, $name, $icon, $order]) {
    $nodeStmt->execute([null, 'division', $key, 'Divisi', $name, null, null, null, null, null, null, null, $icon, $order]);
}

// ---------- SEED: gallery (flat, per kategori) ----------
$galleryStmt = $pdo->prepare('INSERT INTO gallery_photos (photo, category, sort_order) VALUES (?,?,?)');
$galleryStmt->execute(['motif_biru.jpg', 'olahraga', 1]);
$galleryStmt->execute(['home.png', 'belajar', 2]);
$galleryStmt->execute(['computer_1.jpg', 'belajar', 3]);
$galleryStmt->execute(['foto.jpg', 'event', 4]);

// ---------- SEED: news + foto ----------
$newsStmt = $pdo->prepare('INSERT INTO news (slug, title, event_datetime, author, body_html) VALUES (?,?,?,?,?)');
$newsStmt->execute([
  'trinitycamp-iot-series', 'Trinitycamp: IoT Series', '2026-07-10 18:52:00',
  'Fahri Haidar Daffa, Aflahal Bambang Jaya',
  '<p>Tangerang, 28 Juni & 05 Juli 2026 - Kolaborasi tiga himpunan mahasiswa, yaitu <strong>Himpunan Mahasiswa Software Engineering (HMSE)</strong>, <strong>Himpunan Mahasiswa Sistem Informasi (HMSI)</strong>, dan <strong>Himpunan Mahasiswa Teknologi Informasi (HMTI)</strong>, sukses menyelenggarakan kegiatan <strong>TrinityCamp: IoT Series</strong> dengan mengusung tema <strong>"From Coin to Screen"</strong>.</p><p>Kegiatan yang berlangsung selama dua hari, pada tanggal 28 Juni 2026 dan 05 Juli 2026, bertempat di Universitas Insan Pembangunan Indonesia.</p>'
]);
$news1 = $pdo->lastInsertId();
$photoStmt = $pdo->prepare('INSERT INTO news_photos (news_id, filename, sort_order) VALUES (?,?,?)');
$photoStmt->execute([$news1, 'foto.jpg', 1]);
$photoStmt->execute([$news1, 'computer_1.jpg', 2]);

$newsStmt->execute([
  'acara-makrab-v3-2026', 'Acara Makrab V3 HMSE 2026', '2026-06-25 16:53:00', null,
  '<p>Bogor, 20-21 Juni 2026 - <strong>Himpunan Mahasiswa Software Engineering (HMSE)</strong> sukses menggelar acara Malam Keakraban (Makrab) V3 sekaligus merayakan Milad ke-2 HMSE.</p>'
]);
$news2 = $pdo->lastInsertId();
$photoStmt->execute([$news2, 'foto.jpg', 1]);

echo "Setup selesai!\n";
echo "Login admin: username = admin / password = hmse2026\n";
echo "PENTING: ganti password ini setelah login pertama kali.\n";