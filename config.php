<?php

/**
 * config.php — pusat pengaturan koneksi database.
 *
 * Ada 2 mode:
 * - 'sqlite' : dipakai buat coba-coba/testing di komputer sendiri,
 *              tanpa perlu install MySQL. File databasenya ada di
 *              data/hmse.sqlite, otomatis dibuat oleh setup_sqlite.php.
 * - 'mysql'  : dipakai kalau sudah upload ke hosting kampus (yang
 *              sudah pasti support PHP+MySQL). Tinggal ganti
 *              DB_DRIVER jadi 'mysql' dan isi 4 baris di bawahnya
 *              sesuai data phpMyAdmin/cPanel kampus, lalu import
 *              database/schema.sql lewat phpMyAdmin.
 */

// -------- GANTI DI SINI kalau sudah pindah ke hosting asli --------
define('DB_DRIVER', 'mysql'); // ganti jadi 'mysql' kalau sudah di hosting

define('DB_HOST', 'localhost');
define('DB_NAME', 'web_hmse');
define('DB_USER', 'root');
define('DB_PASS', '');
// --------------------------------------------------------------------

function getDbConnection(): PDO
{

    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    if (DB_DRIVER === 'sqlite') {
        $path = __DIR__ . '/data/hmse.sqlite';
        $pdo = new PDO('sqlite:' . $path);
    } else {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
    }

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    if (DB_DRIVER === 'sqlite') {
        $pdo->exec('PRAGMA foreign_keys = ON;');
    }

    return $pdo;
}

/**
 * assetVersion($relativePath) — dipakai di link CSS/JS, mis:
 * <link rel="stylesheet" href="../css/program-kerja.css?v=<?= assetVersion('css/program-kerja.css') ?>">
 *
 * Nilainya diambil dari waktu file itu TERAKHIR DIUBAH (filemtime). Jadi
 * tiap kali file CSS/JS-nya diedit, nomor versinya otomatis berubah,
 * dan browser WAJIB ambil ulang versi baru -- tidak akan pernah lagi
 * "sudah diganti tapi browser masih nampilin yang lama" karena ke-cache.
 */
function assetVersion(string $relativePath): string
{
    $fullPath = __DIR__ . '/' . ltrim($relativePath, '/');
    return file_exists($fullPath) ? (string) filemtime($fullPath) : '1';
}
