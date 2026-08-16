<?php
require __DIR__ . '/../config.php';
$pdo = getDbConnection();

$hariIndo = [0=>'Minggu',1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu'];
$bulanIndo = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

function makeExcerpt(string $html, int $len = 160): string {
    $text = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
    return strlen($text) > $len ? substr($text, 0, $len) . '...' : $text;
}

$rows = $pdo->query('SELECT * FROM news ORDER BY event_datetime DESC')->fetchAll();

$thumbStmt = $pdo->prepare('SELECT filename FROM news_photos WHERE news_id = ? ORDER BY sort_order ASC, id ASC LIMIT 1');

$newsArticles = array_map(function($n) use ($hariIndo, $bulanIndo, $thumbStmt) {
    $ts = strtotime($n['event_datetime']);
    $thumbStmt->execute([$n['id']]);
    $thumb = $thumbStmt->fetchColumn();

    return [
        'id' => $n['slug'],
        'title' => $n['title'],
        'dateISO' => date('Y-m-d\TH:i', $ts),
        'dateDisplay' => $hariIndo[(int)date('w', $ts)] . ', ' . date('d', $ts) . ' ' . $bulanIndo[(int)date('n', $ts)] . ' ' . date('Y', $ts) . ' &middot; ' . date('H:i', $ts),
        'author' => $n['author'] ?: null,
        'thumbnail' => $thumb ? '../images/' . $thumb : '../images/logo2.png',
        'excerpt' => makeExcerpt($n['body_html'] ?? ''),
    ];
}, $rows);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - HMSE</title>
    <link rel="icon" type="image/png" href="../images/logo2.png">
    <link rel="apple-touch-icon" href="../images/logo2.png">
    <link rel="stylesheet" href="../css/style.css?v=<?= assetVersion('css/style.css') ?>">
    <link rel="stylesheet" href="../css/news.css?v=<?= assetVersion('css/news.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>
<body>

    <header id="navbar">
        <nav class="navbar">

            <div class="nav-bg-gray"></div>

            <div class="brand">
                <img class="logo" src="../images/logo2.png" alt="logo HMSE">
                <span>HMSE</span>
            </div>

            <ul class="menu" id="menu">
                <li class="menu-header">
                    <div class="brand">
                        <img class="logo" src="../images/logo2.png" alt="logo HMSE">
                        <span>HMSE</span>
                    </div>
                    <span class="menu-close" id="menuClose" aria-label="Tutup menu">&times;</span>
                </li>
                <li class="nav-li"><a href="index.html">Home</a></li>
                <li class="nav-li drop">
                    <div class="drop-btn">
                      About
                      <span class="material-icons dropdown-icon">
                        arrow_drop_down
                      </span>
                    </div>

                    <div class="dropdown">
                      <ul class="dropdown-inner">
                        <li><a href="visi_&amp;_misi.html">Visi & Misi</a></li>
                        <li><a href="program-kerja.php">Program Kerja</a></li>
                        <li><a href="event-schedule.php">Event Schedule</a></li>
                        <li><a href="struktur.php">Struktur Organisasi</a></li>
                      </ul>
                    </div>

                </li>
                <li class="nav-li"><a href="gallery.php">Gallery</a></li>
                <li class="nav-li current"><a href="news.php">News</a></li>
                <li class="nav-li mobile-btn">
                    <a class="btn" href="#"><button>Contact</button></a>
                </li>
            </ul>

            <div class="nav-accent">
                <span class="accent-circle"></span>
                <div class="button">
                    <a class="btn" href="#"><button>Contact</button></a>
                </div>
            </div>

            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </nav>

        <div class="menu-overlay" id="menuOverlay"></div>
    </header>

    <!-- ================= PAGE BANNER ================= -->
    <section class="nw-banner">
        <div class="nw-banner-glow"></div>
        <div class="nw-banner-content reveal reveal-up">
            <span class="section-eyebrow section-eyebrow-light">Informasi</span>
            <h1>News</h1>
            <p>Kabar &amp; dokumentasi kegiatan HMSE terbaru.</p>
        </div>
    </section>

    <!-- ================= NEWS ================= -->
    <section class="nw-section">

        <div class="nw-controls reveal reveal-up">

            <div class="nw-view-toggle" id="nwViewToggle">
                <button class="active" data-mode="list" aria-label="Tampilan daftar">
                    <i class="material-icons">view_list</i>
                </button>
                <button data-mode="grid" aria-label="Tampilan kotak-kotak">
                    <i class="material-icons">grid_view</i>
                </button>
            </div>

            <div class="nw-search">
                <i class="material-icons">search</i>
                <input type="text" id="nwSearchInput" placeholder="Cari berita...">
            </div>

        </div>

        <div class="nw-list" id="nwList"></div>
        <div class="nw-grid" id="nwGrid" hidden></div>

        <p class="nw-empty" id="nwEmpty" hidden>Tidak ada berita yang cocok dengan pencarianmu.</p>

        <div class="nw-pagination" id="nwPagination">
            <button class="nw-page-btn" id="nwPrevBtn" aria-label="Halaman sebelumnya">
                <i class="material-icons">chevron_left</i>
            </button>
            <span class="nw-page-label" id="nwPageLabel">Halaman 1 / 1</span>
            <button class="nw-page-btn" id="nwNextBtn" aria-label="Halaman berikutnya">
                <i class="material-icons">chevron_right</i>
            </button>
        </div>

    </section>

    <?php include __DIR__ . '/../admin/includes/footer.html'; ?>
    

    <script>
        const newsArticles = <?= json_encode($newsArticles, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="../js/index.js?v=<?= assetVersion('js/index.js') ?>"></script>
    <script src="../js/news-data.js?v=<?= assetVersion('js/news-data.js') ?>"></script>
    <script src="../js/news.js?v=<?= assetVersion('js/news.js') ?>"></script>

</body>
</html>