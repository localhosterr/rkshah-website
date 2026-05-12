<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta --}}
    <title>@yield('title', 'RK Shah Car Rental') | Your Travel Partner — Delhi</title>
    <meta name="description"
        content="@yield('meta_description', 'Delhi\'s trusted outstation cab service. Book Innova Crysta, Kia Carens, Ertiga, Swift Dzire. All-inclusive pricing, verified drivers. Call +91 93245 55165.')">
    <meta name="keywords"
        content="@yield('meta_keywords', 'car rental delhi, outstation cab delhi, innova crysta rental, delhi to agra cab, delhi to jaipur cab')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', 'RK Shah Car Rental — Your Travel Partner')">
    <meta property="og:description"
        content="@yield('og_description', 'Delhi\'s trusted outstation cab. All-inclusive pricing. +91 93245 55165')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="@yield('og_image', asset('images/logo/footer-logo.jpg'))">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo/favicon.jpg') }}">

    {{-- Schema.org LocalBusiness Markup — Boosts Google Maps and local search ranking --}}
    @verbatim
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "RK Shah Car Rental Services",
        "description": "Delhi's trusted outstation cab service since 2015. Innova Crysta, Kia Carens, Ertiga, Swift Dzire. Verified drivers, transparent pricing.",
        "url": "https://www.rkshahcarrental.in",
        "telephone": "+919324555165",
        "email": "info.rkshahcarrental@gmail.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Soniya Vihar",
            "addressLocality": "Delhi",
            "postalCode": "110094",
            "addressCountry": "IN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "28.7041",
            "longitude": "77.1025"
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            "opens": "06:00",
            "closes": "23:00"
        },
        "priceRange": "₹₹",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.9",
            "reviewCount": "180"
        },
        "sameAs": [
            "https://wa.me/919324555165"
        ]
    }
    </script>
    @endverbatim


    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    @stack('styles')


</head>

<body class="{{ $bodyClass ?? '' }}">

    {{-- Navigation --}}
    @include('partials._navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials._footer')

    {{-- Booking Modal (global) --}}
    @include('partials._booking-modal')

    {{-- Floating Buttons --}}
    @include('partials._floating-btns')

    {{-- JS --}}
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/booking.js') }}" defer></script>
    @stack('scripts')

</body>

</html>