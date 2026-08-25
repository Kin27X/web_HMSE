<?php
require __DIR__ . '/includes/auth.php';
requireLogin();
require __DIR__ . '/../config.php';
require __DIR__ . '/includes/helpers.php';

$pdo = getDbConnection();
$newsList = $pdo->query('SELECT n.*, (SELECT COUNT(*) FROM news_photos np WHERE np.news_id = n.id) AS jumlah_foto
                          FROM news n ORDER BY event_datetime DESC')->fetchAll();

$pageTitle = 'News';
$currentNav = 'news';
require __DIR__ . '/includes/header.php';
?>

<div class="admin-title-row">
    <h2>News</h2>
    <a class="btn" href="news-form.php"><i class="material-icons" style="font-size:16px;">add</i> Berita Baru</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="flash flash-success"><?= e($_GET['msg']) ?></div>
<?php endif; ?>

<?php if (empty($newsList)): ?>
    <div class="admin-empty">Belum ada berita.</div>
<?php else: ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Author</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($newsList as $n): ?>
                <tr>
                    <td><?= e($n['title']) ?></td>
                    <td><?= e(date('d M Y, H:i', strtotime($n['event_datetime']))) ?></td>
                    <td><?= e($n['author'] ?: '-') ?></td>
                    <td><?= (int)$n['jumlah_foto'] ?> foto</td>
                    <td class="actions">
                        <a class="btn btn-secondary btn-small" href="news-form.php?id=<?= (int)$n['id'] ?>">Edit</a>
                        <form class="confirm-delete-form" method="POST" action="news-delete.php" onsubmit="return confirm('Hapus berita \'<?= e($n['title']) ?>\'?');">
                            <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-small">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

