@extends('layouts.app')

@section('title', 'Plan Your Custom Trip — RK Shah Car Rental Delhi')
@section('meta_description', 'Plan a custom outstation trip from Delhi. Any destination, any duration, your budget. Tell us your requirements and get an instant quote. Call +91 93245 55165.')

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <a href="{{ route('packages.index') }}">Packages</a>
      <span class="breadcrumb__sep">›</span>
      <span class="breadcrumb__current">Custom Trip</span>
    </nav>
    <span class="page-hero__eyebrow">Build Your Own</span>
    <h1 class="page-hero__title">Plan Your <span>Custom Trip</span></h1>
    <p class="page-hero__desc">
      Any destination. Any duration. Your budget. Tell us what you have in mind
      and we'll build the perfect itinerary with the right car and driver.
    </p>
  </div>
</div>

<section class="section section--light">
  <div class="container">
    <div style="display:grid;grid-template-columns:3fr 2fr;gap:48px;align-items:start">

      {{-- Form --}}
      <div>
        <div style="background:var(--white);border-radius:var(--r3);padding:36px;box-shadow:var(--shadow)">
          <h2 style="font-family:var(--ff-h);font-size:1.1rem;font-weight:800;color:var(--navy3);margin-bottom:6px">
            Tell us about your trip
          </h2>
          <p style="font-size:13px;color:var(--gray4);margin-bottom:24px">
            We'll call you within 5 minutes with a custom quote.
          </p>

          @if(session('booking_info'))
          <div style="background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.3);border-radius:var(--r);padding:12px 14px;margin-bottom:16px;font-size:13px;color:#059669;font-family:var(--ff-h);font-weight:600">
            ✅ {{ session('booking_info') }}
          </div>
          @endif

          @if($errors->any())
          <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);border-radius:var(--r);padding:12px 14px;margin-bottom:16px;font-size:13px;color:#ef4444">
            <div style="font-weight:700;margin-bottom:4px">Please fix:</div>
            @foreach($errors->all() as $error)
              <div>• {{ $error }}</div>
            @endforeach
          </div>
          @endif

          <form action="{{ route('lead.store') }}" method="POST">
            @csrf
            <input type="hidden" name="from_city" value="Delhi">
            <input type="hidden" name="source"    value="website">
            <input type="hidden" name="trip_type" value="one_way">

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Your Name *</label>
                <input class="form-input" type="text" name="name"
                       value="{{ old('name') }}" required
                       placeholder="Rajesh Sharma">
              </div>
              <div class="form-group">
                <label class="form-label">Phone Number *</label>
                <input class="form-input" type="tel" name="phone"
                       value="{{ old('phone') }}" required
                       placeholder="98765 43210" pattern="[6-9][0-9]{9}">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Where do you want to go? *</label>
              <input class="form-input" type="text" name="to_city"
                     value="{{ old('to_city') }}" required
                     placeholder="E.g. Rajasthan tour, Manali, Char Dham...">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Travel Date</label>
                <input class="form-input" type="date" name="travel_date"
                       value="{{ old('travel_date') }}">
              </div>
              <div class="form-group">
                <label class="form-label">Car Preference</label>
                <select class="form-select" name="car_type">
                  <option value="any"    {{ old('car_type')==='any'    ? 'selected' : '' }}>No preference (suggest best)</option>
                  <option value="dzire"  {{ old('car_type')==='dzire'  ? 'selected' : '' }}>Swift Dzire (budget)</option>
                  <option value="ertiga" {{ old('car_type')==='ertiga' ? 'selected' : '' }}>Ertiga (7 seats)</option>
                  <option value="creta"  {{ old('car_type')==='creta'  ? 'selected' : '' }}>Kia Creta (comfort)</option>
                  <option value="innova" {{ old('car_type')==='innova' ? 'selected' : '' }}>Innova Crysta (premium)</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Number of People</label>
                <select class="form-select" name="passengers">
                  <option value="any">1–4 people</option>
                  <option value="7">5–7 people</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Trip Duration</label>
                <select class="form-select" name="trip_type">
                  <option value="one_way">Day trip (1 day)</option>
                  <option value="round_trip">Weekend (2–3 days)</option>
                  <option value="hourly">Long trip (4+ days)</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Trip Details & Requirements</label>
              <textarea class="form-textarea" name="message" rows="4"
                        placeholder="Describe your trip — places to visit, any special requirements, rough budget per person, number of days...">{{ old('message') }}</textarea>
            </div>

            <button type="submit" class="btn btn--gold btn--full btn--lg">
              📤 Send Custom Trip Request
            </button>

            <p style="font-size:11px;color:var(--gray4);text-align:center;margin-top:10px">
              RK Shah will call you within 5 minutes. No advance needed for enquiry.
            </p>
          </form>
        </div>
      </div>

      {{-- Sidebar info --}}
      <div style="display:flex;flex-direction:column;gap:16px">

        <div style="background:var(--navy3);border-radius:var(--r2);padding:24px">
          <div style="font-family:var(--ff-h);font-size:.9rem;font-weight:700;color:var(--gold);margin-bottom:16px">
            What happens after you submit?
          </div>
          @foreach([
            ['📞', 'RK Shah calls within 5 minutes',       'On your registered number'],
            ['💬', 'Route & itinerary discussion',          'Customised to your needs'],
            ['💰', 'Transparent quote shared',              'Starting fare confirmed on call'],
            ['✅', 'Booking confirmed with small advance',  'Via UPI, cash, or bank transfer'],
          ] as $step)
          <div style="display:flex;gap:12px;margin-bottom:14px">
            <span style="font-size:18px;flex-shrink:0">{{ $step[0] }}</span>
            <div>
              <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:white;margin-bottom:2px">{{ $step[1] }}</div>
              <div style="font-size:11px;color:rgba(255,255,255,.45)">{{ $step[2] }}</div>
            </div>
          </div>
          @endforeach
        </div>

        <div style="background:var(--white);border:1.5px solid var(--gray2);border-radius:var(--r2);padding:20px">
          <div style="font-family:var(--ff-h);font-size:.85rem;font-weight:700;color:var(--navy3);margin-bottom:14px">
            Or reach us directly
          </div>
          <a href="tel:+919324555165"
             style="display:flex;align-items:center;gap:10px;padding:12px;background:var(--gray1);border-radius:var(--r);margin-bottom:8px;text-decoration:none">
            <span style="font-size:18px">📞</span>
            <div>
              <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--navy3)">Call RK Shah</div>
              <div style="font-size:12px;color:var(--gray4)">+91 93245 55165</div>
            </div>
          </a>
          <a href="https://wa.me/919324555165" target="_blank" rel="noopener"
             style="display:flex;align-items:center;gap:10px;padding:12px;background:#f0fdf4;border-radius:var(--r);text-decoration:none">
            <span style="font-size:18px">💬</span>
            <div>
              <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:#059669">WhatsApp</div>
              <div style="font-size:12px;color:var(--gray4)">Instant reply</div>
            </div>
          </a>
        </div>

        <div style="background:var(--gold-dim);border:1px solid var(--gold-mid);border-radius:var(--r2);padding:18px">
          <div style="font-family:var(--ff-h);font-size:.85rem;font-weight:700;color:var(--navy3);margin-bottom:10px">
            Popular custom trips
          </div>
          @foreach([
            'Golden Triangle (Delhi–Agra–Jaipur)',
            'Himachal Circuit (Shimla–Manali)',
            'Char Dham Yatra (Uttarakhand)',
            'Rajasthan Royal Tour (5–7 days)',
            'Amritsar + Wagah Border',
          ] as $trip)
          <div style="font-size:12px;color:var(--gray5);padding:5px 0;border-bottom:1px solid rgba(212,160,23,.15);display:flex;align-items:center;gap:6px">
            <span style="color:var(--gold);font-weight:700">→</span> {{ $trip }}
          </div>
          @endforeach
        </div>

      </div>
    </div>
  </div>
</section>

@endsection
