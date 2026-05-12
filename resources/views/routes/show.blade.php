@extends('layouts.app')

@section('title', $route->from_city . ' to ' . $route->to_city . ' Cab — Starting ₹' . ($route->min_price ? number_format($route->min_price) : 'Get Quote') . ' | RK Shah Car Rental Delhi') : 'Get Quote') . ' | RK Shah Car Rental')
@section('meta_description', 'Book cab from ' . $route->from_city . ' to ' . $route->to_city . ($route->distance_km > 0 ? ' — ' . $route->distance_km . ' km, ~' . $route->duration_hrs . ' hrs' : '') . '. AC car, GPS tracked, verified driver. ' . ($route->highlight ?? '') . '. All tolls included. Call +91 93245 55165.') . 'AC cars, verified drivers. Call +91 93245 55165.')

@section('meta_keywords', 'Delhi to ' . $route->to_city . ' cab, Delhi ' . $route->to_city . ' taxi fare, ' . $route->to_city . ' trip from Delhi cab, Delhi to ' . $route->to_city . ' one way taxi')
@section('og_title', $route->from_city . ' to ' . $route->to_city . ' Cab | RK Shah Car Rental')

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <a href="{{ route('routes.index') }}">Routes</a>
      <span class="breadcrumb__sep">›</span>
      @if($route->tag)
      <a href="{{ route('routes.index', ['tag' => $route->tag]) }}">{{ $route->tag }}</a>
      <span class="breadcrumb__sep">›</span>
      @endif
      <span class="breadcrumb__current">{{ $route->from_city }} → {{ $route->to_city }}</span>
    </nav>

    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
      @if($route->tag)
      <span class="eyebrow">{{ $route->tag }}</span>
      @endif
    </div>

    <h1 class="page-hero__title">
      {{ $route->from_city }} to <span>{{ $route->to_city }}</span> Cab
    </h1>
    <p class="page-hero__desc">
      @if($route->distance_km > 0)
        {{ $route->distance_km }} km · ~{{ $route->duration_hrs }} hrs ·
      @endif
      {{ $route->highway }}
      @if($route->highlight)
        · {{ $route->highlight }}
      @endif
    </p>
  </div>
</div>

<section class="section section--light">
  <div class="container" style="max-width:920px">

    {{-- Route hero image if uploaded --}}
    @if($route->featured_image)
    <div style="border-radius:var(--r3);overflow:hidden;margin-bottom:28px;height:280px">
      <img src="{{ asset('storage/'.$route->featured_image) }}"
           alt="{{ $route->from_city }} to {{ $route->to_city }}"
           style="width:100%;height:100%;object-fit:cover">
    </div>
    @endif

    {{-- Per-car pricing cards (middle path) --}}
    <div style="margin-bottom:32px">
      <h2 style="font-family:var(--ff-h);font-size:1.1rem;font-weight:800;color:var(--navy3);margin-bottom:6px">
        Starting fares — {{ $route->from_city }} to {{ $route->to_city }}
      </h2>
      <p style="font-size:13px;color:var(--gray4);margin-bottom:20px">
        One-way · Inclusive of driver allowance · Final fare confirmed on call
      </p>

      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px">
        @foreach([
          ['Swift Dzire',   $route->price_dzire,  '🚕', 4],
          ['Ertiga',        $route->price_ertiga, '🚐', 7],
          ['Kia Creta',     $route->price_creta,  '🚗', 5],
          ['Innova Crysta', $route->price_innova, '🚙', 7],
        ] as [$name, $price, $emoji, $seats])
        @if($price)
        <div style="background:var(--white);border:1.5px solid var(--gray2);border-radius:var(--r2);padding:20px;text-align:center;transition:all .2s"
             onmouseover="this.style.borderColor='var(--gold)';this.style.transform='translateY(-3px)'"
             onmouseout="this.style.borderColor='var(--gray2)';this.style.transform='translateY(0)'">
          <div style="font-size:32px;margin-bottom:8px">{{ $emoji }}</div>
          <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--navy3);margin-bottom:10px">{{ $name }}</div>
          <div style="font-size:11px;color:var(--gray4);margin-bottom:6px">{{ $seats }} seats · AC</div>
          <div style="font-size:10px;color:var(--gray4);margin-bottom:6px;font-style:italic">Starting</div>
          <div style="font-family:var(--ff-h);font-size:1.5rem;font-weight:900;color:var(--navy3);line-height:1;margin-bottom:4px">
            ₹{{ number_format($price) }}
          </div>
          <div style="font-size:10px;color:var(--gray4);margin-bottom:14px">one way</div>
          <button onclick="openBookingModal()"
                  class="btn btn--gold btn--sm btn--full">Book</button>
        </div>
        @endif
        @endforeach
      </div>

      {{-- Middle path note --}}
      <div style="margin-top:14px;background:var(--gold-dim);border:1px solid var(--gold-mid);border-radius:var(--r);padding:12px 16px;display:flex;align-items:center;gap:10px">
        <span style="font-size:16px">💡</span>
        <p style="font-size:12px;color:var(--gray6);margin:0;line-height:1.6">
          <strong>Pricing note:</strong> Fares shown are starting rates. Exact fare depends on pickup location, number of days, and any stops en route. RK Shah will confirm the final price on call before you pay anything.
        </p>
      </div>
    </div>

    {{-- Main CTA --}}
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:48px">
      <button onclick="openBookingModal()" class="btn btn--gold btn--lg">
        📞 Book This Route Now
      </button>
      <a href="https://wa.me/919324555165?text={{ urlencode('Hi! I need a cab from '.$route->from_city.' to '.$route->to_city.'. Please share the fare.') }}"
         class="btn btn--navy btn--lg" target="_blank" rel="noopener">
        💬 WhatsApp for Instant Quote
      </a>
    </div>

    {{-- Route info section --}}
    @if($route->distance_km > 0)
    <div style="background:var(--white);border:1.5px solid var(--gray2);border-radius:var(--r3);padding:28px;margin-bottom:32px">
      <h2 style="font-family:var(--ff-h);font-size:1.1rem;font-weight:800;color:var(--navy3);margin-bottom:20px">
        Route Information
      </h2>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px">
        @foreach([
          ['🛣️', 'Total Distance',   $route->distance_km . ' km'],
          ['⏱️', 'Travel Time',      '~' . $route->duration_hrs . ' hours'],
          ['🛤️', 'Highway Route',    $route->highway ?? '—'],
          ['✨', 'Known For',        $route->highlight ?? '—'],
        ] as $info)
        <div style="display:flex;align-items:flex-start;gap:12px;padding:14px;background:var(--gray1);border-radius:var(--r)">
          <span style="font-size:20px;flex-shrink:0">{{ $info[0] }}</span>
          <div>
            <div style="font-size:10px;color:var(--gray4);font-family:var(--ff-h);font-weight:600;text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">{{ $info[1] }}</div>
            <div style="font-size:13px;font-weight:600;color:var(--navy3)">{{ $info[2] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- Why book with RK Shah for this route --}}
    <div style="background:var(--navy3);border-radius:var(--r3);padding:28px;margin-bottom:40px">
      <h2 style="font-family:var(--ff-h);font-size:1rem;font-weight:800;color:white;margin-bottom:18px">
        Why choose RK Shah for {{ $route->from_city }} → {{ $route->to_city }}?
      </h2>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
        @foreach([
          ['✅', 'No hidden charges — fare confirmed before you pay'],
          ['🚗', 'AC cars, less than 3 years old'],
          ['👮', 'Police verified, experienced drivers'],
          ['📍', 'GPS tracked — share live location with family'],
          ['📞', 'Direct contact with RK Shah throughout'],
          ['🔄', 'Free cancellation up to 24 hours before trip'],
        ] as $point)
        <div style="display:flex;align-items:flex-start;gap:10px">
          <span style="font-size:16px;flex-shrink:0">{{ $point[0] }}</span>
          <span style="font-size:12px;color:rgba(255,255,255,.7);line-height:1.5">{{ $point[1] }}</span>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Related routes --}}
    @if($related->count() > 0)
    <div>
      <h2 style="font-family:var(--ff-h);font-size:1.2rem;font-weight:800;color:var(--navy3);margin-bottom:6px">
        Similar Routes
      </h2>
      <p style="font-size:13px;color:var(--gray4);margin-bottom:16px">
        Other popular {{ $route->tag }} destinations from Delhi
      </p>
      <div style="display:flex;flex-direction:column;gap:10px">
        @foreach($related as $r)
        <a href="{{ route('routes.show', $r->slug) }}"
           style="background:var(--white);border:1.5px solid var(--gray2);border-radius:var(--r2);padding:16px 20px;display:flex;align-items:center;justify-content:space-between;color:inherit;text-decoration:none;transition:all .2s"
           onmouseover="this.style.borderColor='var(--navy)';this.style.background='var(--gray1)'"
           onmouseout="this.style.borderColor='var(--gray2)';this.style.background='var(--white)'">
          <div>
            <div style="font-family:var(--ff-h);font-weight:700;color:var(--navy3);margin-bottom:2px">
              {{ $r->from_city }} → {{ $r->to_city }}
            </div>
            @if($r->distance_km > 0)
            <div style="font-size:12px;color:var(--gray4)">{{ $r->distance_km }} km · {{ $r->highlight }}</div>
            @endif
          </div>
          <div style="text-align:right;flex-shrink:0">
            <div style="font-family:var(--ff-h);font-weight:900;color:var(--gold);font-size:1.1rem">
              {{ $r->min_price ? '₹'.number_format($r->min_price).'+' : 'Get Quote' }}
            </div>
            <div style="font-size:11px;color:var(--gray4)">starting</div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</section>

@endsection
