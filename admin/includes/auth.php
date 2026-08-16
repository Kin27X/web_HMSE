<?php
/**
 * auth.php — panggil file ini di baris paling atas SETIAP halaman
 * admin yang butuh login (dashboard, kelola news, kelola gallery,
 * kelola struktur, dst). Kalau belum login, otomatis dilempar ke
 * halaman login.
 */

session_start();

function isLoggedIn(): bool {
    return isset($_SESSION['admin_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
