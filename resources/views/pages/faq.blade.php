@extends('layouts.app')

@section('title', 'FAQ — Cab Booking, Pricing & Driver Questions | RK Shah Car Rental Delhi')
@section('meta_description', 'Frequently asked questions about booking an outstation cab with RK Shah — pricing explained, what's included, driver credentials, cancellation policy, advance payment and more. All honest answers.')
@section('meta_keywords', 'cab rental FAQ Delhi, outstation taxi questions, car hire Delhi questions, cab booking Delhi help, what is included cab hire Delhi')
@section('og_title', 'FAQ — Everything You Need to Know About Booking | RK Shah Car Rental')
@section('og_description', 'Pricing, inclusions, driver credentials, cancellation policy — all your outstation cab questions answered honestly.')

@section('content')

{{-- Hero --}}
<div class="page-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb__sep">›</span>
      <span class="breadcrumb__current">FAQ</span>
    </nav>
    <span class="page-hero__eyebrow">Help Centre</span>
    <h1 class="page-hero__title">Frequently Asked <span>Questions</span></h1>
    <p class="page-hero__desc">
      Everything you need to know before booking your trip with RK Shah Car Rental.
    </p>
  </div>
</div>

<section class="section section--light">
  <div class="container" style="max-width:800px">

    {{-- Category navigation --}}
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:32px">
      @foreach($categories as $i => $cat)
      <a href="#category-{{ $i }}"
         style="display:flex;align-items:center;gap:6px;padding:8px 16px;border-radius:20px;font-size:12px;font-weight:600;border:1.5px solid var(--gray2);background:var(--white);color:var(--gray5);text-decoration:none;font-family:var(--ff-h);transition:all .2s"
         onmouseover="this.style.borderColor='var(--navy)';this.style.color='var(--navy)'"
         onmouseout="this.style.borderColor='var(--gray2)';this.style.color='var(--gray5)'">
        <span>{{ $cat['icon'] }}</span>
        {{ $cat['title'] }}
      </a>
      @endforeach
    </div>

    {{-- FAQ Categories --}}
    @foreach($categories as $i => $cat)
    <div id="category-{{ $i }}" style="margin-bottom:44px;scroll-margin-top:100px">

      <h2 style="font-family:var(--ff-h);font-size:1rem;font-weight:800;color:var(--navy3);margin-bottom:16px;display:flex;align-items:center;gap:10px;padding-bottom:10px;border-bottom:2px solid var(--gold-mid)">
        <span style="font-size:20px">{{ $cat['icon'] }}</span>
        {{ $cat['title'] }}
      </h2>

      @foreach($cat['faqs'] as $j => $faq)
      <div class="faq-item"
           style="border:1.5px solid var(--gray2);border-radius:var(--r2);margin-bottom:8px;overflow:hidden;cursor:pointer;transition:border-color .2s"
           id="faq-{{ $i }}-{{ $j }}">

        <div class="faq-q"
             style="display:flex;align-items:center;justify-content:space-between;padding:18px 20px;font-family:var(--ff-h);font-size:.92rem;font-weight:700;color:var(--navy3);gap:16px;user-select:none">
          {{ $faq['q'] }}
          <span class="faq-icon"
                style="font-size:20px;color:var(--gold);flex-shrink:0;transition:.25s;line-height:1">+</span>
        </div>

        <div class="faq-a"
             style="display:none;padding:0 20px 18px;font-size:14px;color:var(--gray5);line-height:1.75;border-top:1px solid var(--gray2);padding-top:14px;margin-top:0">
          {{ $faq['a'] }}
        </div>

      </div>
      @endforeach

    </div>
    @endforeach

    {{-- Still have questions --}}
    <div style="background:var(--white);border-radius:var(--r3);border:1.5px solid var(--gray2);padding:36px;text-align:center;margin-top:8px">
      <div style="font-size:36px;margin-bottom:14px">🤝</div>
      <h3 style="font-family:var(--ff-h);font-size:1.1rem;font-weight:800;color:var(--navy3);margin-bottom:8px">
        Still have questions?
      </h3>
      <p style="font-size:14px;color:var(--gray4);margin-bottom:24px;max-width:400px;margin-left:auto;margin-right:auto;line-height:1.7">
        Call or WhatsApp RK Shah directly — every question is answered personally. No bots, no scripts.
      </p>
      <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
        <a href="tel:+919324555165" class="btn btn--navy btn--lg">📞 +91 93245 55165</a>
        <a href="https://wa.me/919324555165" class="btn btn--gold btn--lg" target="_blank" rel="noopener">💬 WhatsApp</a>
      </div>
    </div>

  </div>
</section>

@endsection

@push('scripts')
<script>
  // FAQ accordion — open/close with smooth animation
  document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', () => {
      const isOpen  = item.classList.contains('is-open');
      const answer  = item.querySelector('.faq-a');
      const icon    = item.querySelector('.faq-icon');

      // Close all others
      document.querySelectorAll('.faq-item.is-open').forEach(other => {
        other.classList.remove('is-open');
        other.querySelector('.faq-a').style.display  = 'none';
        other.querySelector('.faq-icon').textContent = '+';
        other.querySelector('.faq-icon').style.transform = 'rotate(0deg)';
        other.style.borderColor = 'var(--gray2)';
      });

      // Toggle current
      if (!isOpen) {
        item.classList.add('is-open');
        answer.style.display       = 'block';
        icon.textContent           = '×';
        icon.style.transform       = 'rotate(90deg)';
        item.style.borderColor     = 'var(--navy)';
      }
    });
  });
</script>
@endpush
