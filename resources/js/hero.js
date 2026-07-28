(function () {
  'use strict';

  var hero     = document.getElementById('hero');
  var viewport = document.getElementById('heroViewport');
  var track    = document.getElementById('heroTrack');
  var slides   = Array.prototype.slice.call(track.children);
  var tabs     = Array.prototype.slice.call(document.getElementById('heroTabs').children);
  var fills    = tabs.map(function (t) { return t.querySelector('.hero-bar i'); });
  var prevBtn  = document.getElementById('heroPrev');
  var nextBtn  = document.getElementById('heroNext');

  var DURATION  = 6000;   /* autoplay per slide, ms */
  var THRESHOLD = 45;     /* swipe distance to change slide, px */
  var MOBILE    = 1100;

  var index   = 0;
  var elapsed = 0;
  var last    = null;
  var paused  = false;
  var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function isMobile() { return window.innerWidth <= MOBILE; }

  /* ---------- state ---------- */
  function goTo(i) {
    index = (i % slides.length + slides.length) % slides.length;
    track.style.setProperty('--i', index);

    tabs.forEach(function (t, n) { t.classList.toggle('is-active', n === index); });
    fills.forEach(function (f) { f.style.transform = 'scaleX(0)'; });
    slides.forEach(function (s, n) { s.setAttribute('aria-hidden', n === index ? 'false' : 'true'); });

    elapsed = 0;
    last = null;
  }

  function next() { goTo(index + 1); }
  function prev() { goTo(index - 1); }

  /* ---------- autoplay ---------- */
  function frame(ts) {
    if (last === null) last = ts;
    var dt = ts - last;
    last = ts;

    if (!paused && !reduced) {
      elapsed += dt;
      var p = elapsed / DURATION;
      if (p >= 1) {
        next();
      } else {
        fills[index].style.transform = 'scaleX(' + p.toFixed(4) + ')';
      }
    }
    window.requestAnimationFrame(frame);
  }
  window.requestAnimationFrame(frame);

  function pause()  { paused = true; }
  function resume() { last = null; paused = false; }

  hero.addEventListener('mouseenter', pause);
  hero.addEventListener('mouseleave', resume);
  hero.addEventListener('focusin', pause);
  hero.addEventListener('focusout', resume);
  document.addEventListener('visibilitychange', function () {
    document.hidden ? pause() : resume();
  });

  /* ---------- controls ---------- */
  nextBtn.addEventListener('click', next);
  prevBtn.addEventListener('click', prev);
  tabs.forEach(function (t, n) {
    t.addEventListener('mouseenter', function () { goTo(n); });
  });

  hero.addEventListener('keydown', function (e) {
    if (e.key === 'ArrowRight') { e.preventDefault(); next(); }
    if (e.key === 'ArrowLeft')  { e.preventDefault(); prev(); }
  });

  /* ---------- drag / swipe ---------- */
  var startX = 0, startY = 0, dx = 0, dragging = false, decided = false;

  viewport.addEventListener('pointerdown', function (e) {
    if (!isMobile() || e.button !== 0) return;
    dragging = true;
    decided  = false;
    startX   = e.clientX;
    startY   = e.clientY;
    dx       = 0;
    pause();
  });

  viewport.addEventListener('pointermove', function (e) {
    if (!dragging) return;
    var mx = e.clientX - startX;
    var my = e.clientY - startY;

    if (!decided) {
      if (Math.abs(mx) < 6 && Math.abs(my) < 6) return;
      if (Math.abs(my) > Math.abs(mx)) { dragging = false; resume(); return; }
      decided = true;
      track.classList.add('is-dragging');
      viewport.setPointerCapture(e.pointerId);
    }

    dx = mx;
    /* resist past the first and last slide */
    if ((index === 0 && dx > 0) || (index === slides.length - 1 && dx < 0)) dx *= .32;
    track.style.setProperty('--drag', dx + 'px');
  });

  function endDrag() {
    if (!dragging) return;
    dragging = false;
    track.classList.remove('is-dragging');
    track.style.setProperty('--drag', '0px');

    if (decided && Math.abs(dx) > THRESHOLD) {
      dx < 0 ? next() : prev();
    }
    resume();
  }

  viewport.addEventListener('pointerup', endDrag);
  viewport.addEventListener('pointercancel', endDrag);

  /* stop a drag from triggering the slide link */
  viewport.addEventListener('click', function (e) {
    if (decided && Math.abs(dx) > 6) { e.preventDefault(); e.stopPropagation(); }
  }, true);

  goTo(0);
})();
