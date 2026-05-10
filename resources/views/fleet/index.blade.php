@extends('layouts.app')

@section('title', 'Our Fleet — AC Cars for Every Journey | RK Shah Car Rental')
@section('meta_description', 'Book Innova Crysta, Kia Creta, Ertiga or Swift Dzire from Delhi. AC, GPS-tracked, verified drivers. Starting ₹' . $rateFrom . '/km. Call +91 93245 55165.')

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <span class="breadcrumb__current">Our Fleet</span>
    </nav>
    <span class="page-hero__eyebrow">Our Fleet</span>
    <h1 class="page-hero__title">Premium <span>Well-Maintained</span> Vehicles</h1>
    <p class="page-hero__desc">Every car is AC, GPS-tracked, sanitized before each trip, and driven by a verified professional. All prices are starting rates — final fare confirmed on call.</p>
  </div>
</div>

{{-- Fleet Grid --}}
<section class="section section--light">
  <div class="container">
    <div class="grid grid--2" style="gap:28px">

      @forelse($cars as $car)
      <div class="fleet-card fleet-card--full">

        {{-- Car image / emoji --}}
        <div class="fleet-card__img fleet-card__img--{{ $car->bg_class }}" style="height:250px">
          @if($car->badge)
            <span class="fleet-card__badge">{{ $car->badge }}</span>
          @endif
          @if($car->featured_image)
            <img src="{{ asset('storage/'.$car->featured_image) }}"
                 alt="{{ $car->name }}"
                 style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">
          @else
            <span class="fleet-card__emoji" style="font-size:96px" aria-hidden="true">{{ $car->emoji }}</span>
          @endif
        </div>

        <div class="fleet-card__body" style="padding:24px">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

            {{-- Left: specs --}}
            <div>
              <h2 class="fleet-card__name" style="font-size:1.3rem;margin-bottom:4px">{{ $car->name }}</h2>
              <div class="fleet-card__type">{{ strtoupper($car->type) }}</div>

              {{-- Spec grid --}}
              <div style="margin:14px 0;display:grid;grid-template-columns:1fr 1fr;gap:8px">
                @foreach([
                  ['Capacity', $car->seats . ' Passengers'],
                  ['Luggage',  $car->luggage],
                  ['Fuel',     $car->fuel],
                  ['Min KM',   number_format($car->min_km) . ' km'],
                ] as $spec)
                <div style="background:var(--gray1);border-radius:var(--r);padding:10px 12px">
                  <div style="font-size:10px;color:var(--gray4);font-family:var(--ff-h);letter-spacing:.5px;margin-bottom:2px;text-transform:uppercase">{{ $spec[0] }}</div>
                  <div style="font-size:13px;font-weight:600;color:var(--navy3);font-family:var(--ff-h)">{{ $spec[1] }}</div>
                </div>
                @endforeach
              </div>

              {{-- Features --}}
              <div class="fleet-card__specs">
                @foreach($car->features ?? [] as $feature)
                  <span class="fleet-card__spec">{{ $feature }}</span>
                @endforeach
              </div>
            </div>

            {{-- Right: pricing + CTA --}}
            <div style="display:flex;flex-direction:column;justify-content:space-between">
              <div>
                <div style="font-size:10px;color:var(--gray4);font-family:var(--ff-h);letter-spacing:.5px;margin-bottom:6px;text-transform:uppercase">Starting Fare</div>

                <div class="fleet-card__price" style="margin-bottom:4px">
                  <span class="fleet-card__price-num">₹{{ $car->rate_per_km }}</span>
                  <span class="fleet-card__price-unit">/km onwards</span>
                </div>
                <div style="font-size:11px;color:var(--gray4);margin-bottom:4px">+ Driver allowance ₹{{ number_format($car->driver_allowance) }}/day</div>
                <div style="font-size:11px;color:var(--gray4);margin-bottom:16px">Min {{ number_format($car->min_km) }} km · Final price on call</div>

                {{-- Best for --}}
                <div style="background:var(--gold-dim);border:1px solid var(--gold-mid);border-radius:var(--r);padding:12px;margin-bottom:16px">
                  <div style="font-size:10px;font-family:var(--ff-h);color:var(--gray5);margin-bottom:4px;text-transform:uppercase">Best For</div>
                  <div style="font-size:13px;font-weight:600;color:var(--navy3)">{{ $car->best_for }}</div>
                </div>
              </div>

              <div style="display:flex;flex-direction:column;gap:8px">
                <button class="btn btn--gold btn--full" onclick="openBookingModal()">
                  📞 Book {{ $car->name }}
                </button>
                <a href="{{ route('fleet.show', $car->slug) }}" class="btn btn--outline btn--full btn--sm">
                  View Full Details →
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:48px;color:var(--gray4)">
        <p>No vehicles available at the moment. Please call us directly.</p>
        <a href="tel:+919324555165" class="btn btn--gold" style="margin-top:16px">📞 +91 93245 55165</a>
      </div>
      @endforelse

    </div>

    {{-- Comparison note --}}
    <div style="margin-top:40px;background:var(--white);border-radius:var(--r3);border:1.5px solid var(--gray2);padding:28px">
      <h2 style="font-family:var(--ff-h);font-size:1.1rem;font-weight:800;color:var(--navy3);margin-bottom:16px">Which car should I choose?</h2>
      <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px">
        @foreach([
          ['Travelling solo or as a couple',   'Swift Dzire — most economical'],
          ['Small family trip (3–4 people)',    'Kia Creta — comfortable & stylish'],
          ['Large family or group (5–7)',       'Innova Crysta or Ertiga'],
          ['Budget-conscious group of 7',      'Ertiga — CNG, great mileage'],
          ['Long hill station trip (Manali)',   'Innova Crysta — most reliable on mountain roads'],
          ['Airport pickup/drop',              'Swift Dzire — quick and affordable'],
        ] as $tip)
        <div style="display:flex;gap:10px;align-items:flex-start;padding:12px;background:var(--gray1);border-radius:var(--r)">
          <span style="color:var(--gold);font-weight:700;flex-shrink:0">→</span>
          <div>
            <div style="font-size:12px;color:var(--gray5);margin-bottom:2px">{{ $tip[0] }}</div>
            <div style="font-size:13px;font-weight:600;color:var(--navy3);font-family:var(--ff-h)">{{ $tip[1] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

  </div>
</section>

{{-- CTA --}}
<section class="cta-section">
  <div class="container">
    <div class="cta-section__inner">
      <h2 class="cta-section__title">Not sure which car to pick?</h2>
      <p class="cta-section__desc">Call RK Shah — describe your trip and we will recommend the best car for your needs and budget.</p>
      <div class="cta-section__btns">
        <a href="tel:+919324555165" class="btn btn--white btn--lg">📞 Call: +91 93245 55165</a>
        <a href="https://wa.me/919324555165" class="btn btn--navy btn--lg" target="_blank" rel="noopener">💬 WhatsApp Us</a>
      </div>
    </div>
  </div>
</section>

@endsection
