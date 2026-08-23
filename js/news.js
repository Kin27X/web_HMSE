// =========================================================
// NEWS PAGE (daftar) — logic tampilan
// Data diambil dari news-data.js (newsArticles / getSortedArticles).
//
// Aturan jumlah item per halaman (sesuai spesifikasi):
// - Mode LIST : 8 berita per halaman (desktop maupun mobile)
// - Mode GRID : 20 per halaman di desktop (4 kolom x 5 baris),
//               10 per halaman di mobile (2 kolom x 5 baris)
// =========================================================

const nwViewToggle = document.getElementById("nwViewToggle");
const nwList = document.getElementById("nwList");
const nwGrid = document.getElementById("nwGrid");
const nwEmpty = document.getElementById("nwEmpty");
const nwSearchInput = document.getElementById("nwSearchInput");
const nwPrevBtn = document.getElementById("nwPrevBtn");
const nwNextBtn = document.getElementById("nwNextBtn");
const nwPageLabel = document.getElementById("nwPageLabel");

const MOBILE_BREAKPOINT = 700;

let currentMode = "list"; // "list" | "grid"
let currentPage = 1;
let searchTerm = "";

function isMobile(){
  return window.innerWidth <= MOBILE_BREAKPOINT;
}

function itemsPerPage(){
  if(currentMode === "list") return 8;
  return isMobile() ? 10 : 20; // grid: 2x5 mobile, 4x5 desktop
}

function getFilteredArticles(){
  const all = getSortedArticles();
  if(!searchTerm) return all;
  const q = searchTerm.toLowerCase();
  return all.filter(a => a.title.toLowerCase().includes(q) || a.excerpt.toLowerCase().includes(q));
}

function renderListItem(article){
  const el = document.createElement("div");
  el.className = "nw-list-item";
  el.innerHTML = `
    <div class="nw-list-thumb">
      <img src="${article.thumbnail}" alt="${article.title}" loading="lazy">
    </div>
    <div class="nw-list-body">
      <span class="nw-list-title">${article.title}</span>
      <span class="nw-list-date">${article.dateDisplay}</span>
      <p class="nw-list-excerpt">${article.excerpt}</p>
      <button class="nw-share-btn" type="button">Share...</button>
    </div>
  `;
  el.addEventListener("click", (e)=>{
    if(e.target.closest(".nw-share-btn")) return; // tombol share tidak ikut buka detail
    goToDetail(article.id);
  });
  el.querySelector(".nw-share-btn").addEventListener("click", (e)=>{
    e.stopPropagation();
    shareArticle(article);
  });
  return el;
}

function renderGridItem(article){
  const el = document.createElement("div");
  el.className = "nw-grid-item";
  el.innerHTML = `
    <div class="nw-grid-thumb">
      <img src="${article.thumbnail}" alt="${article.title}" loading="lazy">
    </div>
    <div class="nw-grid-info">
      <div class="nw-grid-title">${article.title}</div>
      <div class="nw-grid-date">${article.dateDisplay.split(" &middot; ")[0]}</div>
    </div>
  `;
  el.addEventListener("click", ()=> goToDetail(article.id));
  return el;
}

function shareArticle(article){
  const url = `${window.location.origin}${window.location.pathname.replace("news.php","")}news.php?id=${article.id}`;
  if(navigator.share){
    navigator.share({ title: article.title, url }).catch(()=>{});
  }else if(navigator.clipboard){
    navigator.clipboard.writeText(url);
  }
}

function goToDetail(id){
  window.location.href = `news.php?id=${id}`;
}

function renderPage(){

  const filtered = getFilteredArticles();
  const perPage = itemsPerPage();
  const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));

  currentPage = Math.min(currentPage, totalPages);
  const start = (currentPage - 1) * perPage;
  const pageItems = filtered.slice(start, start + perPage);

  nwList.innerHTML = "";
  nwGrid.innerHTML = "";

  if(filtered.length === 0){
    nwEmpty.hidden = false;
  }else{
    nwEmpty.hidden = true;
    pageItems.forEach(article=>{
      if(currentMode === "list"){
        nwList.appendChild(renderListItem(article));
      }else{
        nwGrid.appendChild(renderGridItem(article));
      }
    });
  }

  nwList.hidden = currentMode !== "list";
  nwGrid.hidden = currentMode !== "grid";

  nwPageLabel.textContent = `Halaman ${currentPage} / ${totalPages}`;
  nwPrevBtn.disabled = currentPage <= 1;
  nwNextBtn.disabled = currentPage >= totalPages;
}

// ================= TOGGLE MODE =================
nwViewToggle.querySelectorAll("button").forEach(btn=>{
  btn.addEventListener("click", ()=>{
    nwViewToggle.querySelectorAll("button").forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
    currentMode = btn.dataset.mode;
    currentPage = 1;
    renderPage();
  });
});

// ================= SEARCH =================
let searchDebounce;
nwSearchInput.addEventListener("input", ()=>{
  clearTimeout(searchDebounce);
  searchDebounce = setTimeout(()=>{
    searchTerm = nwSearchInput.value.trim();
    currentPage = 1;
    renderPage();
  }, 200);
});

// ================= PAGINATION =================
nwPrevBtn.addEventListener("click", ()=>{
  if(currentPage > 1){ currentPage--; renderPage(); }
});
nwNextBtn.addEventListener("click", ()=>{
  currentPage++; renderPage();
});

// Kalau lebar layar berubah (mis. resize/rotate), jumlah kolom grid
// mobile/desktop beda -- render ulang biar jumlah per halaman tetap benar
let resizeDebounce;
window.addEventListener("resize", ()=>{
  clearTimeout(resizeDebounce);
  resizeDebounce = setTimeout(()=>{
    currentPage = 1;
    renderPage();
  }, 200);
});

// ================= INIT =================
renderPage();
