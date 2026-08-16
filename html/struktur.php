<?php
require __DIR__ . '/../config.php';
$pdo = getDbConnection();

$allNodes = $pdo->query('SELECT * FROM struktur_nodes ORDER BY sort_order ASC, id ASC')->fetchAll();

$leaders = []; $branches = []; $divisions = []; $childrenByParent = [];

foreach ($allNodes as $n) {
    if ($n['parent_id']) {
        $childrenByParent[$n['parent_id']][] = $n;
    } elseif ($n['group_type'] === 'leader') {
        $leaders[] = $n;
    } elseif ($n['group_type'] === 'branch') {
        $branches[] = $n;
    } elseif ($n['group_type'] === 'division') {
        $divisions[] = $n;
    }
}

function nodeToJs(array $n, ?array $childrenByParent = null): array {
    $out = [
        'id' => 'n' . $n['id'],
        'label' => $n['label'],
        'name' => $n['name'],
        'npm' => $n['npm'] ?: null,
        'semester' => $n['semester'] ?: null,
        'nid' => $n['nid'] ?: null,
        'masaJabatan' => $n['masa_jabatan'] ?: null,
        'alamat' => $n['alamat'] ?: null,
        'instagram' => $n['instagram'] ?: null,
        'whatsapp' => $n['whatsapp'] ?: null,
        'email' => $n['email'] ?: null,
        'photo' => $n['photo'] ? '../images/' . $n['photo'] : null,
        'icon' => $n['icon'] ?: null,
        // true khusus utk kepala cabang/divisi (Sekretaris, Kominfo, dst) --
        // itu label kategori, bukan data orang, jadi tidak perlu hover/tap detail.
        'isCategory' => in_array($n['group_type'], ['branch', 'division'], true),
    ];
    if ($childrenByParent !== null) {
        $out['members'] = array_map(
            fn($m) => nodeToJs($m),
            $childrenByParent[$n['id']] ?? []
        );
    }
    return $out;
}

$orgData = [
    'leaders' => array_map(fn($n) => nodeToJs($n), $leaders),
    'branches' => array_map(fn($n) => nodeToJs($n, $childrenByParent), $branches),
    'divisions' => array_map(fn($n) => nodeToJs($n, $childrenByParent), $divisions),
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - HMSE</title>
    <link rel="icon" type="image/png" href="../images/logo2.png">
    <link rel="apple-touch-icon" href="../images/logo2.png">
    <link rel="stylesheet" href="../css/style.css?v=<?= assetVersion('css/style.css') ?>">
    <link rel="stylesheet" href="../css/struktur.css?v=<?= assetVersion('css/struktur.css') ?>">
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
                <li class="nav-li drop current">
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
                <li class="nav-li"><a href="news.php">News</a></li>
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
    <section class="st-banner">
        <div class="st-banner-glow"></div>
        <div class="st-banner-content reveal reveal-up">
            <span class="section-eyebrow section-eyebrow-light">Kepengurusan</span>
            <h1>Struktur Organisasi</h1>
            <p>Kenali orang-orang di balik HMSE. Arahkan kursor (atau ketuk di HP) ke tiap nama untuk lihat detailnya.</p>
        </div>
    </section>

    <section class="st-section">

        <!-- ===== DESKTOP: pohon struktur, seluruhnya dibangun oleh struktur.js ===== -->
        <div class="org-desktop" id="orgDesktop"></div>

        <!-- ===== MOBILE: accordion per kelompok, isinya foto-foto bisa diklik ===== -->
        <div class="org-mobile">
            <div class="org-m-groups" id="orgMobileGroups"></div>
        </div>

    </section>

    <!-- ================= POPOVER (hover, desktop) — foto besar kiri, detail kanan ================= -->
    <div class="org-popover" id="orgPopover">
        <div class="org-popover-avatar" id="orgPopoverAvatar"></div>
        <div class="org-popover-details">
            <h4 id="orgPopoverName"></h4>
            <span class="org-role-label" id="orgPopoverRole"></span>
            <div class="org-popover-meta" id="orgPopoverMeta"></div>
            <div class="org-popover-links" id="orgPopoverLinks"></div>
        </div>
    </div>

    <!-- ================= MODAL (tap, mobile) ================= -->
    <div class="org-modal" id="orgModal">
        <div class="org-modal-backdrop" id="orgModalBackdrop"></div>
        <div class="org-modal-box" role="dialog" aria-modal="true" aria-label="Detail pengurus">
            <button class="org-modal-close" id="orgModalClose" aria-label="Tutup">&times;</button>
            <div class="org-modal-row">
                <div class="org-popover-avatar" id="orgModalAvatar"></div>
                <div class="org-popover-details">
                    <h4 id="orgModalName"></h4>
                    <span class="org-role-label" id="orgModalRole"></span>
                    <div class="org-popover-meta" id="orgModalMeta"></div>
                    <div class="org-popover-links" id="orgModalLinks"></div>
                </div>
            </div>
        </div>
    </div>

    <footer class="hmse-footer">
      <div class="footer-main">

        <!-- Brand -->
        <div class="footer-brand">
          <h3>HMSE</h3>
          <p>
            Berani Coba, Berani Gagal,<br>
            Berani Sukses
          </p>

          <div class="footer-social">
            <a href="#" aria-label="Facebook HMSE"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="#" aria-label="Instagram HMSE"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" aria-label="YouTube HMSE"><i class="fa-brands fa-youtube"></i></a>
          </div>
        </div>

        <!-- Contact -->
        <div class="footer-contact">
          <h4>Contact Us</h4>

          <p>
            <i class="material-icons">call</i>
            +62 0812 xxxx xxxx
          </p>

          <p>
            <i class="material-icons">email</i>
            asu27@gmail.com
          </p>
        </div>

        <!-- Maps -->
        <div class="footer-maps">
          <h4>Lokasi Kami</h4>
          <div class="footer-maps-frame">
            <iframe
              loading="lazy"
              src="https://maps.google.com/maps?q=-6.2243268,106.5683631&z=17&output=embed">
            </iframe>
          </div>
          <a class="footer-maps-link" href="https://www.google.com/maps/place/SEKRET+HMSE+UNIPI/@-6.2243884,106.5671774,18.06z/data=!4m6!3m5!1s0x2e69ff0067f77447:0xd2739de9d0900f90!8m2!3d-6.2243268!4d106.5683631!16s%2Fg%2F11w9bsdjsm?hl=id-ID" target="_blank" rel="noopener">
            Buka di Google Maps
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
          </a>
        </div>

      </div>

      <!-- Bottom -->
      <div class="footer-bottom">

        <p>© 2026 HMSE. All Rights Reserved.</p>

        <div class="footer-links">
          <a href="#">Terms & Condition</a>
          <a href="../admin/login.php">admin</a>
          <a href="#">Privacy Policy</a>
        </div>

      </div>
    </footer>

    <script>
        const orgData = <?= json_encode($orgData, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="../js/index.js?v=<?= assetVersion('js/index.js') ?>"></script>
    <script src="../js/struktur.js?v=<?= assetVersion('js/struktur.js') ?>"></script>

</body>
</html>