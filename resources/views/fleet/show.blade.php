@extends('layouts.app')

@section('title', $car->name . ' on Rent Delhi — ₹' . $car->rate_per_km . '/km | Outstation Cab | RK Shah Car Rental')
@section('meta_description', 'Hire ' . $car->name . ' from Delhi for outstation trips. ' . $car->seats . ' seats, AC, GPS. Starting ₹' . $car->rate_per_km . '/km. Verified driver. Call +91 93245 55165.')

@section('og_title', $car->name . ' Car Rental Delhi — RK Shah')

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <a href="{{ route('fleet.index') }}">Our Fleet</a>
      <span class="breadcrumb__sep">›</span>
      <span class="breadcrumb__current">{{ $car->name }}</span>
    </nav>
    <span class="page-hero__eyebrow">{{ strtoupper($car->type) }}</span>
    <h1 class="page-hero__title">{{ $car->name }} <span>Rental Delhi</span></h1>
    <p class="page-hero__desc">{{ $car->description }}</p>
  </div>
</div>

{{-- Main content --}}
<section class="section section--light">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start">

      {{-- Left: Car visual --}}
      <div>
        <div class="fleet-card__img fleet-card__img--{{ $car->bg_class }}"
             style="height:300px;border-radius:var(--r3);margin-bottom:20px;overflow:hidden;position:relative">
          @if($car->featured_image)
            <img src="{{ asset('storage/'.$car->featured_image) }}"
                 alt="{{ $car->name }}"
                 style="width:100%;height:100%;object-fit:cover">
          @else
            <span style="font-size:120px" aria-hidden="true">{{ $car->emoji }}</span>
          @endif
        </div>

        {{-- Features list --}}
        <div style="background:var(--white);border-radius:var(--r2);border:1.5px solid var(--gray2);padding:20px">
          <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--navy3);text-transform:uppercase;letter-spacing:.5px;margin-bottom:14px">Included in every trip</div>
          <div style="display:flex;flex-wrap:wrap;gap:8px">
            @foreach($car->features ?? [] as $feature)
            <span style="display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:var(--gray1);border-radius:20px;font-size:12px;font-weight:600;color:var(--navy3)">
              ✓ {{ $feature }}
            </span>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Right: Details + Booking --}}
      <div>

        {{-- Pricing header (middle path — no exact price) --}}
        <div style="margin-bottom:8px">
          <span style="font-size:11px;color:var(--gray4);font-family:var(--ff-h);text-transform:uppercase;letter-spacing:.5px">Starting rate</span>
        </div>
        <div style="display:flex;align-items:baseline;gap:6px;margin-bottom:6px">
          <span style="font-family:var(--ff-h);font-size:2.2rem;font-weight:900;color:var(--navy3)">₹{{ $car->rate_per_km }}</span>
          <span style="font-size:14px;color:var(--gray4)">/km one-way</span>
        </div>
        <div style="font-size:12px;color:var(--gray4);margin-bottom:24px">
          + Driver allowance ₹{{ number_format($car->driver_allowance) }}/day · Min {{ number_format($car->min_km) }} km · Final fare confirmed on call
        </div>

        {{-- Spec grid --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px">
          @foreach([
            ['🪑', 'Seating',    $car->seats . ' Passengers'],
            ['🧳', 'Luggage',    $car->luggage ?? 'Ample space'],
            ['⛽', 'Fuel Type',  $car->fuel],
            ['📅', 'Model Year', $car->model_year],
            ['🚀', 'Min Distance', number_format($car->min_km) . ' km'],
            ['💰', 'Driver DA',  '₹' . number_format($car->driver_allowance) . '/day'],
          ] as $spec)
          <div style="background:var(--white);border:1.5px solid var(--gray2);border-radius:var(--r);padding:14px">
            <div style="font-size:20px;margin-bottom:6px">{{ $spec[0] }}</div>
            <div style="font-size:10px;color:var(--gray4);font-family:var(--ff-h);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px">{{ $spec[1] }}</div>
            <div style="font-size:13px;font-weight:600;color:var(--navy3);font-family:var(--ff-h)">{{ $spec[2] }}</div>
          </div>
          @endforeach
        </div>

        {{-- Best for --}}
        <div style="background:var(--gold-dim);border:1px solid var(--gold-mid);border-radius:var(--r2);padding:16px;margin-bottom:24px">
          <div style="font-size:10px;font-family:var(--ff-h);font-weight:700;color:var(--gray5);text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px">Best for</div>
          <div style="font-size:14px;font-weight:600;color:var(--navy3)">{{ $car->best_for }}</div>
        </div>

        {{-- CTA --}}
        <div style="display:flex;flex-direction:column;gap:10px">
          <button class="btn btn--gold btn--lg btn--full" onclick="openBookingModal()">
            📞 Book {{ $car->name }} Now
          </button>
          <a href="tel:+919324555165" class="btn btn--navy btn--full">
            📱 Call: +91 93245 55165
          </a>
          <a href="https://wa.me/919324555165?text={{ urlencode('Hi! I want to book a '.$car->name.' from Delhi.') }}"
             class="btn btn--outline btn--full" target="_blank" rel="noopener">
            💬 WhatsApp for Instant Quote
          </a>
        </div>

      </div>
    </div>

    {{-- Routes available for this car --}}
    @if($routes->count() > 0)
    <div style="margin-top:52px">
      <h2 style="font-family:var(--ff-h);font-size:1.4rem;font-weight:900;color:var(--navy3);margin-bottom:6px">
        Popular routes in {{ $car->name }}
      </h2>
      <p style="font-size:14px;color:var(--gray4);margin-bottom:24px">
        Starting fares from Delhi — final price confirmed on call
      </p>
      <div class="routes-list" style="background:var(--navy3);border-radius:var(--r3);padding:20px">
        @foreach($routes as $route)
        <div class="route-card" style="margin-bottom:10px">
          <div class="route-card__stripe" style="background:{{ $route->accent_color }}"></div>
          <div class="route-card__body">
            <div class="route-card__header">
              <div class="route-card__name">{{ $route->from_city }} <span class="route-card__arrow">→</span> {{ $route->to_city }}</div>
            </div>
            <div class="route-card__meta">{{ $route->distance_km }} km · ~{{ $route->duration_hrs }} hrs · {{ $route->highlight }}</div>
          </div>
          <div class="route-card__pricing" style="border-color:rgba(255,255,255,.08)">
            <div class="route-card__from">Starting</div>
            @php $fareKey = 'price_'.$car->fare_key; @endphp
            <div class="route-card__price">
              {{ $route->{$fareKey} ? '₹'.number_format($route->{$fareKey}) : 'Get Quote' }}
            </div>
            <div class="route-card__unit">one way</div>
            <button class="btn btn--gold btn--sm" onclick="openBookingModal()">Book</button>
          </div>
        </div>
        @endforeach
      </div>
      <div style="text-align:center;margin-top:16px">
        <a href="{{ route('routes.index') }}" class="btn btn--navy">🗺️ View All Routes →</a>
      </div>
    </div>
    @endif

    {{-- Other cars --}}
    @if($otherCars->count() > 0)
    <div style="margin-top:52px">
      <h2 style="font-family:var(--ff-h);font-size:1.4rem;font-weight:900;color:var(--navy3);margin-bottom:6px">Also consider</h2>
      <p style="font-size:14px;color:var(--gray4);margin-bottom:24px">Other vehicles in our fleet</p>
      <div class="grid grid--3">
        @foreach($otherCars as $other)
        <div class="fleet-card">
          <div class="fleet-card__img fleet-card__img--{{ $other->bg_class }}" style="height:130px;overflow:hidden;position:relative">
            @if($other->badge)
              <span class="fleet-card__badge">{{ $other->badge }}</span>
            @endif
            @if($other->featured_image)
              <img src="{{ asset('storage/'.$other->featured_image) }}"
                   alt="{{ $other->name }}"
                   style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">
            @else
              <span class="fleet-card__emoji" aria-hidden="true">{{ $other->emoji }}</span>
            @endif
          </div>
          <div class="fleet-card__body">
            <h3 class="fleet-card__name">{{ $other->name }}</h3>
            <div class="fleet-card__type">{{ $other->type }} · {{ $other->seats }} seats</div>
            <div class="fleet-card__price" style="margin:10px 0">
              <span class="fleet-card__price-num">₹{{ $other->rate_per_km }}</span>
              <span class="fleet-card__price-unit">/km</span>
            </div>
            <a href="{{ route('fleet.show', $other->slug) }}" class="btn btn--outline btn--full btn--sm">View Details</a>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</section>

@endsection
