@extends('layouts.app')

@section('title', 'Contact RK Shah Car Rental — Book Your Cab Today')
@section('meta_description', 'Contact RK Shah Car Rental for outstation cab booking from Delhi. Call +91 93245 55165 or WhatsApp for instant quote. Available 6 AM to 11 PM daily.')

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <span class="breadcrumb__current">Contact</span>
    </nav>
    <span class="page-hero__eyebrow">Contact Us</span>
    <h1 class="page-hero__title">Let's Plan Your <span>Journey</span></h1>
    <p class="page-hero__desc">Reach out by call, WhatsApp, or form — we respond within 5 minutes.</p>
  </div>
</div>

<section class="section section--light">
  <div class="container">
    <div style="display:grid;grid-template-columns:1.3fr 1fr;gap:40px;align-items:start">

      {{-- Contact Form --}}
      <div style="background:var(--white);border-radius:var(--r3);padding:36px;box-shadow:var(--shadow)">
        <h2 style="font-family:var(--ff-h);font-size:1.2rem;font-weight:800;color:var(--navy3);margin-bottom:4px">
          Send Us a Message
        </h2>
        <p style="font-size:13px;color:var(--gray4);margin-bottom:24px">
          Fill the form and we will call you back within 10 minutes.
        </p>

        {{-- Success / info flash --}}
        @if(session('booking_info'))
        <div style="background:#d1fae5;border:1px solid #6ee7b7;border-radius:var(--r);padding:14px;margin-bottom:16px;color:#065f46;font-family:var(--ff-h);font-size:13px;font-weight:600">
          ✅ {{ session('booking_info') }}
        </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
        <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:var(--r);padding:14px;margin-bottom:16px;color:#991b1b;font-size:13px">
          <div style="font-weight:700;font-family:var(--ff-h);margin-bottom:6px">Please fix the following:</div>
          @foreach($errors->all() as $error)
          <div>• {{ $error }}</div>
          @endforeach
        </div>
        @endif

        <form action="{{ route('lead.store') }}" method="POST">
          @csrf
          <input type="hidden" name="source" value="website">

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Your Name *</label>
              <input class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                     type="text" name="name"
                     value="{{ old('name') }}"
                     placeholder="Rajesh Sharma" required>
            </div>
            <div class="form-group">
              <label class="form-label">Phone Number *</label>
              <input class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
                     type="tel" name="phone"
                     value="{{ old('phone') }}"
                     placeholder="98765 43210"
                     pattern="[6-9][0-9]{9}" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">From City *</label>
              <input class="form-input"
                     type="text" name="from_city"
                     value="{{ old('from_city', 'Delhi') }}" required>
            </div>
            <div class="form-group">
              <label class="form-label">To City *</label>
              <input class="form-input"
                     type="text" name="to_city"
                     value="{{ old('to_city') }}"
                     placeholder="Agra, Jaipur, Manali..." required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label">Travel Date</label>
              <input class="form-input" type="date" name="travel_date"
                     value="{{ old('travel_date') }}">
            </div>
            <div class="form-group">
              <label class="form-label">Car Type</label>
              <select class="form-select" name="car_type">
                <option value="any"    {{ old('car_type')==='any'    ? 'selected' : '' }}>Any Available</option>
                <option value="dzire"  {{ old('car_type')==='dzire'  ? 'selected' : '' }}>Swift Dzire (4 seats)</option>
                <option value="ertiga" {{ old('car_type')==='ertiga' ? 'selected' : '' }}>Ertiga (7 seats)</option>
                <option value="creta"  {{ old('car_type')==='creta'  ? 'selected' : '' }}>Kia Creta (5 seats)</option>
                <option value="innova" {{ old('car_type')==='innova' ? 'selected' : '' }}>Innova Crysta (7 seats)</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label">Message / Special Requirements</label>
            <textarea class="form-textarea" name="message" rows="3"
                      placeholder="Number of passengers, stops en route, any special requirements...">{{ old('message') }}</textarea>
          </div>

          <button type="submit" class="btn btn--gold btn--full btn--lg">
            📤 Send Booking Enquiry
          </button>

          <p style="text-align:center;font-size:11px;color:var(--gray4);margin-top:10px">
            No advance needed for enquiry · We call you within 5 minutes
          </p>
        </form>
      </div>

      {{-- Contact Info --}}
      <div style="display:flex;flex-direction:column;gap:14px">

        @foreach([
          ['📞', 'Call / WhatsApp',     $phone,   'Available ' . $hours,       'tel:+919324555165'],
          ['✉️', 'Email',               $email,   'Reply within 2 hours',       'mailto:'.$email],
          ['📍', 'Our Address',         $address, 'Soniya Vihar, North-East Delhi', null],
          ['⏰', 'Working Hours',        $hours,   'All days including holidays', null],
        ] as $info)
        <div style="background:var(--white);border-radius:var(--r2);padding:22px;border:1.5px solid var(--gray2);transition:all .2s"
             onmouseover="this.style.borderColor='var(--gold)'"
             onmouseout="this.style.borderColor='var(--gray2)'">
          <div style="font-size:26px;margin-bottom:10px">{{ $info[0] }}</div>
          <div style="font-family:var(--ff-h);font-size:.9rem;font-weight:700;color:var(--navy3);margin-bottom:4px">
            {{ $info[1] }}
          </div>
          @if($info[4])
          <a href="{{ $info[4] }}" style="font-size:15px;font-weight:600;color:var(--navy);display:block;margin-bottom:2px">
            {{ $info[2] }}
          </a>
          @else
          <div style="font-size:14px;font-weight:600;color:var(--navy);margin-bottom:2px">{{ $info[2] }}</div>
          @endif
          <div style="font-size:12px;color:var(--gray4)">{{ $info[3] }}</div>
        </div>
        @endforeach

        {{-- WhatsApp quick link --}}
        <a href="https://wa.me/919324555165"
           target="_blank" rel="noopener"
           style="display:flex;align-items:center;gap:14px;background:#25D366;border-radius:var(--r2);padding:18px;text-decoration:none;transition:all .2s"
           onmouseover="this.style.opacity='.9'"
           onmouseout="this.style.opacity='1'">
          <span style="font-size:28px">💬</span>
          <div>
            <div style="font-family:var(--ff-h);font-size:.95rem;font-weight:800;color:white">Chat on WhatsApp</div>
            <div style="font-size:12px;color:rgba(255,255,255,.8);margin-top:2px">Fastest response — typically within 2 minutes</div>
          </div>
        </a>

      </div>
    </div>
  </div>
</section>

{{-- Google Maps section --}}
<section style="background:var(--navy3);padding:50px 0">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:center">
      <div>
        <h2 style="font-family:var(--ff-h);font-size:1.4rem;font-weight:900;color:white;margin-bottom:12px">
          We serve all of Delhi NCR
        </h2>
        <p style="font-size:14px;color:rgba(255,255,255,.55);line-height:1.75;margin-bottom:20px">
          Pickup available from anywhere in Delhi, Noida, Gurgaon, Faridabad, and Ghaziabad.
          No extra charge for pickups within 20 km of Central Delhi.
        </p>
        <div style="display:flex;flex-direction:column;gap:8px">
          @foreach(['Delhi (all areas)','Noida & Greater Noida','Gurgaon & Manesar','Faridabad','Ghaziabad & Indirapuram'] as $area)
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:rgba(255,255,255,.7)">
            <span style="color:var(--gold);font-weight:700">✓</span>
            {{ $area }}
          </div>
          @endforeach
        </div>
      </div>
      <div>
        <div style="display:flex;flex-direction:column;gap:12px">
          @foreach([
            ['🌅', 'Early morning pickups', 'Starting from 4 AM for flights and trains'],
            ['🌙', 'Late night available',   'Up to 11 PM — just inform us in advance'],
            ['✈️', 'Airport specialists',   'IGI T1, T2, T3 — all terminals covered'],
            ['🚉', 'Railway stations',      'New Delhi, Hazrat Nizamuddin, Anand Vihar'],
          ] as $service)
          <div style="display:flex;align-items:flex-start;gap:12px;padding:14px;background:rgba(255,255,255,.05);border-radius:var(--r2)">
            <span style="font-size:20px;flex-shrink:0">{{ $service[0] }}</span>
            <div>
              <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:white;margin-bottom:2px">{{ $service[1] }}</div>
              <div style="font-size:12px;color:rgba(255,255,255,.45)">{{ $service[2] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
