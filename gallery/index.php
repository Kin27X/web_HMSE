<?php
require __DIR__ . '/../config.php';
$pdo = getDbConnection();

$rows = $pdo->query('SELECT * FROM gallery_photos ORDER BY sort_order ASC, id DESC')->fetchAll();
$galleryPhotos = array_map(fn($r) => [
    'photo' => '../images/' . $r['photo'],
    'category' => $r['category'],
], $rows);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - HMSE</title>
    <link rel="icon" type="image/webp" href="../images/logo2.webp">
    <link rel="apple-touch-icon" href="../images/logo2.webp">
    <link rel="stylesheet" href="../css/style.css?v=<?= assetVersion('css/style.css') ?>">
    <link rel="stylesheet" href="../css/gallery.css?v=<?= assetVersion('css/gallery.css') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
        integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
    </style>
</head>

<body>

    <header id="navbar">
        <nav class="navbar">

            <div class="nav-bg-gray"></div>

            <div class="brand">
                <img class="logo" src="../images/logo2.webp" alt="logo HMSE">
                <span>HMSE</span>
            </div>

            <ul class="menu" id="menu">
                <li class="menu-header">
                    <div class="brand">
                        <img class="logo" src="../images/logo2.webp" alt="logo HMSE">
                        <span>HMSE</span>
                    </div>
                    <span class="menu-close" id="menuClose" aria-label="Tutup menu">&times;</span>
                </li>
                <li class="nav-li"><a href="../">Home</a></li>
                <li class="nav-li drop">
                    <div class="drop-btn">
                        About
                        <span class="material-icons dropdown-icon">
                            arrow_drop_down
                        </span>
                    </div>

                    <div class="dropdown">
                        <ul class="dropdown-inner">
                            <li><a href="../visi_misi/">Visi & Misi</a></li>
                            <li><a href="../proker/">Program Kerja</a></li>
                            <li><a href="../event_sch/">Event Schedule</a></li>
                            <li><a href="../org_struct/">Struktur Organisasi</a></li>
                        </ul>
                    </div>

                </li>
                <li class="nav-li"><a href="../gallery/">Gallery</a></li>
                <li class="nav-li"><a href="../news/">News</a></li>
                <li class="nav-li mobile-btn">
                    <!-- <a class="btn" href="#"><button>Contact</button></a> -->
                </li>
            </ul>

            <div class="nav-accent">
                <span class="accent-circle"></span>
                <div class="button">
                    <!-- <a class="btn" href="#"><button>Contact</button></a> -->
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
    <section class="gl-banner">
        <div class="gl-banner-glow"></div>
        <div class="gl-banner-content reveal reveal-up">
            <span class="section-eyebrow section-eyebrow-light">Dokumentasi</span>
            <h1>Gallery</h1>
            <p>Cuplikan momen dari kegiatan-kegiatan HMSE.</p>
        </div>
    </section>

    <!-- ================= GALLERY ================= -->
    <section class="gl-section">

        <div class="gl-filter reveal reveal-up" id="glFilter">
            <button class="gl-filter-btn active" data-filter="semua">Semua</button>
            <button class="gl-filter-btn" data-filter="olahraga">Olahraga</button>
            <button class="gl-filter-btn" data-filter="belajar">Belajar</button>
            <button class="gl-filter-btn" data-filter="event">Event</button>
        </div>

        <?php if (empty($galleryPhotos)): ?>
            <p style="text-align:center; color:rgba(23,21,51,0.5); font-size:14px;">Belum ada foto di gallery.</p>
        <?php else: ?>
            <div class="gl-grid" id="glGrid"></div>
        <?php endif; ?>

    </section>

    <!-- ================= LIGHTBOX ================= -->
    <div class="gl-lightbox" id="glLightbox">
        <div class="gl-lightbox-backdrop" id="glLightboxBackdrop"></div>
        <button class="gl-lightbox-close" id="glLightboxClose" aria-label="Tutup">&times;</button>
        <button class="gl-lightbox-nav gl-lightbox-prev" id="glLightboxPrev" aria-label="Sebelumnya">
            <i class="material-icons">chevron_left</i>
        </button>
        <div class="gl-lightbox-body">
            <img id="glLightboxImg" src="" alt="">
            <div class="gl-lightbox-caption">
                <span id="glLightboxAlbum"></span>
                <span id="glLightboxCount"></span>
            </div>
        </div>
        <button class="gl-lightbox-nav gl-lightbox-next" id="glLightboxNext" aria-label="Berikutnya">
            <i class="material-icons">chevron_right</i>
        </button>
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
                    <a href="https://www.tiktok.com/@hmse_unipi" aria-label="Tiktok HMSE"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/hmse_unipi?igsh=MTBvaW43MmluN2J1aw==" aria-label="Instagram HMSE"><i
                            class="fa-brands fa-instagram"></i></a>
                    <!-- <a href="#" aria-label="YouTube HMSE"><i class="fa-brands fa-youtube"></i></a> -->
                </div>
            </div>

            <!-- Contact -->
            <div class="footer-contact">
                <h4>Contact Us</h4>

                <!-- <p>
              <i class="material-icons">call</i>
              +62 0812 xxxx xxxx
            </p> -->

                <p>
                    <i class="material-icons">email</i>
                    softwareengineering228@gmail.com
                </p>
            </div>

            <!-- Maps -->
            <div class="footer-maps">
                <h4>Lokasi Kami</h4>
                <div class="footer-maps-frame">
                    <iframe loading="lazy" src="https://maps.google.com/maps?q=-6.2243268,106.5683631&z=17&output=embed">
                    </iframe>
                </div>
                <a class="footer-maps-link"
                    href="https://www.google.com/maps/place/SEKRET+HMSE+UNIPI/@-6.2243884,106.5671774,18.06z/data=!4m6!3m5!1s0x2e69ff0067f77447:0xd2739de9d0900f90!8m2!3d-6.2243268!4d106.5683631!16s%2Fg%2F11w9bsdjsm?hl=id-ID"
                    target="_blank" rel="noopener">
                    Buka di Google Maps
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>

        </div>

        <!-- Bottom -->
        <div class="footer-bottom">

            <p>© 2026 HMSE. All Rights Reserved.</p>

            <div class="footer-links">
                <!-- <a href="#">Terms & Condition</a> -->
                <a href="../admin/login.php" target="_blank">Admin</a>
                <!-- <a href="#">Privacy Policy</a> -->
            </div>

        </div>
    </footer>


    <script>
        const galleryPhotos = <?= json_encode($galleryPhotos, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="../js/index.js?v=<?= assetVersion('js/index.js') ?>"></script>
    <script src="../js/gallery.js?v=<?= assetVersion('js/gallery.js') ?>"></script>

</body>

</html>