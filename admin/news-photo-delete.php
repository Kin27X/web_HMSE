<?php
require __DIR__ . '/includes/auth.php';
requireLogin();
require __DIR__ . '/../config.php';

$newsId = (int)($_POST['news_id'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo_id'])) {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('DELETE FROM news_photos WHERE id = ?');
    $stmt->execute([(int)$_POST['photo_id']]);
}

header('Location: news-form.php?id=' . $newsId);
exit;
