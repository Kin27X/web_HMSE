<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HMSE - Himpunan Mahasiswa Software Engineering</title>
  <link rel="icon" type="image/webp" href="images/logo2.webp">
  <link rel="apple-touch-icon" href="images/logo2.webp">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/devicons/1.8.0/css/devicons.min.css" integrity="sha512-JW3fT0YTK7pT7w437SoX6GcW76jOZ6E0jGmrqBAcloC4GKT+njHOY4fX5KxJ9WfIXTkNrAF994525fAHp+KCxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
  </style>
</head>

<body>

  <header id="navbar">
    <nav class="navbar">

      <div class="nav-bg-gray"></div>

      <div class="brand">
        <img class="logo" src="images/logo2.webp" alt="logo HMSE">
        <span>HMSE</span>
      </div>

      <ul class="menu" id="menu">
        <li class="menu-header">
          <div class="brand">
            <img class="logo" src="images/logo2.webp" alt="logo HMSE">
            <span>HMSE</span>
          </div>
          <span class="menu-close" id="menuClose" aria-label="Tutup menu">&times;</span>
        </li>
        <li class="nav-li current"><a href="#">Home</a></li>
        <li class="nav-li drop">
          <div class="drop-btn">
            About
            <span class="material-icons dropdown-icon">
              arrow_drop_down
            </span>
          </div>

          <div class="dropdown">
            <ul class="dropdown-inner">
              <li><a href="visi_misi/">Visi & Misi</a></li>
              <li><a href="proker/">Program Kerja</a></li>
              <li><a href="event_sch/">Event Schedule</a></li>
              <li><a href="org_struct/">Struktur Organisasi</a></li>
            </ul>
          </div>

        </li>
        <li class="nav-li"><a href="gallery/">Gallery</a></li>
        <li class="nav-li"><a href="news/">News</a></li>
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

  <!-- Hero Section -->
  <section class="hero">
    <img src="images/hero.webp" alt="HMSE">

    <div class="hero-text">
      <h1>Kreasikan Idemu<br>dengan HMSE</h1><br>
      <h3 style="font-weight: normal;">
        HIMPUNAN MAHASISWA SOFTWARE ENGINEERING</h3>
      <h4 style="font-weight: normal;">
        UNIVERSITAS INSAN PEMBANGUNAN INDONESIA</h4>
      <p>Berani Coba, Berani Gagal, Berani Sukses</p>
    </div>
  </section>

  <!-- Sesi Chip Sirkuit Interaktif -->
  <section class="circuit-section">
    <div class="circuit-wrap">

      <div class="circuit-text reveal reveal-up">
        <h2>Setiap Ide Mengalir Seperti Data</h2>
        <p>
          Seperti sirkuit dalam sebuah chip, setiap proses di HMSE saling
          terhubung — dari belajar, berkarya, hingga berkolaborasi.
          Semuanya mengalir jadi satu inovasi.
        </p>
      </div>

      <div class="circuit-illustration reveal reveal-up"
        id="circuitWrap"
        tabindex="0"
        role="button"
        aria-label="Klik untuk menyalakan animasi sirkuit chip">

        <svg id="circuitSvg" viewBox="0 0 600 400" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Ilustrasi chip sirkuit HMSE">

          <defs>
            <linearGradient id="chipBody" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#1c1a4d" />
              <stop offset="55%" stop-color="#0d0c33" />
              <stop offset="100%" stop-color="#05040f" />
            </linearGradient>
            <linearGradient id="chipDie" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#141233" />
              <stop offset="100%" stop-color="#0a0925" />
            </linearGradient>
          </defs>

          <!-- Jalur sirkuit (statis, redup) -->
          <g class="circuit-trace-group">
            <path class="circuit-trace" d="M275,150 V100 H100 V80" />
            <path class="circuit-trace" d="M325,150 V100 H500 V80" />
            <path class="circuit-trace" d="M250,175 H60" />
            <path class="circuit-trace" d="M350,175 H540" />
            <path class="circuit-trace" d="M275,250 V300 H100 V320" />
            <path class="circuit-trace" d="M325,250 V300 H500 V320" />
          </g>

          <!-- Jalur sirkuit (menyala saat diklik) -->
          <g class="circuit-glow-group">
            <path class="circuit-glow" d="M275,150 V100 H100 V80" />
            <path class="circuit-glow" d="M325,150 V100 H500 V80" />
            <path class="circuit-glow" d="M250,175 H60" />
            <path class="circuit-glow" d="M350,175 H540" />
            <path class="circuit-glow" d="M275,250 V300 H100 V320" />
            <path class="circuit-glow" d="M325,250 V300 H500 V320" />
          </g>

          <!-- Pad ujung sirkuit -->
          <g class="circuit-pads">
            <circle class="circuit-pad" cx="100" cy="80" r="9" />
            <text class="circuit-label" x="100" y="58">HTML</text>

            <circle class="circuit-pad" cx="500" cy="80" r="9" />
            <text class="circuit-label" x="500" y="58">CSS</text>

            <circle class="circuit-pad" cx="60" cy="175" r="9" />
            <text class="circuit-label" x="60" y="153">JS</text>

            <circle class="circuit-pad" cx="540" cy="175" r="9" />
            <text class="circuit-label" x="540" y="153">PHP</text>

            <circle class="circuit-pad" cx="100" cy="320" r="9" />
            <text class="circuit-label" x="100" y="347">SQL</text>

            <circle class="circuit-pad" cx="500" cy="320" r="9" />
            <text class="circuit-label" x="500" y="347">API</text>
          </g>

          <!-- Chip utama -->
          <g class="circuit-chip" id="circuitChip">

            <!-- Bodi chip (gradasi keramik/metalik) -->
            <rect class="chip-body" x="250" y="150" width="100" height="100" rx="14" />

            <!-- Die dalam + pola sirkuit dekoratif -->
            <rect class="chip-die" x="264" y="164" width="72" height="72" rx="6" />
            <path class="chip-die-line" d="M264,185 H286 V164" />
            <path class="chip-die-line" d="M336,200 H314 V236" />
            <path class="chip-die-line" d="M280,236 V214 H264" />
            <path class="chip-die-line" d="M320,164 V180 H336" />

            <!-- Penanda pin-1 (khas chip asli) -->
            <circle class="chip-pin1" cx="262" cy="162" r="3.5" />

            <!-- Pin/kaki chip (lebih rapat, mirip IC asli) -->
            <rect class="chip-pin" x="264" y="144" width="8" height="8" />
            <rect class="chip-pin" x="292" y="144" width="8" height="8" />
            <rect class="chip-pin" x="320" y="144" width="8" height="8" />

            <rect class="chip-pin" x="264" y="248" width="8" height="8" />
            <rect class="chip-pin" x="292" y="248" width="8" height="8" />
            <rect class="chip-pin" x="320" y="248" width="8" height="8" />

            <rect class="chip-pin" x="244" y="164" width="8" height="8" />
            <rect class="chip-pin" x="244" y="192" width="8" height="8" />
            <rect class="chip-pin" x="244" y="220" width="8" height="8" />

            <rect class="chip-pin" x="348" y="164" width="8" height="8" />
            <rect class="chip-pin" x="348" y="192" width="8" height="8" />
            <rect class="chip-pin" x="348" y="220" width="8" height="8" />

            <text x="300" y="206" class="circuit-chip-label">HMSE</text>
          </g>

          <!-- Titik cahaya (komet) yang benar-benar bergerak ke tiap node -->
          <g class="circuit-sparks">
            <circle class="circuit-spark">
              <animateMotion dur="0.7s" begin="indefinite" fill="freeze" rotate="auto" path="M275,150 V100 H100 V80" />
            </circle>
            <circle class="circuit-spark">
              <animateMotion dur="0.7s" begin="indefinite" fill="freeze" rotate="auto" path="M325,150 V100 H500 V80" />
            </circle>
            <circle class="circuit-spark">
              <animateMotion dur="0.55s" begin="indefinite" fill="freeze" rotate="auto" path="M250,175 H60" />
            </circle>
            <circle class="circuit-spark">
              <animateMotion dur="0.55s" begin="indefinite" fill="freeze" rotate="auto" path="M350,175 H540" />
            </circle>
            <circle class="circuit-spark">
              <animateMotion dur="0.7s" begin="indefinite" fill="freeze" rotate="auto" path="M275,250 V300 H100 V320" />
            </circle>
            <circle class="circuit-spark">
              <animateMotion dur="0.7s" begin="indefinite" fill="freeze" rotate="auto" path="M325,250 V300 H500 V320" />
            </circle>
          </g>

        </svg>

        <p class="circuit-hint">⚡ Klik chip untuk menyalakan sirkuitnya</p>
      </div>

    </div>
  </section>

  <section class="content">
    <h2>Kegiatan HMSE</h2>

    <div class="cards">
      <!-- Card 1 -->
      <div class="hero-card">

        <img src="images/home.webp" alt="Belajar" loading="lazy">

        <div class="hero-overlay"></div>

        <div class="hero-content">
          <h3>Belajar</h3>
          <p>Belajar pemrograman bersama HMSE</p>

          <a href="learn/">
            <button class="hero-btn">
              <span class="hero-btn-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="4" y1="12" x2="19" y2="12" />
                  <polyline points="13 6 19 12 13 18" />
                </svg>
              </span>
              <span class="hero-btn-text">Jelajahi</span>
            </button>
          </a>
        </div>

      </div>

      <!-- Card 2 -->
      <div class="hero-card">

        <img src="images/placeholder.webp" alt="Event" loading="lazy">

        <div class="hero-overlay"></div>

        <div class="hero-content">
          <h3>Event</h3>
          <p>Hadiri acara dan kegiatan HMSE</p>

          <a href="event/">
            <button class="hero-btn">
              <span class="hero-btn-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="4" y1="12" x2="19" y2="12" />
                  <polyline points="13 6 19 12 13 18" />
                </svg>
              </span>
              <span class="hero-btn-text">Jelajahi</span>
            </button>
          </a>
        </div>

      </div>

      <div class="hero-card">

        <img src="images/placeholder.webp" alt="Olahraga" loading="lazy">

        <div class="hero-overlay"></div>

        <div class="hero-content">
          <h3>Olahraga</h3>
          <p>Ikuti kegiatan olahraga bersama HMSE</p>

          <a href="sport/">
            <button class="hero-btn">
              <span class="hero-btn-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="4" y1="12" x2="19" y2="12" />
                  <polyline points="13 6 19 12 13 18" />
                </svg>
              </span>
              <span class="hero-btn-text">Jelajahi</span>
            </button>
          </a>
        </div>
      </div>

    </div>

    <div class="cards-dots" id="cardsDots">
      <span class="dot"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>
  </section>

  <section class="history">
    <div class="history-box reveal">

      <div class="history-text">
        <h2>Sejarah Singkat</h2>

        <p>
          HMSE disahkan dan dilantik sebagai Himpunan Mahasiswa
          Software Engineering pertama di Universitas Insan Pembangunan Indonesia
          pada tanggal 07 Januari 2024 di Auditorium Saba Karya.
        </p>

        <p>
          Himpunan Mahasiswa Software Engineering (HMSE) adalah suatu organisasi
          di tingkat mahasiswa yang terfokus pada bidang keilmuan teknologi
          informasi dan rekayasa perangkat lunak.
        </p>
      </div>

      <div class="history-img">
        <img src="images/foto.webp" alt="HMSE">
      </div>

    </div>
  </section>

  <!-- <section class="cta">
    <div class="cta-overlay"></div>

    <div class="cta-content reveal reveal-up">

      <h2>Bergabung dengan HMSE UNIPI</h2>
      <p>Cari tau dan ikuti keseruannya bersama HMSE</p>

      <a href="daftar.html" class="cta-btn">
        Daftar
        <span class="material-icons">arrow_forward</span>
      </a>

    </div>
  </section> -->

  <section class="filosofi">
    <h2>Filosofi Logo HMSE</h2>

    <div class="hex-container" id="hexBox">

      <svg class="hex-connectors" viewBox="0 0 600 500" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <line x1="200" y1="250" x2="186" y2="250" />
        <line x1="250" y1="169" x2="243" y2="158" />
        <line x1="350" y1="169" x2="357" y2="158" />
        <line x1="250" y1="331" x2="243" y2="342" />
        <line x1="350" y1="331" x2="357" y2="342" />
        <line x1="400" y1="250" x2="414" y2="250" />
      </svg>

      <div class="hex-hub">
        <span class="hex-hub-shape"></span>
        <img src="images/logo2.webp" alt="Logo HMSE" class="hex-hub-logo">
      </div>

      <div class="hex-item">
        <span class="hex-icon-bg"><img src="images/gear.webp" alt="Gear" loading="lazy"></span>
        <h4>Gear</h4>
        <p>Semangat kerja & keberlanjutan.</p>
      </div>

      <div class="hex-item">
        <span class="hex-icon-bg"><img src="images/lamp.webp" alt="Lampu" loading="lazy"></span>
        <h4>Lampu</h4>
        <p>Sumber efisiensi & inovasi.</p>
      </div>

      <div class="hex-item">
        <span class="hex-icon-bg"><img src="images/code.webp" alt="Kode" loading="lazy"></span>
        <h4>Kode</h4>
        <p>Progres berkelanjutan.</p>
      </div>

      <div class="hex-item">
        <span class="hex-icon-bg"><img src="images/book.webp" alt="Buku" loading="lazy"></span>
        <h4>Buku</h4>
        <p>Sumber ilmu.</p>
      </div>

      <div class="hex-item">
        <span class="hex-icon-bg"><img src="images/computer_1.webp" alt="Komputer" loading="lazy"></span>
        <h4>Komputer</h4>
        <p>Media pembelajaran.</p>
      </div>

      <div class="hex-item">
        <span class="hex-icon-bg"><img src="images/grey.webp" alt="Abu-abu" loading="lazy"></span>
        <h4>Abu-abu</h4>
        <p>Kestabilan & tanggung jawab.</p>
      </div>

    </div>
  </section>

  <section class="hmse-tech-section">
    <div class="hmse-tech-card reveal reveal-up">
      <!-- LEFT : TEXT -->
      <div class="hmse-tech-left">

        <div class="hmse-window">
          <span class="dot red"></span>
          <span class="dot yellow"></span>
          <span class="dot green"></span>
        </div>

        <h2>Bersama HMSE</h2>

        <p>
          Kita belajar dunia teknologi, pemrograman,
          dan inovasi digital untuk masa depan
          yang lebih baik.
        </p>

        <div class="hmse-code">
          &lt;html&gt;<br>
          &nbsp;&nbsp;&lt;learn&gt;Coding&lt;/learn&gt;<br>
          &nbsp;&nbsp;&lt;grow&gt;Together&lt;/grow&gt;<br>
          &lt;/html&gt;
        </div>

      </div>

      <!-- RIGHT : CUBE -->
      <div class="hmse-tech-right">
        <div class="hmse-grid"></div>
        <div class="hmse-cube-wrap">
          <div class="hmse-box-card" id="hmseCube">

            <div class="hmse-face front">
              <i class="devicon-html5-plain"></i>
              <span>HTML5</span>
            </div>
            <div class="hmse-face back">
              <i class="devicon-css3-plain"></i>
              <span>CSS3</span>
            </div>
            <div class="hmse-face right">
              <i class="devicon-javascript-plain"></i>
              <span>JavaScript</span>
            </div>
            <div class="hmse-face left">
              <i class="devicon-php-plain"></i>
              <span>PHP</span>
            </div>
            <div class="hmse-face top">
              <i class="fa-solid fa-database"></i>
              <span>SQL</span>
            </div>
            <div class="hmse-face bottom">
              <i class="fa-solid fa-plug"></i>
              <span>API</span>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

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
          <a href="https://www.instagram.com/hmse_unipi?igsh=MTBvaW43MmluN2J1aw==" aria-label="Instagram HMSE"><i class="fa-brands fa-instagram"></i></a>
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
        <!-- <a href="#">Terms & Condition</a> -->
        <!-- <a href="admin/login.php" target="_blank">Admin</a> -->
        <!-- <a href="#">Privacy Policy</a> -->
      </div>

    </div>
  </footer>

  <script src="js/index.js"></script>

</body>

</html>