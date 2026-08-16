<?php
require __DIR__ . '/includes/auth.php';
requireLogin();
require __DIR__ . '/../config.php';
require __DIR__ . '/includes/helpers.php';

$pdo = getDbConnection();
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$news = ['title' => '', 'event_datetime' => date('Y-m-d\TH:i'), 'author' => '', 'body_html' => ''];
$existingPhotos = [];
$error = '';

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if (!$found) { header('Location: news-list.php'); exit; }
    $news = $found;
    $news['event_datetime'] = str_replace(' ', 'T', substr($found['event_datetime'], 0, 16));

    $stmt = $pdo->prepare('SELECT * FROM news_photos WHERE news_id = ? ORDER BY sort_order ASC, id ASC');
    $stmt->execute([$id]);
    $existingPhotos = $stmt->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $eventDatetime = trim($_POST['event_datetime'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $bodyHtml = trim($_POST['body_html'] ?? '');

    if ($title === '' || $eventDatetime === '') {
        $error = 'Judul dan tanggal wajib diisi.';
    } else {

        $eventDatetimeSql = str_replace('T', ' ', $eventDatetime) . ':00';

        if ($id) {
            $stmt = $pdo->prepare('UPDATE news SET title=?, event_datetime=?, author=?, body_html=? WHERE id=?');
            $stmt->execute([$title, $eventDatetimeSql, $author, $bodyHtml, $id]);
            $newsId = $id;
        } else {
            $slug = makeSlug($title) . '-' . substr(uniqid(), -5);
            $stmt = $pdo->prepare('INSERT INTO news (slug, title, event_datetime, author, body_html) VALUES (?,?,?,?,?)');
            $stmt->execute([$slug, $title, $eventDatetimeSql, $author, $bodyHtml]);
            $newsId = (int)$pdo->lastInsertId();
        }

        // Tambahkan foto baru yang diupload (foto lama yang sudah ada tidak
        // disentuh -- dihapus lewat tombol "Hapus" masing-masing di bawah)
        $newPhotos = handleMultipleImageUploads('photos');
        if ($newPhotos) {
            $stmt = $pdo->prepare('INSERT INTO news_photos (news_id, filename) VALUES (?,?)');
            foreach ($newPhotos as $filename) {
                $stmt->execute([$newsId, $filename]);
            }
        }

        header('Location: news-list.php?msg=' . urlencode('Berita berhasil disimpan.'));
        exit;
    }
}

$pageTitle = $id ? 'Edit Berita' : 'Berita Baru';
$currentNav = 'news';
require __DIR__ . '/includes/header.php';
?>

<div class="admin-breadcrumb"><a href="news-list.php">&larr; Kembali</a></div>
<div class="admin-title-row"><h2><?= $id ? 'Edit Berita' : 'Berita Baru' ?></h2></div>

<?php if ($error): ?><div class="flash flash-error"><?= e($error) ?></div><?php endif; ?>

<div class="admin-card">
    <form class="admin-form" method="POST" enctype="multipart/form-data">

        <label for="title">Judul</label>
        <input type="text" id="title" name="title" value="<?= e($news['title']) ?>" required>

        <div class="field-row">
            <div>
                <label for="event_datetime">Tanggal &amp; Jam</label>
                <input type="datetime-local" id="event_datetime" name="event_datetime" value="<?= e($news['event_datetime']) ?>" required>
            </div>
            <div>
                <label for="author">Author</label>
                <input type="text" id="author" name="author" value="<?= e($news['author']) ?>" placeholder="opsional">
            </div>
        </div>

        <label for="body_html">Isi Berita</label>
        <textarea id="body_html" name="body_html" rows="10" placeholder="Boleh pakai tag HTML sederhana, mis. <p>...</p> atau <strong>...</strong>"><?= e($news['body_html']) ?></textarea>
        <p class="hint">Tiap paragraf dibungkus tag &lt;p&gt;...&lt;/p&gt;. Boleh pakai &lt;strong&gt; untuk teks tebal.</p>

        <?php if ($existingPhotos): ?>
            <label>Foto Saat Ini</label>
            <div style="display:flex; flex-wrap:wrap; gap:12px; margin-bottom:6px;">
                <?php foreach ($existingPhotos as $ph): ?>
                    <div style="text-align:center;">
                        <div style="width:90px; height:90px; border-radius:10px; overflow:hidden;">
                            <img src="../images/<?= e($ph['filename']) ?>" style="width:100%; height:100%; object-fit:cover;" alt="">
                        </div>
                        <form method="POST" action="news-photo-delete.php" onsubmit="return confirm('Hapus foto ini?');" style="margin-top:4px;">
                            <input type="hidden" name="photo_id" value="<?= (int)$ph['id'] ?>">
                            <input type="hidden" name="news_id" value="<?= (int)$id ?>">
                            <button type="submit" class="btn btn-danger btn-small" style="padding:3px 10px; font-size:11px;">Hapus</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <label for="photos"><?= $existingPhotos ? 'Tambah Foto Lagi' : 'Foto (bisa pilih lebih dari satu)' ?></label>
        <input type="file" id="photos" name="photos[]" accept="image/*" multiple>

        <div class="form-actions">
            <button type="submit" class="btn">Simpan</button>
            <a class="btn btn-secondary" href="news-list.php">Batal</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
