<?php
require __DIR__ . '/../config.php';
$pdo = getDbConnection();

$bulanIndo = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$bulanSingkat = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

$today = date('Y-m-d');
$stmt = $pdo->prepare('SELECT * FROM events WHERE event_date >= ? ORDER BY event_date ASC LIMIT 5');
$stmt->execute([$today]);
$rows = $stmt->fetchAll();

$scheduleEvents = array_map(function ($ev) use ($bulanIndo, $bulanSingkat) {
    [$y, $m, $d] = explode('-', $ev['event_date']);
    $d = (int)$d;
    $m = (int)$m;
    $y = (int)$y;
    return [
        'name' => $ev['title'],
        'dateShort' => $d . ' ' . $bulanSingkat[$m],
        'dateFull' => $d . ' ' . $bulanIndo[$m] . ' ' . $y,
        'place' => $ev['place'] ?? '',
        'time' => $ev['event_time'] ?? '',
        'photo' => $ev['photo'] ? '../images/' . $ev['photo'] : null,
    ];
}, $rows);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Schedule - HMSE</title>
    <link rel="icon" type="image/webp" href="../images/logo2.webp">
    <link rel="apple-touch-icon" href="../images/logo2.webp">
    <link rel="stylesheet" href="../css/style.css?v=<?= assetVersion('css/style.css') ?>">
    <link rel="stylesheet" href="../css/event-schedule.css?v=<?= assetVersion('css/event-schedule.css') ?>">
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
    <section class="es-banner">
        <div class="es-banner-glow"></div>
        <div class="es-banner-content reveal reveal-up">
            <span class="section-eyebrow section-eyebrow-light">Jadwal</span>
            <h1>Event Schedule</h1>
            <p>Rangkaian acara HMSE, dari yang paling dekat sampai yang masih beberapa waktu lagi.</p>
        </div>
    </section>

    <!-- ================= EVENT SCHEDULE ================= -->
    <section class="es-section">

        <?php if (empty($scheduleEvents)): ?>
            <p style="text-align:center; color:rgba(23,21,51,0.5); font-size:14px;">Belum ada event mendatang.</p>
        <?php else: ?>

            <!-- ===== DESKTOP: garis waktu horizontal + daftar detail ===== -->
            <div class="es-desktop-wrap">

                <div class="eventline-track" id="eventlineTrack">
                    <span class="eventline-line"></span>
                    <div class="eventline-nodes" id="eventlineNodes"></div>
                </div>

                <div class="eventlist" id="eventlist"></div>

            </div>

            <!-- ===== MOBILE: garis waktu vertikal + kartu bisa diklik ===== -->
            <div class="es-mobile-wrap" id="esMobileWrap"></div>

        <?php endif; ?>

    </section>

    <!-- ================= MODAL DETAIL EVENT (mobile) ================= -->
    <div class="event-modal" id="eventModal">
        <div class="event-modal-backdrop" id="eventModalBackdrop"></div>
        <div class="event-modal-box" role="dialog" aria-modal="true" aria-label="Detail acara">
            <button class="event-modal-close" id="eventModalClose" aria-label="Tutup">&times;</button>
            <div class="event-modal-photo" id="eventModalPhoto"></div>
            <span class="section-eyebrow" id="eventModalDate"></span>
            <h3 id="eventModalName"></h3>
            <p id="eventModalMeta"></p>
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
        const scheduleEvents = <?= json_encode($scheduleEvents, JSON_UNESCAPED_UNICODE) ?>;
    </script>
    <script src="../js/index.js?v=<?= assetVersion('js/index.js') ?>"></script>
    <script src="../js/event-schedule.js?v=<?= assetVersion('js/event-schedule.js') ?>"></script>

</body>

</html>