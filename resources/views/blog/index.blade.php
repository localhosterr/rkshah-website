@extends('layouts.app')

@section('title', 'Travel Blog — Route Guides, Tips & Destination Inspiration | RK Shah')
@section('meta_description', 'Insider travel guides from Delhi. Agra, Manali, Jaipur, Rishikesh route tips, budget cab advice, seasonal travel guides. Written by RK Shah Car Rental.')

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <span class="breadcrumb__current">Travel Blog</span>
    </nav>
    <span class="page-hero__eyebrow">Travel Blog</span>
    <h1 class="page-hero__title">Route Guides & <span>Travel Tips</span></h1>
    <p class="page-hero__desc">
      Insider knowledge from the road. Practical guides, budget tips, and destination
      inspiration — written by people who drive these routes every day.
    </p>
  </div>
</div>

<section class="section section--light">
  <div class="container">

    {{-- Category filter --}}
    @if($categories->count() > 0)
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:28px;align-items:center">
      <span style="font-size:12px;color:var(--gray4);font-family:var(--ff-h);font-weight:600;margin-right:4px">Category:</span>
      <a href="{{ route('blog.index') }}"
         style="padding:7px 14px;border-radius:20px;font-size:12px;font-weight:600;border:1.5px solid;text-decoration:none;font-family:var(--ff-h);
                border-color:{{ $activeCategory==='' ? 'var(--navy)' : 'var(--gray2)' }};
                background:{{ $activeCategory==='' ? 'var(--navy)' : 'var(--white)' }};
                color:{{ $activeCategory==='' ? 'white' : 'var(--gray5)' }}">
        All
      </a>
      @foreach($categories as $cat)
      <a href="{{ route('blog.index', ['category' => $cat]) }}"
         style="padding:7px 14px;border-radius:20px;font-size:12px;font-weight:600;border:1.5px solid;text-decoration:none;font-family:var(--ff-h);
                border-color:{{ $activeCategory===$cat ? 'var(--navy)' : 'var(--gray2)' }};
                background:{{ $activeCategory===$cat ? 'var(--navy)' : 'var(--white)' }};
                color:{{ $activeCategory===$cat ? 'white' : 'var(--gray5)' }}">
        {{ $cat }}
      </a>
      @endforeach
    </div>
    @endif

    {{-- Posts grid --}}
    @if($posts->count() > 0)
    <div class="grid grid--3">
      @foreach($posts as $post)
      <article style="background:var(--white);border-radius:var(--r2);border:1.5px solid var(--gray2);overflow:hidden;transition:all .25s"
               onmouseover="this.style.borderColor='var(--gold)';this.style.transform='translateY(-4px)';this.style.boxShadow='0 14px 40px rgba(8,60,93,.12)'"
               onmouseout="this.style.borderColor='var(--gray2)';this.style.transform='translateY(0)';this.style.boxShadow='none'">

        {{-- Card header image --}}
        <div class="blog-{{ $post->display_bg }}"
             style="height:180px;display:flex;align-items:center;justify-content:center;font-size:68px;position:relative">
          <span aria-hidden="true">{{ $post->display_emoji }}</span>
          <span style="position:absolute;top:12px;left:12px;background:var(--navy3);color:white;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px;font-family:var(--ff-h)">
            {{ $post->category }}
          </span>
          <span style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,.4);color:rgba(255,255,255,.8);font-size:10px;padding:3px 8px;border-radius:10px;font-family:var(--ff-h)">
            {{ $post->views }} views
          </span>
        </div>

        {{-- Card body --}}
        <div style="padding:20px">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px">
            <span style="font-size:11px;color:var(--gray3);font-family:var(--ff-h)">{{ $post->short_date }}</span>
            <span style="color:var(--gray2)">·</span>
            <span style="font-size:11px;color:var(--gray3);font-family:var(--ff-h)">{{ $post->read_time }}</span>
          </div>

          <h3 style="font-family:var(--ff-h);font-size:.95rem;font-weight:800;color:var(--navy3);margin-bottom:8px;line-height:1.35">
            {{ $post->title }}
          </h3>

          <p style="font-size:13px;color:var(--gray4);line-height:1.65;margin-bottom:16px">
            {{ $post->excerpt }}
          </p>

          <a href="{{ route('blog.show', $post->slug) }}"
             style="font-size:12px;font-weight:700;color:var(--gold);font-family:var(--ff-h);text-decoration:none;display:inline-flex;align-items:center;gap:4px">
            Read Full Guide →
          </a>
        </div>

      </article>
      @endforeach
    </div>

    @else
    <div style="text-align:center;padding:60px 24px">
      <div style="font-size:40px;opacity:.3;margin-bottom:12px">✍️</div>
      <div style="font-family:var(--ff-h);font-size:1rem;font-weight:700;color:var(--gray5);margin-bottom:8px">
        No posts yet
      </div>
      <p style="font-size:14px;color:var(--gray4)">
        Travel guides are being written. Check back soon!
      </p>
    </div>
    @endif

  </div>
</section>

{{-- Newsletter / CTA --}}
<section style="background:var(--navy3);padding:60px 0">
  <div class="container">
    <div style="max-width:540px;margin:0 auto;text-align:center">
      <div style="font-size:32px;margin-bottom:14px">🗺️</div>
      <h2 style="font-family:var(--ff-h);font-size:1.5rem;font-weight:900;color:white;margin-bottom:10px">
        Ready to hit the road?
      </h2>
      <p style="font-size:14px;color:rgba(255,255,255,.55);margin-bottom:24px">
        Read the guide — then book your cab. RK Shah handles the rest.
      </p>
      <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <button onclick="openBookingModal()" class="btn btn--gold btn--lg">📞 Book Your Cab</button>
        <a href="{{ route('routes.index') }}" class="btn btn--outline-white btn--lg">🗺️ View All Routes</a>
      </div>
    </div>
  </div>
</section>

@endsection
