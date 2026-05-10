@extends('layouts.app')

@section('title', 'RK Shah Car Rental — Delhi Outstation Cab Service')
@section('meta_description', 'Delhi\'s most trusted outstation cab service. Book Innova Crysta, Kia Creta, Ertiga, Swift Dzire. All-inclusive pricing, verified drivers, 24/7 support. Call +91 93245 55165.')

@section('content')

{{-- ═══ HERO ════════════════════════════════════════ --}}
<section class="hero">
    <div class="hero__mesh"></div>
    <div class="hero__pattern"></div>

    <div class="container hero__inner">
        {{-- Left: headline + CTA --}}
        <div class="hero__content">
            <div class="hero__label">
                <span class="hero__label-dot"></span>
                <span>{{ $hero['label'] ?? "Delhi's Trusted Outstation Cab Service" }}</span>
            </div>

            <h1 class="hero__title">
                {{ $hero['title_line1'] ?? 'Every Road Leads to' }}<br>
                <em class="hero__title-em">{{ $hero['title_line2'] ?? 'a Great Journey.' }}</em>
            </h1>

            <p class="hero__desc">
                Book outstation cabs from Delhi to Agra, Rajasthan, Himachal &amp; beyond.
                AC cars, expert drivers, all-inclusive pricing with zero hidden charges.
            </p>

            {{-- Stats --}}
            <div class="hero__stats">
                @foreach($stats as $stat)
                <div class="hero__stat">
                    <span class="hero__stat-num">{{ $stat['value'] }}</span>
                    <span class="hero__stat-label">{{ $stat['label'] }}</span>
                </div>
                @endforeach
            </div>

            <div class="hero__btns">
                <button class="btn btn--gold btn--lg" onclick="openBookingModal()">📞 Book Your Cab Now</button>
                <a href="{{ route('fleet.index') }}" class="btn btn--outline-white btn--lg">View Fleet →</a>
            </div>

            {{-- Route chips --}}
            <div class="hero__chips">
                @foreach($routes as $r)
                <a href="{{ route('routes.show', $r->slug) }}" class="route-chip">
                    <span class="route-chip__from">Delhi</span>
                    <span class="route-chip__arrow">→</span>
                    <span class="route-chip__to">{{ $r->to_city }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Right: Booking Widget --}}
        <div class="booking-widget">
            <div class="booking-widget__header">
                <h2 class="booking-widget__title">Instant Cab Booking</h2>
                <p class="booking-widget__sub">Get price quote in 2 minutes · No advance needed</p>
            </div>

            {{-- Trip type tabs --}}
            <div class="trip-tabs">
                <button class="trip-tab is-active" data-trip="one_way">One Way</button>
                <button class="trip-tab" data-trip="round_trip">Round Trip</button>
                <button class="trip-tab" data-trip="airport">Airport</button>
                <button class="trip-tab" data-trip="hourly">Hourly</button>
            </div>

            {{-- Flash messages --}}
            @if(session('booking_info'))
            <div style="background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.3);border-radius:8px;padding:12px 14px;margin-bottom:14px;font-size:13px;color:#10B981;font-family:var(--ff-h);font-weight:600">
                ✅ {{ session('booking_info') }}
            </div>
            @endif

            @if($errors->any())
            <div style="background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.25);border-radius:8px;padding:12px 14px;margin-bottom:14px;font-size:13px;color:#ef4444;font-family:var(--ff-h)">
                <div style="font-weight:700;margin-bottom:4px">Please fix the following:</div>
                @foreach($errors->all() as $error)
                <div>• {{ $error }}</div>
                @endforeach
            </div>
            @endif

            <form id="quickBookingForm" action="{{ route('lead.store') }}" method="POST">
                @csrf
                <input type="hidden" name="trip_type" id="tripTypeInput" value="one_way">

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="from-city">From</label>
                        <input class="form-input" type="text" id="from-city" name="from_city" value="Delhi" placeholder="Pickup city" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="to-city">To</label>
                        <input class="form-input" type="text" id="to-city" name="to_city" placeholder="Agra, Jaipur, Manali..." required
                               hx-get="{{ route('api.fare') }}" hx-trigger="input changed delay:500ms" hx-target="#farePreview" hx-include="#carTypeSelect, #tripTypeInput">
                    </div>
                </div>

                <div class="form-row form-row--3">
                    <div class="form-group">
                        <label class="form-label" for="travel-date">Date</label>
                        <input class="form-input" type="date" id="travel-date" name="travel_date">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="carTypeSelect">Car Type</label>
                        <select class="form-select" id="carTypeSelect" name="car_type">
                            <option value="dzire">Swift Dzire (₹9/km)</option>
                            <option value="ertiga">Ertiga (₹11/km)</option>
                            <option value="creta">Kia Creta (₹12/km)</option>
                            <option value="innova" selected>Innova Crysta (₹14/km)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="passengers">Passengers</label>
                        <select class="form-select" id="passengers" name="passengers">
                            <option>1–4</option>
                            <option>5–7</option>
                        </select>
                    </div>
                </div>

                {{-- Fare preview (populated by JS) --}}
                <div id="farePreview" class="fare-preview" style="display:none">
                    <div class="fare-preview__label">Estimated Fare</div>
                    <div class="fare-preview__amount" id="fareAmount">—</div>
                    <div class="fare-preview__note">Estimated range · Final price confirmed on call</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="widget-name">Your Name</label>
                    <input class="form-input" type="text" id="widget-name" name="name" placeholder="Rajesh Sharma" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="widget-phone">Phone Number</label>
                    <input class="form-input" type="tel" id="widget-phone" name="phone" placeholder="98765 43210" pattern="[6-9][0-9]{9}" required>
                </div>

                <button type="submit" class="btn btn--search btn--full">
                    🔍 Check Availability &amp; Get Quote
                </button>
            </form>

            <div class="booking-widget__direct">
                Or call directly: <a href="tel:+919324555165">+91 93245 55165</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══ TICKER ════════════════════════════════════════ --}}
<div class="ticker" aria-hidden="true">
    <div class="ticker__track">
        @foreach(['All-Inclusive Pricing','Verified Drivers','24/7 Support','No Surge Pricing','GPS Tracked','Free Cancellation*','Pan India Travel','UPI / Cash Payment'] as $item)
        <div class="ticker__item"><span>✓ {{ $item }}</span><div class="ticker__dot"></div></div>
        @endforeach
        {{-- Duplicate for seamless loop --}}
        @foreach(['All-Inclusive Pricing','Verified Drivers','24/7 Support','No Surge Pricing','GPS Tracked','Free Cancellation*','Pan India Travel','UPI / Cash Payment'] as $item)
        <div class="ticker__item"><span>✓ {{ $item }}</span><div class="ticker__dot"></div></div>
        @endforeach
    </div>
</div>

{{-- ═══ STATS BAND ════════════════════════════════════ --}}
<div class="stats-band">
    <div class="container">
        <div class="stats-band__grid">
            @foreach($stats as $stat)
            <div class="stats-band__item">
                <span class="stats-band__num">{{ $stat['value'] }}</span>
                <div class="stats-band__label">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══ TRUST BAR ════════════════════════════════════ --}}
<div class="trust-bar">
    <div class="container">
        <div class="trust-bar__inner">
            @foreach(['🔒 Police Verified Drivers','📍 GPS Tracked Cars','💰 Zero Hidden Charges','🏆 Google Verified Business','🚗 Well Maintained Fleet'] as $item)
            <div class="trust-bar__item">{{ $item }}</div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══ WHY CHOOSE US ═══════════════════════════════ --}}
<section class="section section--light">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Why RK Shah</span>
            <h2 class="section-head__title">{{ $whyUs['section_title'] ?? 'Not Just a Cab.' }} <span class="text--gold">A Complete Journey.</span></h2>
            <p class="section-head__desc">{{ $whyUs['section_desc'] ?? 'Everything that matters for a comfortable, safe, stress-free outstation trip.' }}</p>
            <div class="section-head__divider"></div>
        </div>

        <div class="grid grid--3">
            @foreach([
                ['icon'=>'🛡️','title'=>'Police Verified Drivers Only','desc'=>'Every driver is background checked, licensed, and trained in professional conduct. No random driver allocation.'],
                ['icon'=>'💰','title'=>'Transparent All-In Pricing',  'desc'=>'No toll surprises, no fuel surcharges, no night charges. The price we quote is the price you pay.'],
                ['icon'=>'📍','title'=>'Live GPS Tracking',           'desc'=>'Share your trip link with family. Track your cab in real-time for complete peace of mind.'],
                ['icon'=>'🚗','title'=>'Well-Maintained Fleet',       'desc'=>'All cars serviced every 5,000 km. AC guaranteed. Sanitized before every trip. Less than 3 years old.'],
                ['icon'=>'📞','title'=>'Direct Owner Support 24/7',   'desc'=>'You call RK Shah directly — not a call centre. Real help any hour of the day or night.'],
                ['icon'=>'🔄','title'=>'Free Cancellation*',          'desc'=>'Plans change — we understand. Cancel up to 24 hours before departure with no questions asked.'],
            ] as $usp)
            <div class="usp-card">
                <div class="usp-card__icon">{{ $usp['icon'] }}</div>
                <h3 class="usp-card__title">{{ $usp['title'] }}</h3>
                <p class="usp-card__desc">{{ $usp['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ FLEET PREVIEW ═════════════════════════════════ --}}
<section class="section section--white">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Our Fleet</span>
            <h2 class="section-head__title">Choose Your <span class="text--gold">Perfect Ride</span></h2>
            <p class="section-head__desc">Every car is AC, GPS-tracked, and sanitized before your trip. All-inclusive fares shown.</p>
            <div class="section-head__divider"></div>
        </div>

        <div class="grid grid--4">
            @foreach($fleet as $car)
            <div class="fleet-card">
                <div class="fleet-card__img fleet-card__img--{{ $car->bg_class }}" style="position:relative;overflow:hidden">
                    @if($car->badge)
                    <span class="fleet-card__badge">{{ $car->badge }}</span>
                    @endif
                    @if($car->featured_image)
                    <img src="{{ asset('storage/'.$car->featured_image) }}"
                         alt="{{ $car->name }}"
                         style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0">
                    @else
                    <span class="fleet-card__emoji" aria-hidden="true">{{ $car->emoji }}</span>
                    @endif
                </div>
                <div class="fleet-card__body">
                    <h3 class="fleet-card__name">{{ $car->name }}</h3>
                    <div class="fleet-card__type">{{ strtoupper($car->type) }} · {{ $car->seats }} SEATS</div>
                    <div class="fleet-card__specs">
                        @foreach(array_slice($car->features, 0, 4) as $feat)
                        <span class="fleet-card__spec">{{ $feat }}</span>
                        @endforeach
                    </div>
                    <div class="fleet-card__price">
                        <span class="fleet-card__price-num">₹{{ $car->rate_per_km }}</span>
                        <span class="fleet-card__price-unit">/km onwards</span>
                    </div>
                    <a href="{{ route('fleet.show', $car->slug) }}" class="btn btn--navy btn--full btn--sm">
                        View Details →
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="section__cta-row">
            <a href="{{ route('fleet.index') }}" class="btn btn--navy">🚗 View Complete Fleet Details</a>
        </div>
    </div>
</section>

{{-- ═══ POPULAR ROUTES ═════════════════════════════════ --}}
<section class="section section--dark">
    <div class="container">
        <div class="section-head section-head--dark">
            <span class="eyebrow">Popular Routes</span>
            <h2 class="section-head__title" style="color:white">Where Will You <span class="text--gold">Go Today?</span></h2>
            <p class="section-head__desc" style="color:rgba(255,255,255,.55)">Estimated starting fares — final price confirmed on call.</p>
            <div class="section-head__divider"></div>
        </div>

        <div class="routes-list">
            @foreach($routes as $route)
            <div class="route-card">
                <div class="route-card__stripe" style="background:{{ $route->accent_color }}"></div>
                <div class="route-card__body">
                    <div class="route-card__header">
                        <div class="route-card__name">{{ $route->from_city }} <span class="route-card__arrow">→</span> {{ $route->to_city }}</div>
                        <span class="route-card__tag">{{ $route->tag }}</span>
                    </div>
                    <div class="route-card__meta">{{ $route->distance_km }} km · ~{{ $route->duration_hrs }} hrs · {{ $route->highlight }}</div>
                </div>
                <div class="route-card__pricing">
                    <div class="route-card__from">Starting from</div>
                    <div class="route-card__price">{{ $route->min_price ? '₹'.number_format($route->min_price) : 'Get Quote' }}</div>
                    <div class="route-card__unit">one way</div>
                    <button class="btn btn--gold btn--sm" onclick="openBookingModal()">Book</button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="section__cta-row">
            <a href="{{ route('routes.index') }}" class="btn btn--gold">🗺️ View All 40+ Routes with Pricing</a>
        </div>
    </div>
</section>

{{-- ═══ HOW IT WORKS ════════════════════════════════════ --}}
<section class="section section--light">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Simple Process</span>
            <h2 class="section-head__title">Booked in <span class="text--gold">Under 2 Minutes</span></h2>
            <p class="section-head__desc">No app download. No registration. Call or fill the form — and your cab is confirmed.</p>
            <div class="section-head__divider"></div>
        </div>

        <div class="hiw-grid">
            @foreach([
                ['num'=>'01','icon'=>'📋','title'=>'Enter Your Route',        'desc'=>'Pick your from/to city, travel date, and preferred car from the booking form.'],
                ['num'=>'02','icon'=>'📞','title'=>'Get Instant Quote',        'desc'=>'We call or WhatsApp you with your all-inclusive price within 5 minutes.'],
                ['num'=>'03','icon'=>'💳','title'=>'Confirm & Pay Advance',    'desc'=>'Pay a small token advance via UPI/NEFT. Balance due on the day of journey.'],
                ['num'=>'04','icon'=>'🛣️','title'=>'Sit Back & Travel',        'desc'=>'Driver arrives on time. Share live tracking with family. Enjoy stress-free travel.'],
            ] as $step)
            <div class="hiw-step">
                <div class="hiw-step__num">{{ $step['num'] }}</div>
                <div class="hiw-step__icon">{{ $step['icon'] }}</div>
                <h3 class="hiw-step__title">{{ $step['title'] }}</h3>
                <p class="hiw-step__desc">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ TOUR PACKAGES ══════════════════════════════════ --}}
<section class="section section--white">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Tour Packages</span>
            <h2 class="section-head__title">Curated <span class="text--gold">Holiday Packages</span></h2>
            <p class="section-head__desc">All-inclusive tour packages with cab, driver, and itinerary. Just pack your bags.</p>
            <div class="section-head__divider"></div>
        </div>

        <div class="grid grid--3">
            @foreach($packages as $pkg)
            <div class="pkg-card pkg-card--{{ $pkg->bg_class }}">
                {{-- <div class="pkg-card__img" style="position:relative;overflow:hidden">
                    @if($pkg->featured_image)
                    <img src="{{ asset('storage/'.$pkg->featured_image) }}"
                         alt="{{ $pkg->name }}"
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
                    <img src="{{ asset('storage/'.$pkg->featured_image) }}"
                        alt="{{ $pkg->name }}"
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
                    <div class="pkg-card__dests">
                        @foreach(array_slice($pkg->destinations, 0, 3) as $dest)
                        <span class="pkg-card__dest">{{ $dest }}</span>
                        @endforeach
                    </div>
                    <div class="pkg-card__footer">
                        @if($pkg->price > 0)
                        <div class="pkg-card__price">₹{{ number_format($pkg->price) }} <span>/person</span></div>
                        @else
                        <div class="pkg-card__price">Custom <span>pricing</span></div>
                        @endif
                        <a href="{{ route('packages.show', $pkg->slug) }}" class="btn btn--navy btn--sm">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="section__cta-row">
            <a href="{{ route('packages.index') }}" class="btn btn--navy">🎒 View All Tour Packages</a>
        </div>
    </div>
</section>

{{-- ═══ TESTIMONIALS ════════════════════════════════════ --}}
<section class="section section--light">
    <div class="container">
        <div class="section-head">
            <span class="eyebrow">Customer Reviews</span>
            <h2 class="section-head__title">Real Trips. <span class="text--gold">Real People.</span></h2>
            <p class="section-head__desc">Don't take our word for it — here's what our travellers say.</p>
            <div class="section-head__divider"></div>
        </div>

        {{-- Rating summary --}}
        <div class="review-widget">
            <div class="review-widget__score">
                <span class="review-widget__num">4.9</span>
                <div class="review-widget__stars">★★★★★</div>
                <div class="review-widget__count">180+ reviews</div>
            </div>
            <div class="review-widget__divider"></div>
            <div class="review-widget__content">
                <div class="review-widget__platforms">
                    <span>Google <strong>4.9★</strong></span>
                    <span>JustDial <strong>4.8★</strong></span>
                    <span>Trustpilot <strong>4.9★</strong></span>
                </div>
                <div class="review-widget__label">Rated "Excellent" by 96% of customers</div>
            </div>
        </div>

        <div class="grid grid--3">
            @foreach($testimonials as $t)
            <div class="testi-card">
                <div class="testi-card__stars">
                    @for($i = 0; $i < $t->rating; $i++)★@endfor
                </div>
                <p class="testi-card__quote">{{ $t->review_text }}</p>
                <div class="testi-card__author">
                    <div class="testi-card__avatar">{{ $t->initials }}</div>
                    <div>
                        <div class="testi-card__name">{{ $t->customer_name }}</div>
                        <div class="testi-card__meta">{{ $t->source }}</div>
                    </div>
                </div>
                <div class="testi-card__trip">
                    <span class="testi-card__trip-label">Trip:</span>
                    <span class="testi-card__trip-route">{{ $t->trip_route }} · {{ $t->car_used }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ CTA BANNER ═════════════════════════════════════ --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-section__inner">
            <h2 class="cta-section__title">{{ $cta['title'] ?? 'Ready for Your Next Adventure?' }}</h2>
            <p class="cta-section__desc">{{ $cta['description'] ?? 'Call RK Shah directly or WhatsApp us — instant response, honest pricing, unforgettable journey.' }}</p>
            <div class="cta-section__btns">
                <a href="tel:+919324555165" class="btn btn--white btn--lg">📞 Call: +91 93245 55165</a>
                <a href="https://wa.me/919324555165" class="btn btn--navy btn--lg" target="_blank" rel="noopener">💬 WhatsApp Us Now</a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Set min date for travel date input
    const dateInput = document.getElementById('travel-date');
    const tomorrow  = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    dateInput.min   = tomorrow.toISOString().split('T')[0];
    dateInput.value = tomorrow.toISOString().split('T')[0];

    // Trip tabs
    document.querySelectorAll('.trip-tab').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.trip-tab').forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            document.getElementById('tripTypeInput').value = btn.dataset.trip;
        });
    });

    // Live fare calculator
    const calcFare = async () => {
        const dest    = document.getElementById('to-city').value.trim();
        const carType = document.getElementById('carTypeSelect').value;
        const trip    = document.getElementById('tripTypeInput').value;
        if (!dest) return;

        try {
            const res  = await fetch(`{{ route('api.fare') }}?destination=${encodeURIComponent(dest)}&car_type=${carType}&trip_type=${trip}`);
            const data = await res.json();
            const preview = document.getElementById('farePreview');
            if (data.found) {
                const min = '₹' + data.min.toLocaleString('en-IN');
                const max = '₹' + data.max.toLocaleString('en-IN');
                document.getElementById('fareAmount').textContent = min + ' – ' + max;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        } catch {}
    };

    let fareTimer;
    ['to-city','carTypeSelect'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', () => {
            clearTimeout(fareTimer);
            fareTimer = setTimeout(calcFare, 500);
        });
    });
    document.querySelectorAll('.trip-tab').forEach(b => b.addEventListener('click', () => {
        clearTimeout(fareTimer);
        fareTimer = setTimeout(calcFare, 300);
    }));
</script>
@endpush
