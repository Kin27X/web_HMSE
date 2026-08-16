<?php
/**
 * migrate_branch_categories.php — jalankan SEKALI kalau database kamu
 * SUDAH ADA ISINYA sebelumnya (bukan database baru), untuk membenahi
 * struktur Sekretaris/Bendahara supaya sama seperti Divisi:
 *
 * SEBELUM: kepala cabang "Sekretaris" langsung diisi data Sherly (nama,
 *          npm, dst) -- makanya di mobile yang tampil nama dia, bukan
 *          "Sekretaris".
 * SESUDAH: kepala cabang "Sekretaris" cuma label kategori (kayak
 *          "Kominfo"), dan Sherly jadi ANGGOTA di dalamnya dengan
 *          jabatan "Sekretaris". Data Sherly (foto, npm, dst kalau ada)
 *          dipindah otomatis, tidak hilang.
 *
 * Aman dijalankan berkali-kali -- kalau sudah pernah dimigrasi (kepala
 * cabang sudah bernama persis "Sekretaris"/"Bendahara"), baris itu
 * dilewati begitu saja.
 */

require __DIR__ . '/config.php';
$pdo = getDbConnection();

function migrateBranch(PDO $pdo, string $nodeKey, string $categoryName, string $icon): void {

    $stmt = $pdo->prepare("SELECT * FROM struktur_nodes WHERE node_key = ? AND group_type = 'branch'");
    $stmt->execute([$nodeKey]);
    $branch = $stmt->fetch();

    if (!$branch) {
        echo "Cabang '$nodeKey' tidak ditemukan, dilewati.\n";
        return;
    }

    if ($branch['name'] === $categoryName) {
        echo "Cabang '$nodeKey' sudah dalam bentuk kategori, tidak ada yang perlu dimigrasi.\n";
        return;
    }

    // Pindahkan data orang yang sekarang jadi jadi anggota baru (jabatan = nama kategori, mis. "Sekretaris")
    $insert = $pdo->prepare('INSERT INTO struktur_nodes
        (parent_id, group_type, label, name, npm, semester, alamat, instagram, whatsapp, email, photo, sort_order)
        VALUES (?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)');
    $insert->execute([
        $branch['id'], $categoryName, $branch['name'],
        $branch['npm'], $branch['semester'], $branch['alamat'],
        $branch['instagram'], $branch['whatsapp'], $branch['email'], $branch['photo'],
    ]);

    // Geser sort_order anggota lama yang sudah ada (biar anggota "pindahan" ini di depan)
    $pdo->prepare('UPDATE struktur_nodes SET sort_order = sort_order + 1 WHERE parent_id = ? AND id != ?')
        ->execute([$branch['id'], $pdo->lastInsertId()]);

    // Ubah kepala cabang jadi kategori polos (seperti Divisi)
    $pdo->prepare('UPDATE struktur_nodes SET
        label = ?, name = ?, npm = NULL, semester = NULL, alamat = NULL,
        instagram = NULL, whatsapp = NULL, email = NULL, photo = NULL, icon = ?
        WHERE id = ?')
        ->execute(['Cabang', $categoryName, $icon, $branch['id']]);

    echo "Cabang '$nodeKey' berhasil dimigrasi -- '{$branch['name']}' sekarang jadi anggota dengan jabatan '$categoryName'.\n";
}

migrateBranch($pdo, 'sekretaris', 'Sekretaris', 'edit_note');
migrateBranch($pdo, 'bendahara', 'Bendahara', 'account_balance_wallet');

echo "\nMigrasi selesai.\n";
