<?php /** @var array $stories @var array $feedbacks */ ?>
<section class="yellow" id="stories" aria-label="Success stories"><h2 class="fbtitle">TESTIMONIALS</h2>
 <div class="car" id="storyCar"><button class="arrow l" aria-label="Previous story"><svg viewBox="0 0 24 24"><path d="M16 3 6 12l10 9"/></svg></button>
  <div class="track"><?php foreach ($stories as $i=>$s): ?>
   <article class="slide"><img src="<?= e($s['image']) ?>" alt="<?= e($s['title']) ?>" onerror="this.removeAttribute('src')">
    <div class="foot"><button class="btn" data-open="<?= $i ?>">VIEW STORY</button></div></article><?php endforeach; ?></div>
  <button class="arrow r" aria-label="Next story"><svg viewBox="0 0 24 24"><path d="m8 3 10 9-10 9"/></svg></button></div>
</section>
<section class="yellow" id="feedbacks"><h2 class="fbtitle">FEEDBACKS</h2>
 <div class="car fb" id="fbCar"><button class="arrow l" aria-label="Previous feedback"><svg viewBox="0 0 24 24"><path d="M16 3 6 12l10 9"/></svg></button>
  <div class="track"><?php foreach ($feedbacks as $f): ?>
   <article class="slide card"><div class="who"><img src="<?= e($f['avatar']) ?>" alt="" onerror="this.removeAttribute('src')"><?= e($f['name']) ?></div>
    <div class="ago"><?= e($f['ago']) ?></div><div class="stars" aria-label="<?= (int)$f['stars'] ?> of 5 stars"><?= str_repeat('★',(int)$f['stars']).str_repeat('☆',5-(int)$f['stars']) ?></div>
    <p>“<?= e($f['text']) ?>”</p></article><?php endforeach; ?></div>
  <button class="arrow r" aria-label="Next feedback"><svg viewBox="0 0 24 24"><path d="m8 3 10 9-10 9"/></svg></button></div>
 <div class="ctr"><a class="btn big" href="#">HELP US IMPROVE</a><br><a class="more" href="#">VIEW MORE FEEDBACK</a></div>
</section>
<div class="modal" id="modal" hidden role="dialog" aria-modal="true" aria-labelledby="mTitle">
 <button class="arrow l" id="mPrev" aria-label="Previous story"><svg viewBox="0 0 24 24"><path d="M16 3 6 12l10 9"/></svg></button>
 <div class="mbox"><button class="close" id="mClose" aria-label="Close">✕</button><img id="mImg" alt=""><div><h3 id="mTitle"></h3><div id="mBody"></div></div></div>
 <button class="arrow r" id="mNext" aria-label="Next story"><svg viewBox="0 0 24 24"><path d="m8 3 10 9-10 9"/></svg></button>
</div>
<script>const STORIES=<?= json_encode($stories, JSON_HEX_TAG|JSON_HEX_AMP) ?>;
function carousel(root, onChange){
  const s=[...root.querySelectorAll('.slide')]; let i=0; const n=s.length;
  function draw(){ s.forEach((el,k)=>{ el.className=el.className.replace(/ ?(is-prev|is-active|is-next)/g,'');
    if(k===i) el.classList.add('is-active'); else if(k===(i+n-1)%n) el.classList.add('is-prev'); else if(k===(i+1)%n) el.classList.add('is-next'); });
    s.forEach(el=>{ el.style.order=el.classList.contains('is-prev')?0:el.classList.contains('is-active')?1:2; }); onChange&&onChange(i); }
  root.querySelector('.arrow.l').onclick=()=>{i=(i+n-1)%n;draw()};
  root.querySelector('.arrow.r').onclick=()=>{i=(i+1)%n;draw()};
  draw(); return {go:k=>{i=(k+n)%n;draw()}, get:()=>i};
}
const sc=carousel(document.getElementById('storyCar')); carousel(document.getElementById('fbCar'));
const modal=document.getElementById('modal'); let cur=0;
function show(k){ cur=(k+STORIES.length)%STORIES.length; const s=STORIES[cur];
  document.getElementById('mTitle').textContent=s.title; const im=document.getElementById('mImg'); im.src=s.image; im.alt=s.title;
  const b=document.getElementById('mBody'); b.replaceChildren(...s.body.split(/\n\n+/).map(t=>{const p=document.createElement('p');p.textContent=t;return p;})); sc.go(cur); }
function open_(k){ show(k); modal.hidden=false; document.body.style.overflow='hidden'; document.getElementById('mClose').focus(); }
function close_(){ modal.hidden=true; document.body.style.overflow=''; }
document.querySelectorAll('[data-open]').forEach(b=>b.onclick=()=>open_(+b.dataset.open));
document.getElementById('mClose').onclick=close_; document.getElementById('mPrev').onclick=()=>show(cur-1); document.getElementById('mNext').onclick=()=>show(cur+1);
modal.addEventListener('click',e=>{ if(e.target===modal) close_(); });
document.addEventListener('keydown',e=>{ if(modal.hidden) return; if(e.key==='Escape') close_(); if(e.key==='ArrowLeft') show(cur-1); if(e.key==='ArrowRight') show(cur+1); });
</script>
