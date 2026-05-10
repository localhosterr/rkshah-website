<nav class="navbar" id="navbar">
    <div class="container navbar__inner">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="navbar__logo" aria-label="RK Shah Car Rental Home">
            <img src="{{ asset('images/logo/header-logo.png') }}" alt="RK Shah Car Rental Logo" class="navbar__logo-img" width="auto" height="auto">
            <!-- <div class="navbar__logo-text">
                <span class="navbar__logo-name">RK <strong>SHAH</strong></span>
                <span class="navbar__logo-sub">Car Rental</span>
                <span class="navbar__logo-tag">Your Travel Partner</span>
            </div> -->
        </a>

        {{-- Desktop Links --}}
        <div class="navbar__links" id="navLinks">
            <a href="{{ route('home') }}"         class="navbar__link @if(request()->routeIs('home')) is-active @endif">Home</a>
            <a href="{{ route('fleet.index') }}"  class="navbar__link @if(request()->routeIs('fleet.*')) is-active @endif">Fleet</a>
            <a href="{{ route('routes.index') }}" class="navbar__link @if(request()->routeIs('routes.*')) is-active @endif">Routes</a>
            <a href="{{ route('packages.index') }}" class="navbar__link @if(request()->routeIs('packages.*')) is-active @endif">Packages</a>
            <a href="{{ route('about') }}"        class="navbar__link @if(request()->routeIs('about')) is-active @endif">About</a>
            <a href="{{ route('blog.index') }}"   class="navbar__link @if(request()->routeIs('blog.*')) is-active @endif">Blog</a>
            <a href="{{ route('faq') }}"          class="navbar__link @if(request()->routeIs('faq')) is-active @endif">FAQ</a>
            <a href="{{ route('contact') }}"      class="navbar__link @if(request()->routeIs('contact')) is-active @endif">Contact</a>
            <button class="btn btn--gold btn--sm" onclick="openBookingModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 8.81 19.79 19.79 0 01.03 2.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.18 6.18l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                Book Now
            </button>
        </div>

        {{-- Hamburger --}}
        <button class="navbar__hamburger" id="hamburger" onclick="toggleMobileNav()" aria-label="Toggle menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- Mobile Navigation Drawer --}}
<div class="mobile-nav" id="mobileNav" aria-hidden="true">
    <div class="mobile-nav__inner">
        <a href="{{ route('home') }}"           class="mobile-nav__link @if(request()->routeIs('home')) is-active @endif" onclick="toggleMobileNav()">
            <span class="mobile-nav__icon">🏠</span> Home
        </a>
        <a href="{{ route('fleet.index') }}"    class="mobile-nav__link @if(request()->routeIs('fleet.*')) is-active @endif" onclick="toggleMobileNav()">
            <span class="mobile-nav__icon">🚗</span> Our Fleet
        </a>
        <a href="{{ route('routes.index') }}"   class="mobile-nav__link @if(request()->routeIs('routes.*')) is-active @endif" onclick="toggleMobileNav()">
            <span class="mobile-nav__icon">🗺️</span> Routes
        </a>
        <a href="{{ route('packages.index') }}" class="mobile-nav__link @if(request()->routeIs('packages.*')) is-active @endif" onclick="toggleMobileNav()">
            <span class="mobile-nav__icon">🎒</span> Packages
        </a>
        <a href="{{ route('about') }}"          class="mobile-nav__link @if(request()->routeIs('about')) is-active @endif" onclick="toggleMobileNav()">
            <span class="mobile-nav__icon">ℹ️</span> About Us
        </a>
        <a href="{{ route('blog.index') }}"     class="mobile-nav__link @if(request()->routeIs('blog.*')) is-active @endif" onclick="toggleMobileNav()">
            <span class="mobile-nav__icon">✍️</span> Blog
        </a>
        <a href="{{ route('faq') }}"            class="mobile-nav__link @if(request()->routeIs('faq')) is-active @endif" onclick="toggleMobileNav()">
            <span class="mobile-nav__icon">❓</span> FAQ
        </a>
        <a href="{{ route('contact') }}"        class="mobile-nav__link @if(request()->routeIs('contact')) is-active @endif" onclick="toggleMobileNav()">
            <span class="mobile-nav__icon">📞</span> Contact
        </a>
        <button class="mobile-nav__cta" onclick="openBookingModal(); toggleMobileNav()">
            📞 Book Now — +91 93245 55165
        </button>
    </div>
</div>
<div class="mobile-nav__overlay" id="mobileOverlay" onclick="toggleMobileNav()"></div>
