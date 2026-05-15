@extends('layouts.app')

@section('title', "About RK Shah Car Rental — Delhi's Trusted Outstation Cab Owner Since 2022")
@section('meta_description', "Meet RK Shah — the owner and driver who personally handles every booking. Delhi outstation cab service since 2022 with 1,200+ trips, 4.9 Google rating, 180+ reviews. No middlemen, no hidden charges.")
@section('meta_keywords', "RK Shah Car Rental Delhi, trusted cab owner Delhi, outstation cab Delhi since 2022, reliable taxi Delhi, verified driver Delhi")
@section('og_title', "About RK Shah — Owner of Delhi's Most Trusted Outstation Cab Service")
@section('og_description', "Since 2022, RK Shah personally handles every booking. 1,200+ trips, 4.9 star rating. Delhi's most trusted outstation cab service.")

@section('content')

{{-- ═══ HERO ══════════════════════════════════════════════════ --}}
<div class="page-hero" style="min-height:70vh;display:flex;align-items:center;padding-bottom:0">
  <div class="container" style="width:100%">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <span class="breadcrumb__current">About Us</span>
    </nav>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center;padding:50px 0 60px">
      {{-- Left --}}
      <div>
        <span class="eyebrow">Our Story</span>
        <h1 class="page-hero__title" style="margin-top:12px;font-size:clamp(2rem,4vw,3.2rem)">
          Built on Trust.<br>
          <span>Driven by Passion.</span>
        </h1>
        <p style="font-size:16px;color:rgba(255,255,255,.65);line-height:1.8;margin:20px 0 28px;max-width:480px">
          Since 2022, RK Shah Car Rental has been the go-to outstation cab service for thousands of Delhi families. Not because of ads or algorithms — but because of one man's commitment to doing things right.
        </p>
        <div style="display:flex;gap:12px;flex-wrap:wrap">
          <a href="tel:+919324555165" class="btn btn--gold btn--lg">📞 Call RK Shah Directly</a>
          <a href="#our-story" class="btn btn--outline-white btn--lg">Read Our Story ↓</a>
        </div>
      </div>

      {{-- Right: stat cards --}}
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
        @foreach($stats as $s)
        <div style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);border-radius:var(--r2);padding:24px;text-align:center;backdrop-filter:blur(10px)">
          <div style="font-family:var(--ff-h);font-size:2.2rem;font-weight:900;color:var(--gold);line-height:1;margin-bottom:6px">
            {{ $s['value'] }}
          </div>
          <div style="font-size:12px;color:rgba(255,255,255,.5);font-family:var(--ff-h);letter-spacing:.5px">
            {{ $s['label'] }}
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- ═══ TRUST BAR ═════════════════════════════════════════════ --}}
<div style="background:var(--gold);padding:14px 0">
  <div class="container">
    <div style="display:flex;align-items:center;justify-content:center;gap:40px;flex-wrap:wrap">
      @foreach([
        '🏆 Google Verified Business',
        '⭐ 4.9 Star Rated',
        '👮 Police Verified Drivers',
        '🔒 GPS Tracked Fleet',
        '✅ 1,200+ Happy Trips',
      ] as $badge)
      <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:var(--navy3)">{{ $badge }}</div>
      @endforeach
    </div>
  </div>
</div>

{{-- ═══ OWNER SECTION ══════════════════════════════════════════ --}}
<section id="our-story" class="section section--white" style="scroll-margin-top:80px">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1.4fr;gap:64px;align-items:center">

      {{-- Owner card --}}
      <div>
        <div style="background:var(--navy3);border-radius:24px;padding:40px;text-align:center;position:relative;overflow:hidden">
          {{-- Decorative background pattern --}}
          <div style="position:absolute;inset:0;background-image:radial-gradient(circle at 80% 20%,rgba(212,160,23,.1) 0%,transparent 60%),radial-gradient(circle at 20% 80%,rgba(15,97,144,.3) 0%,transparent 60%)"></div>

          <div style="position:relative;z-index:1">
            {{-- Avatar --}}
            @if(!empty($ownerPhoto ?? ''))
            <img src="{{ asset('storage/'.($ownerPhoto ?? '')) }}"
                 alt="{{ $owner['name'] ?? 'RK Shah' }}"
                 style="width:110px;height:110px;border-radius:50%;object-fit:cover;margin:0 auto 18px;display:block;border:4px solid rgba(255,255,255,.15)">
            @else
            <div style="width:110px;height:110px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--gold2));display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-family:var(--ff-h);font-size:2.2rem;font-weight:900;color:var(--navy3);border:4px solid rgba(255,255,255,.15)">
              RK
            </div>
            @endif

            <div style="font-family:var(--ff-h);font-size:1.3rem;font-weight:900;color:white;margin-bottom:4px">
              RK Shah
            </div>
            <div style="font-size:13px;color:var(--gold);font-family:var(--ff-h);font-weight:600;margin-bottom:6px">
              Founder & Owner
            </div>
            <div style="font-size:12px;color:rgba(255,255,255,.45);margin-bottom:24px">
              Soniya Vihar, Delhi · Since 2022
            </div>

            {{-- Quote --}}
            <div style="background:rgba(255,255,255,.06);border-radius:var(--r2);padding:18px;border:1px solid rgba(255,255,255,.08);margin-bottom:24px;text-align:left">
              <div style="color:var(--gold);font-size:24px;font-family:var(--ff-h);line-height:1;margin-bottom:6px">"</div>
              <p style="font-size:13px;color:rgba(255,255,255,.7);line-height:1.75;font-style:italic">
                {{ $owner['quote'] ?? 'When you book with me, you are not a ticket number in a system.' }}
              </p>
              <div style="text-align:right;font-size:12px;color:rgba(255,255,255,.4);margin-top:8px;font-family:var(--ff-h);font-weight:600">— RK Shah</div>
            </div>

            {{-- Contact buttons --}}
            <div style="display:flex;flex-direction:column;gap:8px">
              <a href="tel:+919324555165"
                 style="display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;background:var(--gold);border-radius:var(--r2);font-family:var(--ff-h);font-size:13px;font-weight:800;color:var(--navy3);text-decoration:none">
                📞 +91 93245 55165
              </a>
              <a href="https://wa.me/919324555165" target="_blank" rel="noopener"
                 style="display:flex;align-items:center;justify-content:center;gap:8px;padding:12px;background:rgba(37,211,102,.15);border:1px solid rgba(37,211,102,.3);border-radius:var(--r2);font-family:var(--ff-h);font-size:13px;font-weight:700;color:#25D366;text-decoration:none">
                💬 Chat on WhatsApp
              </a>
            </div>

            {{-- Badges --}}
            <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;margin-top:18px">
              @foreach(['Direct Contact','No Middlemen','Owner Operated'] as $badge)
              <span style="background:rgba(212,160,23,.15);border:1px solid rgba(212,160,23,.25);border-radius:20px;padding:4px 12px;font-size:11px;font-weight:600;color:var(--gold);font-family:var(--ff-h)">
                ✓ {{ $badge }}
              </span>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      {{-- Story text --}}
      <div>
        <span class="eyebrow">The Person Behind Every Trip</span>
        <h2 style="font-family:var(--ff-h);font-size:2rem;font-weight:900;color:var(--navy3);margin:12px 0 20px;line-height:1.2">
          Not a company. A commitment.
        </h2>

        <div style="font-size:15px;line-height:1.85;color:var(--gray5)">
          <p style="margin-bottom:16px">
            RK Shah started this business in 2022 with a single car and a simple principle: treat every passenger the way you would want your own family to be treated. No shortcuts, no false promises, no hidden charges.
          </p>
          <p style="margin-bottom:16px">
            In the early days, RK Shah drove every trip himself. He learned every highway, every shortcut, every good dhaba on the Yamuna Expressway, every viewpoint on the Manali road. That first-hand knowledge is what he passes on to every driver he works with today.
          </p>
          <p style="margin-bottom:16px">
            Today the fleet has grown to four well-maintained cars — Innova Crysta, Kia Creta, Ertiga, and Swift Dzire. But the philosophy has not changed. RK Shah personally handles every booking. When you call the number on this website, you speak to the owner, not a call centre agent.
          </p>
          <p>
            That is why 96% of new customers come through referrals. Not advertising. Not discounts. Just honest service, on time, every time.
          </p>
        </div>

        {{-- Key promises --}}
        <div style="margin-top:28px;display:flex;flex-direction:column;gap:10px">
          @foreach([
            ['📞', 'Always reachable',         'RK Shah answers calls himself — 6 AM to 11 PM, all days'],
            ['🛡️', 'Police verified drivers',  'Every driver background checked before joining the fleet'],
            ['💰', 'Price confirmed upfront',   'We discuss the exact fare before you pay a single rupee advance'],
            ['🚗', 'Well-maintained cars',      'All vehicles serviced every 5,000 km, less than 3 years old'],
            ['📍', 'GPS on every trip',         'Share your live location with family throughout the journey'],
          ] as $promise)
          <div style="display:flex;align-items:flex-start;gap:14px;padding:14px 16px;background:var(--off);border-radius:var(--r2);border-left:3px solid var(--gold)">
            <span style="font-size:20px;flex-shrink:0">{{ $promise[0] }}</span>
            <div>
              <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:var(--navy3);margin-bottom:2px">{{ $promise[1] }}</div>
              <div style="font-size:12px;color:var(--gray5)">{{ $promise[2] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ═══ JOURNEY / TIMELINE ════════════════════════════════════ --}}
<section class="section section--light">
  <div class="container">
    <div style="text-align:center;margin-bottom:50px">
      <span class="eyebrow">Our Journey</span>
      <h2 style="font-family:var(--ff-h);font-size:1.8rem;font-weight:900;color:var(--navy3);margin-top:10px">
        4 Years on the Road
      </h2>
      <p style="font-size:15px;color:var(--gray5);margin-top:8px;max-width:500px;margin-left:auto;margin-right:auto">
        From a single car to a trusted fleet — built entirely on word of mouth.
      </p>
    </div>

    {{-- Timeline --}}
    <div style="position:relative;max-width:860px;margin:0 auto">

      {{-- Centre line --}}
      <div style="position:absolute;left:50%;top:0;bottom:0;width:2px;background:linear-gradient(to bottom,var(--gold),rgba(212,160,23,.1));transform:translateX(-50%)"></div>

      @foreach($timeline as $loop_i => $milestone)

      <div style="display:flex;align-items:center;margin-bottom:36px;gap:0;position:relative">

        @if($loop_i % 2 === 0)
        {{-- Left side content --}}
        <div style="flex:1;padding-right:40px;text-align:right">
          <div style="background:var(--white);border-radius:var(--r2);padding:20px 24px;border:1.5px solid var(--gray2);display:inline-block;text-align:left;max-width:340px">
            <div style="font-family:var(--ff-h);font-size:.95rem;font-weight:800;color:var(--navy3);margin-bottom:5px">{{ $milestone->title }}</div>
            <p style="font-size:13px;color:var(--gray5);line-height:1.65;margin:0">{{ $milestone->description }}</p>
          </div>
        </div>

        {{-- Centre circle --}}
        <div style="position:relative;z-index:2;flex-shrink:0">
          <div style="width:52px;height:52px;border-radius:50%;background:{{ $milestone->color }};display:flex;align-items:center;justify-content:center;font-size:20px;border:3px solid white;box-shadow:0 4px 16px rgba(0,0,0,.12)">
            {{ $milestone->icon }}
          </div>
        </div>

        {{-- Right side: year label --}}
        <div style="flex:1;padding-left:40px">
          <div style="font-family:var(--ff-h);font-size:1.4rem;font-weight:900;color:{{ $milestone->color }}">
            {{ $milestone->year }}
          </div>
        </div>

        @else
        {{-- Left side: year label --}}
        <div style="flex:1;padding-right:40px;text-align:right">
          <div style="font-family:var(--ff-h);font-size:1.4rem;font-weight:900;color:{{ $milestone->color }}">
            {{ $milestone->year }}
          </div>
        </div>

        {{-- Centre circle --}}
        <div style="position:relative;z-index:2;flex-shrink:0">
          <div style="width:52px;height:52px;border-radius:50%;background:{{ $milestone->color }};display:flex;align-items:center;justify-content:center;font-size:20px;border:3px solid white;box-shadow:0 4px 16px rgba(0,0,0,.12)">
            {{ $milestone->icon }}
          </div>
        </div>

        {{-- Right side content --}}
        <div style="flex:1;padding-left:40px">
          <div style="background:var(--white);border-radius:var(--r2);padding:20px 24px;border:1.5px solid var(--gray2);display:inline-block;max-width:340px">
            <div style="font-family:var(--ff-h);font-size:.95rem;font-weight:800;color:var(--navy3);margin-bottom:5px">{{ $milestone->title }}</div>
            <p style="font-size:13px;color:var(--gray5);line-height:1.65;margin:0">{{ $milestone->description }}</p>
          </div>
        </div>
        @endif

      </div>
      @endforeach

    </div>
  </div>
</section>

{{-- ═══ VALUES / COMMITMENTS ══════════════════════════════════ --}}
<section class="section section--white">
  <div class="container">
    <div style="text-align:center;margin-bottom:48px">
      <span class="eyebrow">Our Commitment</span>
      <h2 style="font-family:var(--ff-h);font-size:1.8rem;font-weight:900;color:var(--navy3);margin-top:10px">
        What We Stand For
      </h2>
      <p style="font-size:15px;color:var(--gray5);margin-top:8px;max-width:480px;margin-left:auto;margin-right:auto">
        Six principles that guide every single trip we operate.
      </p>
    </div>
    <div class="grid grid--3">
      @foreach($values as $v)
      <div class="usp-card">
        <div class="usp-card__icon">{{ $v['icon'] }}</div>
        <h3 class="usp-card__title">{{ $v['title'] }}</h3>
        <p class="usp-card__desc">{{ $v['desc'] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ WHY CUSTOMERS STAY ════════════════════════════════════ --}}
<section class="section section--light">
  <div class="container">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:60px;align-items:center">

      <div>
        <span class="eyebrow">Customer Trust</span>
        <h2 style="font-family:var(--ff-h);font-size:1.7rem;font-weight:900;color:var(--navy3);margin:12px 0 20px;line-height:1.2">
          96% of new customers come through referrals
        </h2>
        <p style="font-size:15px;color:var(--gray5);line-height:1.8;margin-bottom:20px">
          In an industry dominated by app-based aggregators and cut-throat pricing, RK Shah Car Rental has never spent a rupee on advertising. Every customer comes from a friend who said: "Call RK Shah — you can trust him."
        </p>
        <p style="font-size:15px;color:var(--gray5);line-height:1.8;margin-bottom:28px">
          That kind of trust is earned one trip at a time. It means picking up at 4 AM without complaint. It means calling ahead when there is a highway jam. It means charging exactly what was agreed — no rupee more.
        </p>
        <a href="{{ route('routes.index') }}" class="btn btn--navy btn--lg">🗺️ View Our Routes</a>
      </div>

      <div style="display:flex;flex-direction:column;gap:14px">
        @foreach([
          ['🔄', '96%', 'Customer Return Rate',    'Once a customer travels with us, they come back'],
          ['👥', '70%', 'Referral Bookings',        'Majority of new bookings come from referrals'],
          ['⭐', '4.9', 'Average Google Rating',    'Across 180+ verified reviews'],
          ['⏱️', '< 5 min', 'Response Time',        'How quickly RK Shah picks up or calls back'],
          ['🏆', '0',  'Unresolved Complaints',     'Every issue resolved directly and personally'],
        ] as $metric)
        <div style="display:flex;align-items:center;gap:16px;background:var(--white);border-radius:var(--r2);padding:18px;border:1.5px solid var(--gray2)">
          <span style="font-size:22px;flex-shrink:0">{{ $metric[0] }}</span>
          <div style="min-width:60px">
            <div style="font-family:var(--ff-h);font-size:1.4rem;font-weight:900;color:var(--navy3);line-height:1">{{ $metric[1] }}</div>
          </div>
          <div>
            <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:var(--navy3);margin-bottom:2px">{{ $metric[2] }}</div>
            <div style="font-size:12px;color:var(--gray4)">{{ $metric[3] }}</div>
          </div>
        </div>
        @endforeach
      </div>

    </div>
  </div>
</section>

{{-- ═══ FLEET SNAPSHOT ═════════════════════════════════════════ --}}
<section style="background:var(--navy3);padding:70px 0">
  <div class="container">
    <div style="text-align:center;margin-bottom:40px">
      <span class="eyebrow" style="background:rgba(212,160,23,.15);border-color:rgba(212,160,23,.3)">Our Fleet</span>
      <h2 style="font-family:var(--ff-h);font-size:1.6rem;font-weight:900;color:white;margin-top:12px">
        Four Cars. One Standard.
      </h2>
      <p style="font-size:14px;color:rgba(255,255,255,.45);margin-top:8px">
        Every vehicle sanitized, serviced, and GPS-tracked before every trip.
      </p>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px">
      @foreach([
        ['🚙','Innova Crysta','Premium SUV · 7 Seats','₹14/km','The flagship — for families and long trips'],
        ['🚗','Kia Creta',    'Compact SUV · 5 Seats','₹12/km','Stylish and comfortable for couples'],
        ['🚐','Ertiga',       'MPV · 7 Seats',        '₹11/km','Best value for groups of 7'],
        ['🚕','Swift Dzire',  'Sedan · 4 Seats',      '₹9/km', 'Most economical for solo and couples'],
      ] as $car)
      <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:var(--r2);padding:22px;text-align:center;transition:all .2s"
           onmouseover="this.style.background='rgba(212,160,23,.1)';this.style.borderColor='rgba(212,160,23,.3)'"
           onmouseout="this.style.background='rgba(255,255,255,.05)';this.style.borderColor='rgba(255,255,255,.1)'">
        <div style="font-size:42px;margin-bottom:12px">{{ $car[0] }}</div>
        <div style="font-family:var(--ff-h);font-size:.9rem;font-weight:800;color:white;margin-bottom:3px">{{ $car[1] }}</div>
        <div style="font-size:11px;color:rgba(255,255,255,.4);margin-bottom:10px">{{ $car[2] }}</div>
        <div style="font-family:var(--ff-h);font-size:1rem;font-weight:900;color:var(--gold);margin-bottom:6px">{{ $car[3] }}</div>
        <div style="font-size:11px;color:rgba(255,255,255,.35);line-height:1.4">{{ $car[4] }}</div>
      </div>
      @endforeach
    </div>
    <div style="text-align:center;margin-top:28px">
      <a href="{{ route('fleet.index') }}" class="btn btn--gold btn--lg">🚗 View Full Fleet Details</a>
    </div>
  </div>
</section>

{{-- ═══ CERTIFICATIONS / TRUST SIGNALS ═══════════════════════ --}}
<section class="section section--light">
  <div class="container">
    <div style="text-align:center;margin-bottom:40px">
      <span class="eyebrow">Verified & Trusted</span>
      <h2 style="font-family:var(--ff-h);font-size:1.6rem;font-weight:900;color:var(--navy3);margin-top:10px">
        Your Safety is Non-Negotiable
      </h2>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:40px">
      @foreach([
        ['👮','Police Verification',   'Every driver holds a current police verification certificate from Delhi Police. We check this before any driver joins the fleet.'],
        ['📋','Valid Commercial License','All drivers hold valid commercial vehicle driving licenses (badge) as required by law. No amateur drivers, ever.'],
        ['🚗','Vehicle Fitness Certificate','Every vehicle carries a valid fitness certificate (FC) from the transport department. Renewed on time, every time.'],
        ['📍','GPS & Live Tracking',   'Every vehicle has GPS tracking. Customers can share their live trip status with family members for complete peace of mind.'],
        ['🧹','Sanitized Before Every Trip','Vehicles are cleaned and sanitized before every outstation journey. AC filters checked. No compromise on hygiene.'],
        ['📞','Emergency Contact Always Active','RK Shah\'s personal number is active 6 AM to 11 PM. For any mid-trip emergency, one call is all it takes.'],
      ] as $trust)
      <div style="background:var(--white);border-radius:var(--r2);padding:24px;border:1.5px solid var(--gray2)">
        <div style="font-size:28px;margin-bottom:12px">{{ $trust[0] }}</div>
        <div style="font-family:var(--ff-h);font-size:.9rem;font-weight:800;color:var(--navy3);margin-bottom:8px">{{ $trust[1] }}</div>
        <p style="font-size:13px;color:var(--gray5);line-height:1.65;margin:0">{{ $trust[2] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ═══ CTA ════════════════════════════════════════════════════ --}}
<section class="cta-section">
  <div class="container">
    <div class="cta-section__inner">
      <h2 class="cta-section__title">Travel with Someone You Can Trust</h2>
      <p class="cta-section__desc">
        {{ $cta['description'] ?? 'Ten years on the road. 1,200+ families served. The same phone number, the same owner, the same promise.' }}
      </p>
      <div class="cta-section__btns">
        <a href="tel:+919324555165" class="btn btn--white btn--lg">📞 Call: +91 93245 55165</a>
        <a href="https://wa.me/919324555165" class="btn btn--navy btn--lg" target="_blank" rel="noopener">💬 WhatsApp RK Shah</a>
        <a href="{{ route('routes.index') }}" class="btn btn--outline-white btn--lg">🗺️ View Routes</a>
      </div>
    </div>
  </div>
</section>

@endsection
