<?php
/**
 * migrate_add_kaprodi_fields.php — jalankan SEKALI kalau database kamu
 * SUDAH ADA ISINYA sebelumnya (dibuat sebelum kolom nid/masa_jabatan
 * ditambahkan). Cukup nambah 2 kolom baru ke tabel struktur_nodes,
 * data yang sudah ada TIDAK disentuh/dihapus sama sekali.
 *
 * Aman dijalankan berkali-kali -- kalau kolomnya sudah ada, dilewati.
 */

require __DIR__ . '/config.php';
$pdo = getDbConnection();

function columnExists(PDO $pdo, string $table, string $column): bool {
    if (DB_DRIVER === 'sqlite') {
        $stmt = $pdo->query("PRAGMA table_info($table)");
        foreach ($stmt->fetchAll() as $col) {
            if ($col['name'] === $column) return true;
        }
        return false;
    }
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.columns WHERE table_name = ? AND column_name = ? AND table_schema = DATABASE()");
    $stmt->execute([$table, $column]);
    return (int) $stmt->fetchColumn() > 0;
}

$type = DB_DRIVER === 'sqlite' ? 'TEXT' : 'VARCHAR(30)';
$typeJabatan = DB_DRIVER === 'sqlite' ? 'TEXT' : 'VARCHAR(50)';

if (columnExists($pdo, 'struktur_nodes', 'nid')) {
    echo "Kolom 'nid' sudah ada, dilewati.\n";
} else {
    $pdo->exec("ALTER TABLE struktur_nodes ADD COLUMN nid $type NULL");
    echo "Kolom 'nid' berhasil ditambahkan.\n";
}

if (columnExists($pdo, 'struktur_nodes', 'masa_jabatan')) {
    echo "Kolom 'masa_jabatan' sudah ada, dilewati.\n";
} else {
    $pdo->exec("ALTER TABLE struktur_nodes ADD COLUMN masa_jabatan $typeJabatan NULL");
    echo "Kolom 'masa_jabatan' berhasil ditambahkan.\n";
}

echo "\nMigrasi selesai. Sekarang buka admin -> Struktur -> Edit Kaprodi untuk isi NID & Masa Jabatan.\n";
