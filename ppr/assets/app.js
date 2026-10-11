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
