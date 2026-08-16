// =========================================================
// NEWS DETAIL PAGE — logic tampilan
// Berita yang dibuka ditentukan dari parameter URL ?id=...
// Data diambil dari news-data.js (newsArticles / getSortedArticles).
// =========================================================

const ndArticle = document.getElementById("ndArticle");
const ndMoreList = document.getElementById("ndMoreList");

function getArticleIdFromUrl(){
  const params = new URLSearchParams(window.location.search);
  return params.get("id");
}

function shareCurrentArticle(){
  const url = window.location.href;
  if(navigator.share){
    navigator.share({ title: document.title, url }).catch(()=>{});
  }else if(navigator.clipboard){
    navigator.clipboard.writeText(url);
  }
}

function renderArticle(article){

  document.title = `${article.title} - HMSE`;

  const authorHtml = article.author
    ? `<div class="nd-meta">Author: <strong>${article.author}</strong></div>`
    : "";

  const photos = article.photos && article.photos.length ? article.photos : [article.thumbnail];

  const stripHtml = photos.length > 1 ? `
    <div class="nd-photo-strip">
      ${photos.map((src, i) => `<button class="nd-photo-thumb${i === 0 ? ' active' : ''}" data-src="${src}"><img src="${src}" alt="Foto ${i + 1}" loading="lazy"></button>`).join("")}
    </div>
  ` : "";

  ndArticle.innerHTML = `
    <h1>${article.title}</h1>
    <div class="nd-meta">Date created: ${article.dateDisplay}</div>
    ${authorHtml}
    <button class="nd-share" type="button" id="ndShareBtn">Share...</button>
    <div class="nd-photo">
      <img src="${photos[0]}" alt="${article.title}" id="ndHeroPhoto">
    </div>
    ${stripHtml}
    <div class="nd-body">${article.bodyHtml}</div>
  `;

  document.getElementById("ndShareBtn").addEventListener("click", shareCurrentArticle);

  if(photos.length > 1){
    const hero = document.getElementById("ndHeroPhoto");
    document.querySelectorAll(".nd-photo-thumb").forEach(btn=>{
      btn.addEventListener("click", ()=>{
        hero.src = btn.dataset.src;
        document.querySelectorAll(".nd-photo-thumb").forEach(b => b.classList.remove("active"));
        btn.classList.add("active");
      });
    });
  }
}

function renderMorePosts(currentId){

  const others = getSortedArticles().filter(a => a.id !== currentId).slice(0, 6);

  ndMoreList.innerHTML = "";

  others.forEach(article=>{
    const a = document.createElement("a");
    a.className = "nd-more-item";
    a.href = `news_detail.php?id=${article.id}`;
    a.innerHTML = `
      <div class="nd-more-thumb">
        <img src="${article.thumbnail}" alt="${article.title}" loading="lazy">
      </div>
      <div class="nd-more-body">
        <span class="nd-more-title">${article.title}</span>
        <span class="nd-more-date">${article.dateDisplay.split(" &middot; ")[0]}</span>
      </div>
    `;
    ndMoreList.appendChild(a);
  });

}

function init(){

  const id = getArticleIdFromUrl();
  const article = newsArticles.find(a => a.id === id) || getSortedArticles()[0];

  if(!article){
    ndArticle.innerHTML = `<p>Berita tidak ditemukan.</p>`;
    return;
  }

  renderArticle(article);
  renderMorePosts(article.id);

}

init();
