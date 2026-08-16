// =========================================================
// Variabel `newsArticles` disiapkan oleh news.php / news_detail.php
// (dari database) lewat <script> inline sebelum file ini di-load.
// File ini cuma berisi helper yang dipakai bareng news.js & news_detail.js.
// =========================================================

function getSortedArticles(){
  return [...newsArticles].sort((a, b) => new Date(b.dateISO) - new Date(a.dateISO));
}
