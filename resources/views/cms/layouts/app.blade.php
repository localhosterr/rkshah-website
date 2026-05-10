<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — RK Shah CMS</title>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/cms.css') }}">
  @stack('styles')
</head>

<body id="cmsBody">
  <div class="cms-wrap">

    <aside class="sidebar" id="sidebar">
      <div class="sidebar__brand">
        <div class="sidebar__brand-icon">RK</div>
        <div class="sidebar__brand-text">
          <div class="sidebar__brand-name">RK Shah CMS</div>
          <div class="sidebar__brand-sub">Admin Dashboard</div>
        </div>
      </div>

      <nav class="sidebar__nav">
        <div class="nav-section">
          <div class="nav-section__label">Main</div>
          <a href="{{ route('cms.dashboard') }}"
            class="nav-item {{ request()->routeIs('cms.dashboard') ? 'active' : '' }}"><span
              class="nav-item__icon">🏠</span><span class="nav-item__text">Dashboard</span></a>
          <a href="{{ route('cms.leads') }}"
            class="nav-item {{ request()->routeIs('cms.leads*') ? 'active' : '' }}"><span
              class="nav-item__icon">📋</span><span class="nav-item__text">Leads & Enquiries</span></a>
          <a href="{{ route('cms.bookings') }}"
            class="nav-item {{ request()->routeIs('cms.bookings*') ? 'active' : '' }}"><span
              class="nav-item__icon">📅</span><span class="nav-item__text">Bookings</span></a>
          <a href="{{ route('cms.calendar') }}"
            class="nav-item {{ request()->routeIs('cms.calendar') ? 'active' : '' }}"><span
              class="nav-item__icon">🗓️</span><span class="nav-item__text">Trip Calendar</span></a>
        </div>

        <div class="nav-section">
          <div class="nav-section__label">Website Content</div>
          <a href="{{ route('cms.content.homepage') }}"
            class="nav-item {{ request()->routeIs('cms.content.homepage') ? 'active' : '' }}"><span
              class="nav-item__icon">🏠</span><span class="nav-item__text">Homepage Editor</span></a>
          <a href="{{ route('cms.fleet') }}"
            class="nav-item {{ request()->routeIs('cms.fleet*') ? 'active' : '' }}"><span
              class="nav-item__icon">🚗</span><span class="nav-item__text">Fleet Manager</span></a>
          <a href="{{ route('cms.routes') }}"
            class="nav-item {{ request()->routeIs('cms.routes*') ? 'active' : '' }}"><span
              class="nav-item__icon">🗺️</span><span class="nav-item__text">Routes & Pricing</span></a>
          <a href="{{ route('cms.content.packages') }}"
            class="nav-item {{ request()->routeIs('cms.content.packages*') ? 'active' : '' }}"><span
              class="nav-item__icon">🎒</span><span class="nav-item__text">Tour Packages</span></a>
          <a href="{{ route('cms.testimonials') }}"
            class="nav-item {{ request()->routeIs('cms.testimonials*') ? 'active' : '' }}"><span
              class="nav-item__icon">⭐</span><span class="nav-item__text">Testimonials</span></a>
          <a href="{{ route('cms.blog') }}" class="nav-item {{ request()->routeIs('cms.blog*') ? 'active' : '' }}"><span
              class="nav-item__icon">✍️</span><span class="nav-item__text">Blog Manager</span></a>
          <a href="{{ route('cms.faqs') }}" class="nav-item {{ request()->routeIs('cms.faqs*') ? 'active' : '' }}"><span
              class="nav-item__icon">❓</span><span class="nav-item__text">FAQ Manager</span></a>
          <a href="{{ route('cms.content.about') }}"
            class="nav-item {{ request()->routeIs('cms.content.about') ? 'active' : '' }}"><span
              class="nav-item__icon">📖</span><span class="nav-item__text">About Page</span></a>
        </div>

        <div class="nav-section">
          <div class="nav-section__label">System</div>
          <a href="{{ route('cms.settings') }}"
            class="nav-item {{ request()->routeIs('cms.settings*') ? 'active' : '' }}"><span
              class="nav-item__icon">⚙️</span><span class="nav-item__text">Settings</span></a>
          <a href="{{ route('home') }}" class="nav-item" target="_blank"><span class="nav-item__icon">🌐</span><span
              class="nav-item__text">View Website ↗</span></a>
          <a href="{{ route('cms.logout') }}" class="nav-item" style="color:rgba(239,68,68,.6)"><span
              class="nav-item__icon">🚪</span><span class="nav-item__text">Logout</span></a>
        </div>
      </nav>

      <div class="sidebar__footer">
        <button class="sidebar__toggle" onclick="toggleSidebar()" id="sidebarToggle">
          <span class="sidebar__toggle-icon">◀</span>
          <span class="sidebar__toggle-text">Collapse</span>
        </button>
      </div>
    </aside>

    <div class="cms-main">
      <header class="cms-header">
        <div>
          <div class="cms-header__title">@yield('page-title', 'Dashboard')</div>
          <div class="cms-header__sub">@yield('page-subtitle', date('l, d F Y'))</div>
        </div>

        {{-- Universal Search --}}
        <div style="flex:1;max-width:380px;margin:0 24px;position:relative" id="globalSearchWrap">
          <div
            style="display:flex;align-items:center;background:var(--bg);border:1.5px solid var(--border2);border-radius:var(--r2);padding:8px 14px;gap:8px;transition:.2s"
            id="globalSearchBar">
            <span style="font-size:15px;color:var(--t4);flex-shrink:0">🔍</span>
            <input type="text" id="globalSearch" placeholder="Search leads, bookings, routes..." autocomplete="off"
              style="background:none;border:none;outline:none;font-size:13px;color:var(--t1);width:100%;font-family:var(--ff-b)"
              oninput="runGlobalSearch(this.value)" onkeydown="handleSearchKey(event)">
            <kbd
              style="font-size:10px;color:var(--t4);background:var(--border);padding:2px 6px;border-radius:4px;flex-shrink:0;font-family:var(--ff-h)">Ctrl+K</kbd>
          </div>
          <div id="globalSearchResults"
            style="display:none;position:absolute;top:calc(100% + 6px);left:0;right:0;background:white;border:1.5px solid var(--border2);border-radius:var(--r2);box-shadow:var(--shadow2);z-index:9999;max-height:420px;overflow-y:auto">
          </div>
        </div>

        <div class="cms-header__actions">
          @stack('header-actions')
          <div class="header-avatar" title="Admin">RK</div>
        </div>
      </header>

      @if(session('success'))
        <div
          style="background:#D1FAE5;border-bottom:1px solid #6EE7B7;padding:12px 24px;font-size:13px;color:#065F46;font-family:var(--ff-h);font-weight:600;display:flex;align-items:center;gap:8px">
          ✅ {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div
          style="background:#FEE2E2;border-bottom:1px solid #FCA5A5;padding:12px 24px;font-size:13px;color:#991B1B;font-family:var(--ff-h);font-weight:600;display:flex;align-items:center;gap:8px">
          ❌ {{ session('error') }}
        </div>
      @endif
      @if($errors->any())
        <div
          style="background:#FEE2E2;border-bottom:1px solid #FCA5A5;padding:12px 24px;font-size:13px;color:#991B1B;font-family:var(--ff-h);font-weight:600">
          ❌ Please fix the following:
          @foreach($errors->all() as $e)
            <div style="font-weight:400;margin-top:2px">• {{ $e }}</div>
          @endforeach
        </div>
      @endif

      <main class="cms-content">@yield('content')</main>
    </div>
  </div>

  <div class="toast" id="cmsToast"></div>
  <script src="{{ asset('js/cms.js') }}" defer></script>
  @stack('scripts')
</body>

</html>