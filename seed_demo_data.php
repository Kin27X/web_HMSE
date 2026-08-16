<?php
/**
 * seed_demo_data.php — jalankan SEKALI lewat browser atau CLI, SETELAH
 * tabel-tabelnya sudah ada, untuk mengisi:
 * - 1 akun admin (wajib, kalau tidak ada ini kamu tidak bisa login sama sekali)
 * - beberapa data contoh di tiap modul, biar situsnya langsung ada isinya
 *
 * Beda dengan setup_sqlite.php (yang BIKIN TABEL + isi data, khusus mode
 * sqlite), file ini CUMA isi data (INSERT) -- jadi aman dipakai baik untuk
 * mode sqlite MAUPUN mysql, asal tabelnya sudah dibuat lebih dulu:
 * - mode sqlite -> tabel dibuat otomatis oleh setup_sqlite.php (skip file ini,
 *   tidak perlu, setup_sqlite.php sudah sekalian isi data)
 * - mode mysql (XAMPP/hosting asli) -> tabel dibuat dengan import
 *   database/schema.sql lewat phpMyAdmin, BARU jalankan file ini
 *
 * Aman dijalankan berkali-kali -- kalau akun admin sudah ada, file ini
 * cuma akan bilang "sudah pernah di-seed" dan tidak menggandakan data.
 */

require __DIR__ . '/config.php';
$pdo = getDbConnection();

$existing = $pdo->query('SELECT COUNT(*) FROM admin_users')->fetchColumn();
if ($existing > 0) {
    die("Sudah pernah di-seed sebelumnya (akun admin sudah ada). Tidak melakukan apa-apa, supaya data tidak dobel.\n");
}

// ---------- akun admin ----------
$stmt = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
$stmt->execute(['admin', password_hash('hmse2026', PASSWORD_DEFAULT)]);

// ---------- periode + program kerja ----------
$periodeStmt = $pdo->prepare('INSERT INTO periode (start_year, end_year, sort_order) VALUES (?,?,?)');
$periodeStmt->execute([2025, 2026, 1]);
$periode1 = $pdo->lastInsertId();
$periodeStmt->execute([2024, 2025, 2]);

$prokerStmt = $pdo->prepare('INSERT INTO program_kerja (periode_id, title, description, sort_order) VALUES (?,?,?,?)');
$prokerStmt->execute([$periode1, 'Makrab (Malam Keakraban)', 'Refreshing/jalan-jalan bersama Kaprodi SE dalam rangka belajar & mengajak kepada mahasiswa/i yang ada di prodi SE untuk ikut serta berkontribusi dalam acara makrab tersebut.', 1]);
$prokerStmt->execute([$periode1, 'Bootcamp', 'Pelatihan intensif seputar pengembangan perangkat lunak untuk mahasiswa/i SE.', 2]);
$prokerStmt->execute([$periode1, 'LDKO', 'Latihan Dasar Kepemimpinan Organisasi bagi calon pengurus dan anggota aktif HMSE.', 3]);

// ---------- events ----------
$eventStmt = $pdo->prepare('INSERT INTO events (title, place, event_time, event_date, photo) VALUES (?,?,?,?,?)');
$eventStmt->execute(['Makrab (Malam Keakraban)', 'Villa Puncak, Bogor', '08.00 - selesai', '2025-06-25', null]);
$eventStmt->execute(['Bootcamp Web Development', 'Lab Komputer Kampus', '13.00 - 16.00', '2026-08-14', 'home.png']);
$eventStmt->execute(['Seminar Teknologi & Karir', 'Aula Saba Karya', '09.00 - 12.00', '2026-09-05', 'foto.jpg']);

// ---------- struktur organisasi ----------
$nodeStmt = $pdo->prepare('INSERT INTO struktur_nodes (parent_id, group_type, node_key, label, name, npm, semester, alamat, instagram, whatsapp, email, photo, icon, sort_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');

$nodeStmt->execute([null, 'leader', 'kaprodi', 'Kaprodi', 'Gusti Nyoman Budiadnyana, S.Kom., MM.', null, null, null, null, null, null, null, null, 1]);
$nodeStmt->execute([null, 'leader', 'ketua', 'Ketua Umum', 'Ahmad Nurohman', '2024807033', '4', 'Pasar Kemis', 'ahmadnurohman', '081234567890', 'ahmad@example.com', null, null, 2]);
$nodeStmt->execute([null, 'leader', 'wakil', 'Wakil Ketua Umum', 'Ramadhan Putra Adi Nugraha Bangaskrama', null, null, null, null, null, null, 'Rama2.jpeg', null, 3]);

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

// ---------- gallery ----------
$galleryStmt = $pdo->prepare('INSERT INTO gallery_photos (photo, category, sort_order) VALUES (?,?,?)');
$galleryStmt->execute(['motif_biru.jpg', 'olahraga', 1]);
$galleryStmt->execute(['home.png', 'belajar', 2]);
$galleryStmt->execute(['computer_1.jpg', 'belajar', 3]);
$galleryStmt->execute(['foto.jpg', 'event', 4]);

// ---------- news + foto ----------
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

echo "Seed selesai!\n";
echo "Login admin: username = admin / password = hmse2026\n";
echo "PENTING: ganti password ini setelah login pertama kali.\n";