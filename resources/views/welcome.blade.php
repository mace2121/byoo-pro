<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta
            name="description"
            content="byoo.pro ile linklerini premium görünümlü tek bir vitrinde topla. Free ve Pro paketlerle profilini markana uygun bir bio sitesine dönüştür."
        >
        <meta
            name="keywords"
            content="byoo, link in bio, premium bio sitesi, verified badge, özel tema, analytics"
        >
        <meta name="author" content="byoo.pro">

        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="byoo.pro | Premium link-in-bio deneyimi">
        <meta
            property="og:description"
            content="Link, ürün, özel tema, verified badge ve analytics özelliklerini tek bir premium bio sayfasında birleştir."
        >
        <meta property="og:image" content="{{ asset('og-image.png') }}">

        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url('/') }}">
        <meta property="twitter:title" content="byoo.pro | Premium link-in-bio deneyimi">
        <meta
            property="twitter:description"
            content="Free ve Pro paketlerle premium bio sayfanı oluştur. Linklerini, ürünlerini ve markanı tek bir şık profilde sun."
        >
        <meta property="twitter:image" content="{{ asset('og-image.png') }}">

        <title>byoo.pro | Premium link-in-bio deneyimi</title>

        <link rel="icon" href="{{ asset('brand/byoo-icon.svg') }}" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap"
            rel="stylesheet"
        >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

        @include('partials.landing.styles')
        @include('partials.landing.scripts')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="landing-body antialiased">
        <div x-data="landingPage()" x-init="init()" class="relative min-h-screen overflow-x-hidden">
            <div class="landing-glow landing-glow-left"></div>
            <div class="landing-glow landing-glow-right"></div>
            <div class="landing-mesh"></div>

            @include('partials.landing.navbar')

            <main class="relative">
                @include('partials.landing.hero')
                @include('partials.landing.showcase')
                @include('partials.landing.features')
                @include('partials.landing.plans')
                @include('partials.landing.faq')
                @include('partials.landing.cta')
            </main>

            @include('partials.landing.footer')
        </div>
    </body>
</html>
