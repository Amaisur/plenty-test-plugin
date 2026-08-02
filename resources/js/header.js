(function loadD5Style(fn) {
  // This script tag loads late enough on the page that DOMContentLoaded
  // has usually already fired by the time we get here — registering for
  // it then would never call back. Run immediately if the DOM is already
  // parsed, and only wait on the event if it genuinely hasn't fired yet.
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fn);
  } else {
    fn();
  }
})(function () {
  var href = 'https://shopfy-features.myshopify.com/cdn/shop/t/2/assets/d5-style.css?v=' + Date.now();

  var existing = document.querySelector('link[data-d5-style]');
  if (existing) existing.remove();

  var link = document.createElement('link');
  link.rel = 'stylesheet';
  link.href = href;
  link.setAttribute('data-d5-style', 'true');

  document.head.appendChild(link);
});

(function () {
  'use strict';

  var header   = document.getElementById('siteHeader');
  var nav      = document.getElementById('mainNav');
  var burger   = document.getElementById('burger');
  var lang     = document.getElementById('langSwitch');
  var langBtn  = lang.querySelector('.lh-lang-toggle-d5');
  var searchBtn    = document.querySelector('.lh-search-btn-d5');
  var searchModal  = document.getElementById('searchModal');
  var searchInput  = searchModal.querySelector('.lh-search-modal-input-d5');
  var searchClose  = searchModal.querySelector('.lh-search-modal-close-d5');
  var items    = Array.prototype.slice.call(nav.querySelectorAll('.lh-nav-item-d5.lh-has-panel-d5'));
  var panels   = items.map(function (li) {
    return {
      li: li,
      link: li.querySelector('.lh-nav-link-d5'),
      panel: li.querySelector(':scope > .lh-dropdown-d5, :scope > .lh-mega-d5')
    };
  });

  var MOBILE = 1100;
  var isMobile = function () { return window.innerWidth <= MOBILE; };

  /* ---------- sticky state ---------- */
  var ticking = false;
  function onScroll() {
    if (ticking) return;
    ticking = true;
    window.requestAnimationFrame(function () {
      header.classList.toggle('lh-is-stuck-d5', window.pageYOffset > 10);
      ticking = false;
    });
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  /* ---------- accordion panels ---------- */
  function measure(panel) {
    panel.style.maxHeight = panel.scrollHeight + 'px';
  }

  function openPanel(p) {
    p.li.classList.add('lh-is-open-d5');
    p.link.setAttribute('aria-expanded', 'true');
    if (!p.panel) return;
    measure(p.panel);
    /* Mega panels hold async-loading images (news cards, solution
       logos); a late image load can grow the panel taller than the
       height measured on open, so re-measure once each one lands. */
    Array.prototype.forEach.call(p.panel.querySelectorAll('img'), function (img) {
      if (!img.complete) {
        img.addEventListener('load', function () {
          if (p.li.classList.contains('lh-is-open-d5')) measure(p.panel);
        }, { once: true });
      }
    });
  }

  function closePanel(p) {
    p.li.classList.remove('lh-is-open-d5');
    p.link.setAttribute('aria-expanded', 'false');
    if (p.panel) p.panel.style.maxHeight = '0px';
  }

  function closeAllPanels() {
    panels.forEach(closePanel);
  }

  function closeLang() {
    lang.classList.remove('lh-is-open-d5');
    langBtn.setAttribute('aria-expanded', 'false');
  }

  /* ---------- mobile search modal ---------- */
  function openSearchModal() {
    searchModal.classList.add('lh-is-open-d5');
    window.requestAnimationFrame(function () { searchInput.focus(); });
  }
  function closeSearchModal() {
    searchModal.classList.remove('lh-is-open-d5');
  }
  searchBtn.addEventListener('click', function (e) {
    if (isMobile()) {
      /* the inline input is hidden on mobile (no room in the header),
         so the icon button opens a small modal with a full-size
         input instead of submitting the form. */
      e.preventDefault();
      openSearchModal();
    }
    /* on desktop this button is a real type="submit": clicking it
       (or pressing enter in the input) performs a normal GET
       navigation to the shop's search results page. */
  });
  searchClose.addEventListener('click', closeSearchModal);
  searchModal.addEventListener('click', function (e) {
    if (e.target === searchModal) closeSearchModal();
  });

  function closeDrawer() {
    nav.classList.remove('lh-is-open-d5');
    burger.classList.remove('lh-is-active-d5');
    burger.setAttribute('aria-expanded', 'false');
    closeAllPanels();
  }

  function openDrawer() {
    nav.classList.add('lh-is-open-d5');
    burger.classList.add('lh-is-active-d5');
    burger.setAttribute('aria-expanded', 'true');
  }

  /* ---------- burger ---------- */
  burger.addEventListener('click', function () {
    nav.classList.contains('lh-is-open-d5') ? closeDrawer() : openDrawer();
  });

  /* ---------- nav items ---------- */
  panels.forEach(function (p) {
    p.link.addEventListener('click', function (e) {
      if (isMobile()) {
        /* mobile: first tap opens the accordion instead of following the link */
        e.preventDefault();
        var wasOpen = p.li.classList.contains('lh-is-open-d5');
        closeAllPanels();
        if (!wasOpen) openPanel(p);
      }
    });

    /* desktop: keyboard focus opens the panel */
    p.li.addEventListener('focusin', function () {
      if (!isMobile()) { closeAllPanels(); p.li.classList.add('lh-is-open-d5'); p.link.setAttribute('aria-expanded', 'true'); }
    });
    p.li.addEventListener('focusout', function (e) {
      if (!isMobile() && !p.li.contains(e.relatedTarget)) { p.li.classList.remove('lh-is-open-d5'); p.link.setAttribute('aria-expanded', 'false'); }
    });
  });

  /* ---------- language ---------- */
  langBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    var open = lang.classList.toggle('lh-is-open-d5');
    langBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  document.addEventListener('click', function (e) {
    if (!lang.contains(e.target)) closeLang();
  });

  /* ---------- escape ---------- */
  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    closeLang();
    closeAllPanels();
    closeSearchModal();
    if (nav.classList.contains('lh-is-open-d5')) closeDrawer();
  });

  /* ---------- resize reset ---------- */
  var lastMobile = isMobile();
  window.addEventListener('resize', function () {
    var nowMobile = isMobile();
    if (nowMobile !== lastMobile) {
      lastMobile = nowMobile;
      closeDrawer();
      closeLang();
      closeSearchModal();
    } else if (nowMobile) {
      /* orientation change / width change within the mobile range can
         reflow the mega-panel's grid columns; re-measure whatever is
         open so it doesn't stay clipped at the old height. */
      panels.forEach(function (p) {
        if (p.li.classList.contains('lh-is-open-d5') && p.panel) measure(p.panel);
      });
    }
  });
})();
