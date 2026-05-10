@extends('layouts.app')
@section('title', 'Booking Received — Thank You!')
@section('content')

<section style="min-height:100vh;background:linear-gradient(145deg,#051F32 0%,#083C5D 60%,#0a4a6e 100%);display:flex;align-items:center;justify-content:center;padding-top:76px">
    <div class="container">
        <div style="max-width:540px;margin:0 auto;text-align:center;padding:40px 20px">

            <div style="width:86px;height:86px;border-radius:50%;background:rgba(16,185,129,.15);border:2px solid rgba(16,185,129,.4);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:40px">
                ✅
            </div>

            <h1 style="font-family:var(--ff-h);font-size:clamp(1.8rem,4vw,2.6rem);font-weight:900;color:white;margin-bottom:14px;line-height:1.1">
                Enquiry Received!
            </h1>

            @if(session('lead_name'))
            <p style="font-size:15px;color:rgba(255,255,255,.75);margin-bottom:28px;line-height:1.75">
                Thank you <strong style="color:#D4A017">{{ session('lead_name') }}</strong>!
                Your enquiry for <strong style="color:#D4A017">{{ session('lead_route') }}</strong>
                is saved. RK Shah will call <strong style="color:#D4A017">{{ session('lead_phone') }}</strong>
                within <strong style="color:#10B981">5 minutes</strong>.
            </p>
            @else
            <p style="font-size:15px;color:rgba(255,255,255,.75);margin-bottom:28px;line-height:1.75">
                Your enquiry has been saved. RK Shah will call you within
                <strong style="color:#10B981">5 minutes</strong> to confirm your booking.
            </p>
            @endif

            <div style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:24px 28px;margin-bottom:28px;text-align:left">
                <div style="font-family:var(--ff-h);font-size:11px;letter-spacing:1.5px;text-transform:uppercase;color:#D4A017;font-weight:700;margin-bottom:16px">What happens next</div>
                @foreach([
                    ['📞','RK Shah calls you',          'Within 5 minutes on your number'],
                    ['💬','Fare discussion on call',     'Exact price confirmed based on your trip'],
                    ['✅','Booking confirmed',            'Small advance via UPI to reserve your cab'],
                    ['🚗','Driver details shared',       'Before your travel date via WhatsApp'],
                ] as $step)
                <div style="display:flex;align-items:flex-start;gap:14px;margin-bottom:14px">
                    <span style="font-size:18px;width:28px;flex-shrink:0">{{ $step[0] }}</span>
                    <div>
                        <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:white;margin-bottom:1px">{{ $step[1] }}</div>
                        <div style="font-size:12px;color:rgba(255,255,255,.4)">{{ $step[2] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-bottom:20px">
                <a href="tel:+919324555165"
                   style="display:inline-flex;align-items:center;gap:8px;background:#D4A017;color:#051F32;padding:14px 22px;border-radius:12px;font-family:var(--ff-h);font-size:13px;font-weight:800;text-decoration:none">
                    📞 Call Now
                </a>
                <a href="https://wa.me/919324555165"
                   target="_blank"
                   style="display:inline-flex;align-items:center;gap:8px;background:#25D366;color:white;padding:14px 22px;border-radius:12px;font-family:var(--ff-h);font-size:13px;font-weight:800;text-decoration:none">
                    💬 WhatsApp
                </a>
                <a href="{{ route('home') }}"
                   style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.08);color:rgba(255,255,255,.7);padding:14px 22px;border-radius:12px;font-family:var(--ff-h);font-size:13px;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,.12)">
                    ← Back to Home
                </a>
            </div>

            <p style="font-size:11px;color:rgba(255,255,255,.25)">RK Shah Car Rental · Soniya Vihar, Delhi · 6 AM – 11 PM daily</p>
        </div>
    </div>
</section>

@endsection
