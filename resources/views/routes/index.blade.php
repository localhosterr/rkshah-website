@extends('layouts.app')

@section('title', 'Outstation Cab Routes from Delhi — Starting Fares | RK Shah')
@section('meta_description', $totalCount . ' outstation routes from Delhi. Agra, Jaipur, Manali, Shimla, Rishikesh & more. AC cabs, verified drivers. Call +91 93245 55165.')

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <span class="breadcrumb__current">Routes</span>
    </nav>
    <span class="page-hero__eyebrow">Route Directory</span>
    <h1 class="page-hero__title">Delhi Outstation <span>Route Finder</span></h1>
    <p class="page-hero__desc">
      {{ $totalCount }}+ routes from Delhi with starting fares across all car types.
      Final price confirmed on call — no hidden charges.
    </p>
  </div>
</div>

<section class="section section--light">
  <div class="container">

    {{-- Tag filter buttons --}}
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:28px;align-items:center">
      <span style="font-size:12px;color:var(--gray4);font-family:var(--ff-h);font-weight:600;margin-right:4px">Filter:</span>
      @foreach(['All', ...$tags] as $tag)
      <a href="{{ route('routes.index', ['tag' => $tag]) }}"
         style="padding:8px 16px;border-radius:20px;font-size:12px;font-weight:600;border:1.5px solid;
                border-color:{{ $filter===$tag ? 'var(--navy)' : 'var(--gray2)' }};
                background:{{ $filter===$tag ? 'var(--navy)' : 'var(--white)' }};
                color:{{ $filter===$tag ? 'white' : 'var(--gray5)' }};
                text-decoration:none;font-family:var(--ff-h);transition:all .2s">
        {{ $tag }}
      </a>
      @endforeach

      <span style="margin-left:auto;font-size:12px;color:var(--gray4)">
        {{ $filtered->count() }} route{{ $filtered->count() !== 1 ? 's' : '' }} shown
      </span>
    </div>

    {{-- Routes grid --}}
    @if($filtered->count() > 0)
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
      @foreach($filtered as $route)
      <div class="route-card" style="background:var(--white);border-color:var(--gray2)">

        <div class="route-card__stripe" style="background:{{ $route->accent_color ?? 'var(--navy)' }}"></div>

        {{-- Route image if uploaded --}}
        @if($route->featured_image)
        <div style="height:120px;overflow:hidden">
          <img src="{{ asset('storage/'.$route->featured_image) }}"
               alt="{{ $route->from_city }} to {{ $route->to_city }}"
               style="width:100%;height:100%;object-fit:cover">
        </div>
        @endif

        <div class="route-card__body">
          <div class="route-card__header">
            <div class="route-card__name" style="color:var(--navy3)">
              {{ $route->from_city }}
              <span class="route-card__arrow">→</span>
              {{ $route->to_city }}
            </div>
            @if($route->tag)
            <span class="route-card__tag" style="background:rgba(8,60,93,.08);color:var(--navy)">
              {{ $route->tag }}
            </span>
            @endif
          </div>

          <div class="route-card__meta" style="color:var(--gray4)">
            @if($route->distance_km > 0)
              {{ $route->distance_km }} km ·
              ~{{ $route->duration_hrs }} hrs ·
            @endif
            {{ $route->highway }}
          </div>

          {{-- Car price chips --}}
          <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:8px">
            @foreach([
              'Dzire'  => $route->price_dzire,
              'Innova' => $route->price_innova,
            ] as $label => $price)
            @if($price)
            <span style="font-size:11px;padding:3px 9px;border-radius:20px;background:var(--gray1);color:var(--gray5);font-family:var(--ff-h);font-weight:600">
              {{ $label }} from ₹{{ number_format($price) }}
            </span>
            @endif
            @endforeach
          </div>
        </div>

        <div class="route-card__pricing" style="border-color:var(--gray2)">
          <div class="route-card__from" style="color:var(--gray4);font-size:10px">Starting</div>
          <div class="route-card__price" style="color:var(--navy3)">
            {{ $route->min_price ? '₹'.number_format($route->min_price) : 'Get Quote' }}
          </div>
          <div class="route-card__unit" style="color:var(--gray4)">one way</div>
          <a href="{{ route('routes.show', $route->slug) }}" class="btn btn--navy btn--sm">
            Details
          </a>
        </div>

      </div>
      @endforeach
    </div>

    @else
    <div style="text-align:center;padding:60px 24px">
      <div style="font-size:40px;margin-bottom:12px;opacity:.4">🗺️</div>
      <div style="font-family:var(--ff-h);font-size:1rem;font-weight:700;color:var(--gray5);margin-bottom:8px">No routes found</div>
      <p style="font-size:14px;color:var(--gray4)">Try a different filter or call us for any destination.</p>
      <a href="{{ route('routes.index') }}" class="btn btn--navy" style="margin-top:16px">Show All Routes</a>
    </div>
    @endif

    {{-- Note about pricing --}}
    @if($filtered->count() > 0)
    <div style="margin-top:24px;background:var(--white);border:1px solid var(--gray2);border-radius:var(--r2);padding:16px 20px;display:flex;align-items:center;gap:14px">
      <span style="font-size:20px">ℹ️</span>
      <p style="font-size:13px;color:var(--gray5);margin:0;line-height:1.6">
        Prices shown are <strong>starting fares</strong> for one-way trips. Final fare depends on car type, pickup point, and trip requirements — confirmed on call. Driver allowance and tolls may apply.
      </p>
    </div>
    @endif

  </div>
</section>

{{-- CTA --}}
<section class="cta-section">
  <div class="container">
    <div class="cta-section__inner">
      <h2 class="cta-section__title">Don't see your route?</h2>
      <p class="cta-section__desc">We cover all of North India. Call RK Shah directly and we'll give you an instant quote for any destination.</p>
      <div class="cta-section__btns">
        <a href="tel:+919324555165" class="btn btn--white btn--lg">📞 +91 93245 55165</a>
        <a href="https://wa.me/919324555165" class="btn btn--navy btn--lg" target="_blank" rel="noopener">💬 WhatsApp for Custom Route</a>
      </div>
    </div>
  </div>
</section>

@endsection
