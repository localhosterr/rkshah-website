/**
 * RK SHAH CAR RENTAL — MAIN JS
 * Nav scroll, mobile menu, booking modal, scroll animations
 */

document.addEventListener('DOMContentLoaded', () => {

  /* ── NAV SCROLL EFFECT ─────────────────────── */
  const navbar = document.getElementById('navbar');
  if (navbar) {
    const checkScroll = () => navbar.classList.toggle('is-scrolled', window.scrollY > 60);
    window.addEventListener('scroll', checkScroll, { passive: true });
    checkScroll(); // on load
  }

  /* ── MOBILE NAV ────────────────────────────── */
  window.toggleMobileNav = function () {
    const nav     = document.getElementById('mobileNav');
    const overlay = document.getElementById('mobileOverlay');
    const burger  = document.getElementById('hamburger');
    if (!nav) return;

    const isOpen = nav.classList.toggle('is-open');
    overlay?.classList.toggle('is-visible', isOpen);
    burger?.classList.toggle('is-open', isOpen);
    burger?.setAttribute('aria-expanded', isOpen);
    nav.setAttribute('aria-hidden', !isOpen);
    document.body.style.overflow = isOpen ? 'hidden' : '';
  };

  /* ── BOOKING MODAL ─────────────────────────── */
  window.openBookingModal = function (opts = {}) {
    const modal   = document.getElementById('bookingModal');
    const backdrop = document.getElementById('modalBackdrop');
    if (!modal) return;

    // Pre-fill destination if passed
    if (opts.to) {
      const toInput = modal.querySelector('[name="to_city"]');
      if (toInput) toInput.value = opts.to;
    }

    modal.classList.add('is-open');
    backdrop.style.display = 'block';
    document.body.style.overflow = 'hidden';

    // Focus first input
    setTimeout(() => {
      modal.querySelector('input:not([type=hidden])')?.focus();
    }, 100);
  };

  window.closeBookingModal = function () {
    document.getElementById('bookingModal')?.classList.remove('is-open');
    const backdrop = document.getElementById('modalBackdrop');
    if (backdrop) backdrop.style.display = 'none';
    document.body.style.overflow = '';
  };

  // Keyboard escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeBookingModal();
  });

  /* ── SET MIN DATE ──────────────────────────── */
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  const tomorrowStr = tomorrow.toISOString().split('T')[0];
  document.querySelectorAll('input[type="date"]').forEach(inp => {
    inp.min = tomorrowStr;
    if (!inp.value) inp.value = tomorrowStr;
  });

  /* ── SCROLL REVEAL ANIMATION ───────────────── */
  const revealObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity    = '1';
        entry.target.style.transform  = 'translateY(0)';
        revealObs.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll(
    '.usp-card, .fleet-card, .pkg-card, .testi-card, .hiw-step, .route-card'
  ).forEach((el, i) => {
    el.style.opacity   = '0';
    el.style.transform = 'translateY(28px)';
    el.style.transition = `opacity .55s ease ${i * 0.06}s, transform .55s ease ${i * 0.06}s`;
    revealObs.observe(el);
  });

  /* ── STAT COUNTER ANIMATION ────────────────── */
  const counterObs = new IntersectionObserver((entries) => {
    if (entries[0].isIntersecting) {
      animateCounters();
      counterObs.disconnect();
    }
  }, { threshold: 0.5 });

  const statsBand = document.querySelector('.stats-band');
  if (statsBand) counterObs.observe(statsBand);

  function animateCounters() {
    document.querySelectorAll('.stats-band__num').forEach(el => {
      const text = el.textContent;
      const num  = parseFloat(text.replace(/[^0-9.]/g, ''));
      if (isNaN(num)) return;
      const suffix = text.replace(/[0-9.,]/g, '').replace('.', '');
      let current  = 0;
      const step   = num / 55;
      const timer  = setInterval(() => {
        current += step;
        if (current >= num) { current = num; clearInterval(timer); }
        el.textContent = (Number.isInteger(num) ? Math.floor(current) : current.toFixed(1))
          .toLocaleString('en-IN') + suffix;
      }, 22);
    });
  }

  /* ── FLASH MESSAGES ────────────────────────── */
  const flash = document.getElementById('flashMessage');
  if (flash) {
    setTimeout(() => {
      flash.style.opacity   = '0';
      flash.style.transform = 'translateY(-20px)';
      setTimeout(() => flash.remove(), 400);
    }, 4000);
  }

  /* ── FAQ ACCORDION ─────────────────────────── */
  document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', () => {
      const isOpen = item.classList.contains('is-open');
      document.querySelectorAll('.faq-item.is-open').forEach(i => i.classList.remove('is-open'));
      if (!isOpen) item.classList.add('is-open');
    });
  });

  /* ── ROUTE FILTER BUTTONS ──────────────────── */
  document.querySelectorAll('.route-filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.route-filter-btn').forEach(b => b.classList.remove('is-active'));
      btn.classList.add('is-active');
    });
  });

  /* ── SMOOTH SCROLL TO BOOKING ──────────────── */
  document.querySelectorAll('[data-scroll-to]').forEach(el => {
    el.addEventListener('click', () => {
      const target = document.getElementById(el.dataset.scrollTo);
      target?.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
  });

});

/* ── TOAST UTILITY ─────────────────────────────── */
window.showToast = function (msg, type = 'success', duration = 3500) {
  let el = document.getElementById('rk-toast');
  if (!el) {
    el = document.createElement('div');
    el.id = 'rk-toast';
    el.style.cssText = [
      'position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(80px)',
      'background:var(--navy3);color:white;padding:12px 24px;border-radius:50px',
      'font-family:var(--ff-h);font-size:13px;font-weight:600;z-index:9999',
      'opacity:0;transition:.35s;box-shadow:0 8px 28px rgba(0,0,0,.25)',
      'border:1px solid rgba(212,160,23,.3);white-space:nowrap'
    ].join(';');
    document.body.appendChild(el);
  }
  if (type === 'error')   el.style.background = '#7f1d1d';
  if (type === 'success') el.style.background = 'var(--navy3)';
  el.textContent = msg;
  el.style.opacity = '1';
  el.style.transform = 'translateX(-50%) translateY(0)';
  clearTimeout(el._timer);
  el._timer = setTimeout(() => {
    el.style.opacity = '0';
    el.style.transform = 'translateX(-50%) translateY(80px)';
  }, duration);
};
