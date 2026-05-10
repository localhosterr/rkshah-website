/**
 * RK SHAH CMS — JAVASCRIPT
 * Sidebar, toast, modals, table filters
 */

document.addEventListener('DOMContentLoaded', () => {

  /* ── SIDEBAR TOGGLE ─────────────────────────── */
  const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
  if (collapsed) {
    document.getElementById('sidebar')?.classList.add('collapsed');
    document.body.classList.add('sidebar-collapsed');
    updateToggleIcon(true);
  }

  window.toggleSidebar = function () {
    const sidebar = document.getElementById('sidebar');
    const isCollapsed = sidebar.classList.toggle('collapsed');
    document.body.classList.toggle('sidebar-collapsed', isCollapsed);
    localStorage.setItem('sidebarCollapsed', isCollapsed);
    updateToggleIcon(isCollapsed);
  };

  function updateToggleIcon(collapsed) {
    const icon = document.querySelector('.sidebar__toggle-icon');
    const text = document.querySelector('.sidebar__toggle-text');
    if (icon) icon.textContent = collapsed ? '▶' : '◀';
    if (text) text.textContent = collapsed ? 'Expand' : 'Collapse';
  }

  /* ── LEAD BADGE (simulated live count) ─────── */
  const badge = document.getElementById('leadBadge');
  if (badge) {
    const count = parseInt(localStorage.getItem('newLeadCount') || '0');
    badge.textContent = count;
    badge.style.display = count > 0 ? 'inline-flex' : 'none';
  }

  /* ── BAR CHART ANIMATION ────────────────────── */
  setTimeout(() => {
    document.querySelectorAll('.chart-bar-fill').forEach(bar => {
      const w = bar.style.width;
      bar.style.width = '0%';
      setTimeout(() => { bar.style.width = w; }, 100);
    });
  }, 300);

  /* ── AUTO DISMISS FLASH ─────────────────────── */
  const flash = document.querySelector('.flash-msg');
  if (flash) {
    setTimeout(() => {
      flash.style.opacity = '0';
      setTimeout(() => flash.remove(), 400);
    }, 4000);
  }

  /* ── DATE MIN ───────────────────────────────── */
  const tomorrow = new Date();
  tomorrow.setDate(tomorrow.getDate() + 1);
  const tStr = tomorrow.toISOString().split('T')[0];
  document.querySelectorAll('input[type="date"]').forEach(i => {
    if (!i.min) i.min = tStr;
    if (!i.value) i.value = tStr;
  });

  /* ── TABLE FILTER ───────────────────────────── */
  window.filterTable = function (input) {
    const q = input.value.toLowerCase();
    const tbody = input.closest('.card').querySelector('tbody');
    if (!tbody) return;
    tbody.querySelectorAll('tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  };

});

/* ── TOAST ──────────────────────────────────────── */
window.showToast = function (msg, type = 'success', duration = 3500) {
  const toast = document.getElementById('cmsToast');
  if (!toast) return;
  toast.textContent = msg;
  toast.className = `toast toast--${type} show`;
  clearTimeout(toast._t);
  toast._t = setTimeout(() => toast.classList.remove('show'), duration);
};

/* ── MODAL HELPERS ───────────────────────────────── */
window.openModal = function (id) {
  document.getElementById(id)?.classList.add('open');
  document.body.style.overflow = 'hidden';
};
window.closeModal = function (id) {
  document.getElementById(id)?.classList.remove('open');
  document.body.style.overflow = '';
};

// Close modal on backdrop click
document.addEventListener('click', (e) => {
  if (e.target.classList.contains('modal-backdrop')) {
    e.target.classList.remove('open');
    document.body.style.overflow = '';
  }
});

// Close on Escape
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    document.querySelectorAll('.modal-backdrop.open').forEach(m => {
      m.classList.remove('open');
      document.body.style.overflow = '';
    });
  }
});

/* ── CONFIRM DELETE ──────────────────────────────── */
window.confirmDelete = function (id, msg) {
  if (confirm(msg || 'Are you sure you want to delete this? This cannot be undone.')) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = window.location.pathname + '/' + id;
    form.innerHTML = `
      <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]')?.content}">
      <input type="hidden" name="_method" value="DELETE">
    `;
    document.body.appendChild(form);
    form.submit();
  }
};

/* ── ROUTE/FLEET TOGGLES ─────────────────────────── */
window.toggleRoute = function (slug, active) {
  fetch(`/cms/routes/${slug}/toggle`, {
    method: 'PATCH',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.content
    },
    body: JSON.stringify({ is_published: active })
  }).then(() => showToast(active ? 'Route published' : 'Route hidden', 'success'))
    .catch(() => showToast('Failed to update', 'error'));
};

window.editCar = function (slug) {
  showToast('Edit car form coming in backend phase', 'info');
};

window.editRoute = function (slug) {
  showToast('Edit route form coming in backend phase', 'info');
};

/* ── GLOBAL FIELD CHANGE TRACKING ─────────────── */
document.addEventListener('DOMContentLoaded', () => {
  // Track all .js-track fields across all CMS pages
  document.querySelectorAll('.js-track').forEach(input => {
    const original = input.value;
    const trackChange = () => {
      const changed = input.value.trim() !== '' && input.value !== original;
      input.classList.toggle('field-changed', changed);
    };
    input.addEventListener('input', trackChange);
    input.addEventListener('change', trackChange);
  });
});

/* ── GLOBAL SEARCH ───────────────────────────────── */

// Ctrl+K to focus search
document.addEventListener('keydown', function (e) {
  if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
    e.preventDefault();
    const input = document.getElementById('globalSearch');
    if (input) { input.focus(); input.select(); }
  }
});

// Click outside to close
document.addEventListener('click', function (e) {
  const wrap = document.getElementById('globalSearchWrap');
  if (wrap && !wrap.contains(e.target)) closeGlobalSearch();
});

function closeGlobalSearch() {
  const results = document.getElementById('globalSearchResults');
  const input   = document.getElementById('globalSearch');
  if (results) setTimeout(() => { results.style.display = 'none'; }, 100);
  if (input)   setTimeout(() => { input.value = ''; selectedSearchIndex = -1; }, 100);
}

let searchTimer;
let selectedSearchIndex = -1;

function runGlobalSearch(query) {
  query = query.trim();
  const results = document.getElementById('globalSearchResults');
  if (!results) return;

  if (query.length < 2) {
    results.style.display = 'none';
    return;
  }

  results.style.display = 'block';
  results.innerHTML = '<div style="padding:16px;text-align:center;font-size:13px;color:var(--t4)">Searching...</div>';
  selectedSearchIndex = -1;

  clearTimeout(searchTimer);
  searchTimer = setTimeout(function () {
    fetch('/cms/search?q=' + encodeURIComponent(query), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function (r) { return r.json(); })
    .then(function (data) { renderSearchResults(data, query); })
    .catch(function () {
      results.innerHTML = '<div style="padding:16px;text-align:center;font-size:13px;color:var(--t4)">Search unavailable</div>';
    });
  }, 300);
}

function renderSearchResults(data, query) {
  const results = document.getElementById('globalSearchResults');
  if (!results) return;

  const total = Object.values(data).reduce(function (sum, arr) { return sum + arr.length; }, 0);

  if (total === 0) {
    results.innerHTML = '<div style="padding:20px;text-align:center;font-size:13px;color:var(--t4)">No results for <strong>"' + escHtml(query) + '"</strong></div>';
    return;
  }

  const icons = {
    leads:    { bg: '#DBEAFE', icon: '📋' },
    bookings: { bg: '#D1FAE5', icon: '📅' },
    routes:   { bg: '#FEF3C7', icon: '🗺️' },
    fleet:    { bg: '#EDE9FE', icon: '🚗' },
    blog:     { bg: '#FCE7F3', icon: '✍️' },
  };
  const labels = {
    leads:    'Leads & Enquiries',
    bookings: 'Bookings',
    routes:   'Routes',
    fleet:    'Fleet',
    blog:     'Blog Posts',
  };

  var html = '';
  Object.entries(data).forEach(function ([group, items]) {
    if (!items.length) return;
    var style = icons[group] || { bg: '#F3F4F6', icon: '📄' };
    html += '<div style="padding:6px 0;border-bottom:1px solid var(--border)">';
    html += '<div style="font-size:9px;font-family:var(--ff-h);font-weight:700;color:var(--t4);letter-spacing:1px;text-transform:uppercase;padding:6px 14px 4px">' + (labels[group] || group) + '</div>';
    items.forEach(function (item) {
      html += '<a href="' + escHtml(item.url) + '" onclick="closeGlobalSearch()" style="display:flex;align-items:center;gap:10px;padding:9px 14px;cursor:pointer;text-decoration:none;color:inherit;transition:background .15s" onmouseover="this.style.background=\'var(--bg)\'" onmouseout="this.style.background=\'\'">';
      html += '<div style="width:30px;height:30px;border-radius:var(--r);background:' + style.bg + ';display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0">' + style.icon + '</div>';
      html += '<div>';
      html += '<div style="font-size:13px;font-weight:600;color:var(--t1);font-family:var(--ff-h);line-height:1.2">' + highlight(item.title, query) + '</div>';
      html += '<div style="font-size:11px;color:var(--t4);margin-top:1px">' + escHtml(item.subtitle || '') + '</div>';
      html += '</div></a>';
    });
    html += '</div>';
  });

  results.innerHTML = html;
}

// Arrow key navigation through results
function handleSearchKey(e) {
  const items = document.querySelectorAll('#globalSearchResults a');
  if (!items.length) return;

  if (e.key === 'ArrowDown') {
    e.preventDefault();
    selectedSearchIndex = Math.min(selectedSearchIndex + 1, items.length - 1);
  } else if (e.key === 'ArrowUp') {
    e.preventDefault();
    selectedSearchIndex = Math.max(selectedSearchIndex - 1, 0);
  } else if (e.key === 'Enter' && selectedSearchIndex >= 0) {
    e.preventDefault();
    items[selectedSearchIndex].click();
    return;
  } else {
    return;
  }

  items.forEach(function (item, i) {
    item.style.background = i === selectedSearchIndex ? 'var(--bg)' : '';
  });
  if (items[selectedSearchIndex]) {
    items[selectedSearchIndex].scrollIntoView({ block: 'nearest' });
  }
}

function highlight(text, query) {
  if (!query) return escHtml(text);
  var escaped = escHtml(text);
  var re = new RegExp('(' + escHtml(query).replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
  return escaped.replace(re, '<span style="color:var(--navy);background:rgba(212,160,23,.2);border-radius:2px;padding:0 1px">$1</span>');
}

function escHtml(str) {
  return String(str || '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}