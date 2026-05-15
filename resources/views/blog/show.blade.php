@extends('layouts.app')

@section('title', ($post->seo_title ?? $post->title) . ' | RK Shah Car Rental — Delhi Cab Blog' . ' | RK Shah Car Rental')
@section('meta_description', $post->seo_description ?? $post->excerpt ?? 'Read this guide from RK Shah Car Rental — Delhi outstation cab service since 2015. Expert travel tips, route guides and cab booking advice.')
@section('meta_keywords', ($post->category ?? 'travel tips') . ', outstation cab Delhi, travel guide Delhi, RK Shah Car Rental blog')
@section('og_title', $post->title)

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container" style="max-width:820px">
    <nav class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <a href="{{ route('blog.index') }}">Blog</a>
      <span class="breadcrumb__sep">›</span>
      @if($post->category)
      <span class="breadcrumb__current">{{ $post->category }}</span>
      @endif
    </nav>

    {{-- Category + read time --}}
    <div style="display:flex;align-items:center;gap:10px;margin:14px 0 16px">
      @if($post->category)
      <span style="background:rgba(212,160,23,.15);color:var(--gold);font-size:11px;padding:4px 12px;border-radius:20px;font-family:var(--ff-h);font-weight:700">
        {{ $post->category }}
      </span>
      @endif
      <span style="font-size:12px;color:rgba(255,255,255,.4)">{{ $post->short_date }}</span>
      <span style="font-size:12px;color:rgba(255,255,255,.4)">·</span>
      <span style="font-size:12px;color:rgba(255,255,255,.4)">{{ $post->read_time }}</span>
      <span style="font-size:12px;color:rgba(255,255,255,.4)">·</span>
      <span style="font-size:12px;color:rgba(255,255,255,.4)">{{ number_format($post->views) }} views</span>
    </div>

    <h1 class="page-hero__title" style="text-align:left;font-size:clamp(1.6rem,3vw,2.6rem);line-height:1.15">
      {{ $post->title }}
    </h1>

    @if($post->excerpt)
    <p style="font-size:15px;color:rgba(255,255,255,.6);margin-top:14px;line-height:1.7;max-width:640px">
      {{ $post->excerpt }}
    </p>
    @endif
  </div>
</div>

<section class="section section--light">
  <div class="container">
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:52px;align-items:start">

      {{-- Article content --}}
      <article>

        {{-- Article styles injected inline --}}
        <style>
          article h2 { font-family: var(--ff-h); font-size: 1.25rem; font-weight: 800; color: var(--navy3); margin: 32px 0 14px; padding-top: 8px; border-top: 2px solid var(--gold-mid); }
          article h3 { font-family: var(--ff-h); font-size: 1rem; font-weight: 700; color: var(--navy3); margin: 24px 0 10px; }
          article p  { font-size: 15px; line-height: 1.85; color: var(--gray6); margin-bottom: 18px; }
          article ul, article ol { padding-left: 24px; margin-bottom: 18px; }
          article li { font-size: 15px; line-height: 1.8; color: var(--gray5); margin-bottom: 6px; }
          article strong { color: var(--navy3); font-weight: 700; }
          article a { color: var(--navy); text-decoration: underline; }
        </style>

        {!! $post->content !!}

        {{-- Share / CTA at end of article --}}
        <div style="margin-top:40px;padding:24px;background:var(--gold-dim);border:1px solid var(--gold-mid);border-radius:var(--r3)">
          <div style="font-family:var(--ff-h);font-size:1rem;font-weight:800;color:var(--navy3);margin-bottom:8px">
            Ready to plan your trip?
          </div>
          <p style="font-size:14px;color:var(--gray5);margin-bottom:16px">
            RK Shah Car Rental covers all routes mentioned in this guide. AC cars, verified drivers, transparent pricing — confirmed on call.
          </p>
          <div style="display:flex;gap:10px;flex-wrap:wrap">
            <button onclick="openBookingModal()" class="btn btn--gold">📞 Book Your Cab Now</button>
            <a href="{{ route('routes.index') }}" class="btn btn--navy">🗺️ View Routes & Fares</a>
          </div>
        </div>

        {{-- Related posts --}}
        @if($related->count() > 0)
        <div style="margin-top:40px">
          <div style="font-family:var(--ff-h);font-size:.9rem;font-weight:800;color:var(--navy3);margin-bottom:16px;padding-bottom:8px;border-bottom:2px solid var(--gray2)">
            More in {{ $post->category }}
          </div>
          @foreach($related as $rel)
          <a href="{{ route('blog.show', $rel->slug) }}"
             style="display:flex;gap:14px;padding:14px 0;border-bottom:1px solid var(--gray2);text-decoration:none">
            <span style="font-size:28px;flex-shrink:0">{{ $rel->display_emoji }}</span>
            <div>
              <div style="font-family:var(--ff-h);font-size:13px;font-weight:700;color:var(--navy3);margin-bottom:3px;line-height:1.35">{{ $rel->title }}</div>
              <div style="font-size:11px;color:var(--gray4)">{{ $rel->short_date }} · {{ $rel->read_time }}</div>
            </div>
          </a>
          @endforeach
        </div>
        @endif

      </article>

      {{-- Sidebar --}}
      <aside style="position:sticky;top:96px">

        {{-- Book CTA --}}
        <div style="background:var(--navy3);border-radius:var(--r3);padding:24px;margin-bottom:20px">
          <div style="font-family:var(--ff-h);font-size:.95rem;font-weight:800;color:white;margin-bottom:8px">
            🚗 Book a Cab
          </div>
          <p style="font-size:13px;color:rgba(255,255,255,.55);margin-bottom:16px;line-height:1.6">
            Cover the routes in this guide. AC cab, verified driver, price confirmed on call.
          </p>
          <button onclick="openBookingModal()" class="btn btn--gold btn--full">
            📞 Book Now
          </button>
          <a href="https://wa.me/919324555165" class="btn btn--outline-white btn--full"
             style="margin-top:8px" target="_blank" rel="noopener">
            💬 WhatsApp
          </a>
        </div>

        {{-- Recent articles --}}
        @if($recent->count() > 0)
        <div style="background:var(--white);border:1.5px solid var(--gray2);border-radius:var(--r2);padding:20px">
          <div style="font-family:var(--ff-h);font-size:.85rem;font-weight:800;color:var(--navy3);margin-bottom:16px">
            Recent Articles
          </div>
          @foreach($recent as $r)
          <a href="{{ route('blog.show', $r->slug) }}"
             style="display:flex;align-items:flex-start;gap:10px;padding:10px 0;border-bottom:1px solid var(--gray1);text-decoration:none">
            <span style="font-size:22px;flex-shrink:0">{{ $r->display_emoji }}</span>
            <div>
              <div style="font-family:var(--ff-h);font-size:12px;font-weight:700;color:var(--navy3);line-height:1.35;margin-bottom:2px">
                {{ $r->title }}
              </div>
              <div style="font-size:10px;color:var(--gray4)">{{ $r->short_date }}</div>
            </div>
          </a>
          @endforeach

          <a href="{{ route('blog.index') }}"
             style="display:block;text-align:center;margin-top:14px;font-size:12px;font-weight:600;color:var(--gold);font-family:var(--ff-h);text-decoration:none">
            View All Articles →
          </a>
        </div>
        @endif

        {{-- Popular routes --}}
        <div style="background:var(--off);border:1.5px solid var(--gray2);border-radius:var(--r2);padding:20px;margin-top:16px">
          <div style="font-family:var(--ff-h);font-size:.85rem;font-weight:800;color:var(--navy3);margin-bottom:14px">
            Popular Routes
          </div>
          @foreach([
            ['Delhi → Agra',     'delhi-to-agra'],
            ['Delhi → Jaipur',   'delhi-to-jaipur'],
            ['Delhi → Manali',   'delhi-to-manali'],
            ['Delhi → Rishikesh','delhi-to-rishikesh'],
            ['Delhi → Shimla',   'delhi-to-shimla'],
          ] as $link)
          <a href="{{ route('routes.show', $link[1]) }}"
             style="display:flex;align-items:center;justify-content:space-between;padding:7px 0;border-bottom:1px solid var(--gray2);text-decoration:none;font-size:12px;font-weight:600;color:var(--navy3)">
            <span>{{ $link[0] }}</span>
            <span style="color:var(--gold)">→</span>
          </a>
          @endforeach
        </div>

      </aside>
    </div>
  </div>
</section>

@endsection
