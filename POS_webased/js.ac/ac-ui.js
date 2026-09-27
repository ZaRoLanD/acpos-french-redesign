/* ============================================================
   AC POS — Interactions JS (thème, spotlight, scroll reveal, compteurs)
   Vanilla JS, aucune dépendance.
   ============================================================ */
(function () {
  'use strict';

  /* ---------- Thème clair/sombre ---------- */
  var THEME_KEY = 'acpos-theme';

  function applyTheme(mode) {
    var root = document.documentElement;
    root.classList.remove('force-light', 'dark-mode');
    if (mode === 'light') root.classList.add('force-light');
    if (mode === 'dark') root.classList.add('dark-mode');
  }

  function initTheme() {
    var saved = null;
    try { saved = localStorage.getItem(THEME_KEY); } catch (e) {}
    if (saved === 'light' || saved === 'dark') applyTheme(saved);

    var btn = document.querySelector('[data-theme-toggle]');
    if (!btn) return;

    function currentMode() {
      var root = document.documentElement;
      if (root.classList.contains('force-light')) return 'light';
      if (root.classList.contains('dark-mode')) return 'dark';
      return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
    }

    function syncIcon() {
      btn.textContent = currentMode() === 'light' ? '🌙' : '☀️';
      btn.setAttribute('aria-label', 'Basculer le thème');
    }

    btn.addEventListener('click', function () {
      var next = currentMode() === 'light' ? 'dark' : 'light';
      applyTheme(next);
      try { localStorage.setItem(THEME_KEY, next); } catch (e) {}
      syncIcon();
    });

    syncIcon();
  }

  /* ---------- Effet spotlight suivant le curseur ---------- */
  function initSpotlight() {
    document.querySelectorAll('.spotlight, .glass-card').forEach(function (el) {
      el.addEventListener('pointermove', function (ev) {
        var rect = el.getBoundingClientRect();
        el.style.setProperty('--mx', (ev.clientX - rect.left) + 'px');
        el.style.setProperty('--my', (ev.clientY - rect.top) + 'px');
      });
    });
  }

  /* ---------- Apparition au scroll ---------- */
  function initReveal() {
    var els = document.querySelectorAll('.reveal');
    if (!els.length) return;
    if (!('IntersectionObserver' in window)) {
      els.forEach(function (el) { el.classList.add('visible'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    els.forEach(function (el) { io.observe(el); });
  }

  /* ---------- Compteurs animés pour les stats ---------- */
  function initCounters() {
    var els = document.querySelectorAll('[data-count]');
    if (!els.length) return;

    function animate(el) {
      var target = parseFloat(el.getAttribute('data-count'));
      if (isNaN(target)) return;
      var decimals = (el.getAttribute('data-count') || '').split('.')[1];
      var dec = decimals ? decimals.length : 0;
      var duration = 1200;
      var start = null;

      function step(ts) {
        if (!start) start = ts;
        var p = Math.min((ts - start) / duration, 1);
        var eased = 1 - Math.pow(1 - p, 3);
        el.textContent = (target * eased).toFixed(dec);
        if (p < 1) requestAnimationFrame(step);
      }
      requestAnimationFrame(step);
    }

    if (!('IntersectionObserver' in window)) {
      els.forEach(function (el) { animate(el); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animate(entry.target);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });
    els.forEach(function (el) { io.observe(el); });
  }

  /* ---------- Marquage du lien actif dans la nav latérale ---------- */
  function initActiveNav() {
    var page = document.body.getAttribute('data-page');
    if (!page) return;
    document.querySelectorAll('.side-nav a').forEach(function (a) {
      var href = a.getAttribute('href') || '';
      var key = href.split('?')[0].split('/').pop().replace('.php', '');
      if (key && key === page) a.classList.add('active');
    });
  }

  /* ---------- Libellés responsive pour les tables (depuis thead th) ---------- */
  function initTableLabels() {
    document.querySelectorAll('table').forEach(function (table) {
      var headers = Array.prototype.map.call(
        table.querySelectorAll('thead th'),
        function (th) { return th.textContent.trim(); }
      );
      if (!headers.length) return;
      table.querySelectorAll('tbody tr').forEach(function (tr) {
        Array.prototype.forEach.call(tr.querySelectorAll('td'), function (td, i) {
          if (headers[i] && !td.hasAttribute('data-label')) {
            td.setAttribute('data-label', headers[i]);
          }
        });
      });
    });
  }

  /* ---------- Auto-focus champ scan (caisse) ---------- */
  function initScanFocus() {
    var scan = document.querySelector('[data-scan-field]');
    if (scan) scan.focus();
  }

  /* ---------- Boot ---------- */
  function boot() {
    initTheme();
    initSpotlight();
    initReveal();
    initCounters();
    initActiveNav();
    initTableLabels();
    initScanFocus();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
