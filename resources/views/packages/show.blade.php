@extends('layouts.app')

@section('title', $package->name . ($package->nights > 0 ? ' — ' . $package->nights . 'N/' . $package->days . 'D' : '') . ' from Delhi by Cab | RK Shah Car Rental') . ' from Delhi | RK Shah Car Rental')
@section('meta_description', $package->name . ' from Delhi. ' . ($package->nights > 0 ? $package->nights . ' nights, ' . $package->days . ' days. ' : '') . (!empty($package->destinations) ? 'Covering ' . implode(', ', array_slice((array)$package->destinations, 0, 3)) . '. ' : '') . 'AC cab + driver + all tolls included. Starting ₹' . ($package->price > 0 ? number_format($package->price) : 'custom quote') . '. Call +91 93245 55165.') . 'Starting ₹' . ($package->price > 0 ? number_format($package->price) : 'custom') . '/person. Call +91 93245 55165.')

@section('content')

  {{-- Hero --}}
  <div class="page-hero">
    <div class="container">
      <nav class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb__sep">›</span>
        <a href="{{ route('packages.index') }}">Packages</a>
        <span class="breadcrumb__sep">›</span>
        <span class="breadcrumb__current">{{ $package->name }}</span>
      </nav>

      <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
        @if($package->badge)
          <span class="eyebrow">{{ $package->badge }}</span>
        @endif
        @if($package->nights > 0)
          <span style="font-size:12px;color:rgba(255,255,255,.5);font-family:var(--ff-h)">
            {{ $package->nights }} Nights · {{ $package->days }} Days
          </span>
        @endif
      </div>

      <h1 class="page-hero__title">{{ $package->name }}</h1>

      <p class="page-hero__desc">
        @if($package->price > 0)
          Starting from ₹{{ number_format($package->price) }}/person ·
        @endif
        {{ implode(', ', array_slice($package->destinations ?? [], 0, 4)) }}
      </p>
    </div>
  </div>

  <section class="section section--light">
    <div class="container">
      <div style="display:grid;grid-template-columns:2fr 1fr;gap:40px;align-items:start">

        {{-- Left: Description + Itinerary --}}
        <div>

          {{-- Description --}}
          <p style="font-size:15px;line-height:1.8;color:var(--gray5);margin-bottom:32px">
            {{ $package->description }}
          </p>

          {{-- Destinations covered --}}
          @if(!empty($package->destinations))
            <div style="margin-bottom:28px">
              <h2 style="font-family:var(--ff-h);font-size:1rem;font-weight:800;color:var(--navy3);margin-bottom:12px">
                Destinations Covered
              </h2>
              <div style="display:flex;flex-wrap:wrap;gap:8px">
                @foreach($package->destinations as $dest)
                  <span class="pkg-card__dest" style="font-size:13px;padding:6px 14px">
                    📍 {{ $dest }}
                  </span>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Itinerary --}}
          @if(!empty($package->itinerary))
            <div>
              <h2 style="font-family:var(--ff-h);font-size:1.1rem;font-weight:800;color:var(--navy3);margin-bottom:20px">
                Day-by-Day Itinerary
              </h2>

              @foreach($package->itinerary as $day)
                <div
                  style="display:flex;gap:16px;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--gray2)">
                  {{-- Day circle --}}
                  <div
                    style="width:44px;height:44px;border-radius:50%;background:var(--navy3);display:flex;align-items:center;justify-content:center;font-family:var(--ff-h);font-size:11px;font-weight:800;color:var(--gold);flex-shrink:0;margin-top:2px">
                    D{{ $day['day'] }}
                  </div>
                  <div style="flex:1">
                    <div
                      style="font-family:var(--ff-h);font-size:.95rem;font-weight:700;color:var(--navy3);margin-bottom:5px">
                      {{ $day['title'] }}
                    </div>
                    <div style="font-size:13.5px;color:var(--gray5);line-height:1.7">
                      {{ $day['desc'] }}
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif

          {{-- What's included --}}
          @if(!empty($package->includes))
            <div
              style="background:var(--white);border:1.5px solid var(--gray2);border-radius:var(--r2);padding:24px;margin-top:8px">
              <h2 style="font-family:var(--ff-h);font-size:1rem;font-weight:800;color:var(--navy3);margin-bottom:14px">
                What's Included
              </h2>
              <div style="display:flex;flex-wrap:wrap;gap:8px">
                @foreach($package->includes as $item)
                  <span
                    style="display:inline-flex;align-items:center;gap:5px;padding:7px 13px;background:rgba(8,60,93,.06);border-radius:20px;font-size:13px;font-weight:600;color:var(--navy3)">
                    ✓ {{ $item }}
                  </span>
                @endforeach
              </div>
            </div>
          @endif

        </div>

        {{-- Right: Sticky booking sidebar --}}
        <div style="position:sticky;top:96px">
          <div
            style="background:var(--white);border:1.5px solid var(--gray2);border-radius:var(--r3);padding:24px;box-shadow:var(--shadow)">

            {{-- Price --}}
            @if($package->price > 0)
              <div style="margin-bottom:4px">
                <span
                  style="font-size:10px;color:var(--gray4);font-family:var(--ff-h);text-transform:uppercase;letter-spacing:.5px">Starting
                  from</span>
              </div>
              <div
                style="font-family:var(--ff-h);font-size:2rem;font-weight:900;color:var(--navy3);line-height:1;margin-bottom:4px">
                ₹{{ number_format($package->price) }}
              </div>
              <div style="font-size:13px;color:var(--gray4);margin-bottom:6px">
                per person
                @if($package->nights > 0)
                  · {{ $package->nights }}N/{{ $package->days }}D
                @endif
              </div>
              <div style="font-size:11px;color:var(--gold);font-family:var(--ff-h);font-weight:600;margin-bottom:20px">
                Final price confirmed on call
              </div>
            @else
              <div style="font-family:var(--ff-h);font-size:1.4rem;font-weight:900;color:var(--navy3);margin-bottom:6px">
                Custom Pricing
              </div>
              <div style="font-size:13px;color:var(--gray4);margin-bottom:20px">
                Based on group size & requirements
              </div>
            @endif

            {{-- Includes chips --}}
            @if(!empty($package->includes))
              <div style="display:flex;flex-direction:column;gap:6px;margin-bottom:20px">
                @foreach($package->includes as $inc)
                  <div style="display:flex;align-items:center;gap:8px;font-size:12px;color:var(--gray5)">
                    <span style="color:var(--green);font-weight:700">✓</span>
                    {{ $inc }}
                  </div>
                @endforeach
              </div>
            @endif

            {{-- CTAs --}}
            <div style="display:flex;flex-direction:column;gap:10px">
              <button onclick="openBookingModal()" class="btn btn--gold btn--full btn--lg">
                📞 Book This Package
              </button>
              <a href="https://wa.me/919324555165?text={{ urlencode('Hi! I am interested in the ' . $package->name . ' package. Please share details.') }}"
                class="btn btn--navy btn--full" target="_blank" rel="noopener">
                💬 Ask on WhatsApp
              </a>
              <a href="tel:+919324555165" class="btn btn--outline btn--full">
                📱 +91 93245 55165
              </a>
            </div>

            <div style="margin-top:16px;padding-top:16px;border-top:1px solid var(--gray2);text-align:center">
              <div style="font-size:11px;color:var(--gray4)">🔒 No advance needed for enquiry</div>
              <div style="font-size:11px;color:var(--gray4);margin-top:3px">Free cancellation · Flexible itinerary</div>
            </div>
          </div>
        </div>

      </div>

      {{-- Related packages --}}
      @if($related->count() > 0)
        <div style="margin-top:56px">
          <h2 style="font-family:var(--ff-h);font-size:1.3rem;font-weight:900;color:var(--navy3);margin-bottom:6px">
            Other Packages You May Like
          </h2>
          <p style="font-size:14px;color:var(--gray4);margin-bottom:24px">
            More handcrafted tours from Delhi
          </p>
          <div class="grid grid--3">
            @foreach($related as $pkg)
              <div class="pkg-card pkg-card--{{ $pkg->bg_class }}">
                {{-- <div class="pkg-card__img" style="position:relative;overflow:hidden">
                  @if($pkg->featured_image)
                  <img src="{{ asset('storage/'.$pkg->featured_image) }}" alt="{{ $pkg->name }}"
                    style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">
                  @else
                  <div class="pkg-card__img-bg">{{ $pkg->emoji }}</div>
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
                    <div class="pkg-card__nights">{{ $pkg->nights }}N · {{ $pkg->days }}D</div>
                  @else
                    <div class="pkg-card__nights">CUSTOM</div>
                  @endif
                  <h3 class="pkg-card__name">{{ $pkg->name }}</h3>
                  <div class="pkg-card__dests">
                    @foreach(array_slice($pkg->destinations ?? [], 0, 2) as $d)
                      <span class="pkg-card__dest">{{ $d }}</span>
                    @endforeach
                  </div>
                  <div class="pkg-card__footer">
                    @if($pkg->price > 0)
                      <div class="pkg-card__price">₹{{ number_format($pkg->price) }}<span>/person</span></div>
                    @else
                      <div class="pkg-card__price">Custom</div>
                    @endif
                    <a href="{{ route('packages.show', $pkg->slug) }}" class="btn btn--navy btn--sm">View</a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

    </div>
  </section>

@endsection