@extends('layouts.app')

@section('title', 'Tour Packages from Delhi — Rajasthan, Himachal, Uttarakhand | RK Shah')
@section('meta_description', 'All-inclusive tour packages from Delhi. Rajasthan, Himachal, Char Dham, Agra, Rishikesh. Cab + driver + itinerary. Starting ₹5,500. Call +91 93245 55165.')

@section('content')

  {{-- Hero --}}
  <div class="page-hero">
    <div class="container">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__current">Tour Packages</span>
      </nav>
      <span class="page-hero__eyebrow">Tour Packages</span>
      <h1 class="page-hero__title">Handcrafted <span>Holiday Packages</span></h1>
      <p class="page-hero__desc">
        All-inclusive tours with cab, expert driver, and planned itinerary.
        You just pack your bags — we handle everything else.
      </p>
    </div>
  </div>

  <section class="section section--light">
    <div class="container">

      {{-- What's included bar --}}
      <div
        style="background:var(--navy3);border-radius:var(--r2);padding:16px 24px;margin-bottom:36px;display:flex;align-items:center;gap:24px;flex-wrap:wrap">
        <div
          style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:.5px;flex-shrink:0">
          Every package includes:</div>
        @foreach(['✅ AC Cab', '✅ Experienced Driver', '✅ Fuel & Tolls', '✅ Flexible Itinerary', '✅ 24/7 Support'] as $item)
          <div style="font-size:13px;color:rgba(255,255,255,.75);font-family:var(--ff-h);font-weight:500">{{ $item }}</div>
        @endforeach
      </div>

      {{-- Package grid --}}
      <div class="grid grid--3">
        @forelse($packages as $pkg)
          <div class="pkg-card pkg-card--{{ $pkg->bg_class }}">

            {{-- <div class="pkg-card__img" style="position:relative;overflow:hidden">
              @if($pkg->featured_image)
              <img src="{{ asset('storage/'.$pkg->featured_image) }}" alt="{{ $pkg->name }}"
                style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">
              @else
              <div class="pkg-card__img-bg" aria-hidden="true">{{ $pkg->emoji }}</div>
              @endif
              @if($pkg->badge)
              <span class="pkg-card__badge">{{ $pkg->badge }}</span>
              @endif
            </div> --}}

            <div class="pkg-card__img" style="position:relative;overflow:hidden;background:#083C5D">
              @if($pkg->featured_image)
                <img src="{{ asset('storage/' . $pkg->featured_image) }}" alt="{{ $pkg->name }}"
                  style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;z-index:1">
              @else
                <div class="pkg-card__img-bg" aria-hidden="true">{{ $pkg->emoji }}</div>
              @endif
              @if($pkg->badge)
                <span class="pkg-card__badge" style="z-index:2;position:relative">{{ $pkg->badge }}</span>
              @endif
            </div>

            <div class="pkg-card__body">
              @if($pkg->nights > 0)
                <div class="pkg-card__nights">{{ $pkg->nights }} NIGHTS · {{ $pkg->days }} DAYS</div>
              @else
                <div class="pkg-card__nights">CUSTOM PACKAGE</div>
              @endif

              <h3 class="pkg-card__name">{{ $pkg->name }}</h3>

              {{-- Destinations --}}
              <div class="pkg-card__dests">
                @foreach(array_slice($pkg->destinations ?? [], 0, 3) as $dest)
                  <span class="pkg-card__dest">{{ $dest }}</span>
                @endforeach
              </div>

              <div class="pkg-card__footer">
                @if($pkg->price > 0)
                  <div>
                    <div
                      style="font-size:9px;color:var(--gray4);font-family:var(--ff-h);margin-bottom:2px;text-transform:uppercase">
                      Starting</div>
                    <div class="pkg-card__price">₹{{ number_format($pkg->price) }} <span>/person</span></div>
                  </div>
                @else
                  <div class="pkg-card__price">Custom <span>pricing</span></div>
                @endif
                <a href="{{ route('packages.show', $pkg->slug) }}" class="btn btn--navy btn--sm">
                  View Details
                </a>
              </div>
            </div>

          </div>
        @empty
          <div style="grid-column:1/-1;text-align:center;padding:60px 24px">
            <div style="font-size:40px;opacity:.3;margin-bottom:12px">🎒</div>
            <p style="color:var(--gray4)">No packages available right now. Call us for custom trip planning.</p>
          </div>
        @endforelse
      </div>

      {{-- Pricing note --}}
      <div
        style="margin-top:28px;background:var(--white);border:1px solid var(--gray2);border-radius:var(--r2);padding:16px 20px;display:flex;gap:12px;align-items:flex-start">
        <span style="font-size:18px;flex-shrink:0">💡</span>
        <p style="font-size:13px;color:var(--gray5);margin:0;line-height:1.6">
          <strong>Pricing note:</strong> Prices shown are starting rates per person based on shared cab. Exact fare
          depends on group size, car type, and customisations to the itinerary. RK Shah confirms the final price on call
          before you pay anything.
        </p>
      </div>

    </div>
  </section>

  {{-- Custom trip CTA --}}
  <section style="background:var(--cream);padding:60px 0;border-top:1px solid var(--gray2)">
    <div class="container">
      <div style="max-width:640px;margin:0 auto;text-align:center">
        <div style="font-size:40px;margin-bottom:16px">✨</div>
        <h2 style="font-family:var(--ff-h);font-size:1.6rem;font-weight:900;color:var(--navy3);margin-bottom:12px">
          Can't find what you're looking for?
        </h2>
        <p style="font-size:15px;color:var(--gray5);margin-bottom:28px;line-height:1.7">
          Tell us your destination, number of days, group size, and budget — we'll build a custom itinerary just for you.
        </p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
          <a href="{{ route('packages.show', 'custom') }}" class="btn btn--gold btn--lg">✨ Plan Custom Trip</a>
          <a href="tel:+919324555165" class="btn btn--navy btn--lg">📞 Call RK Shah</a>
        </div>
      </div>
    </div>
  </section>

@endsection