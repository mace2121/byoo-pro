<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta
            name="description"
            content="byoo.pro ile link-in-bio sayfani blok builder, urun kartlari ve WhatsApp siparis akislariyla dakikalar icinde yayina al."
        >
        <meta
            name="keywords"
            content="link in bio, blok builder, whatsapp siparis, bio link, dijital vitrin, byoo"
        >
        <meta name="author" content="byoo.pro">

        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="byoo.pro | Linklerini mini bir web sitesine donustur">
        <meta
            property="og:description"
            content="Link, urun ve sosyal bloklarini tek bir canli sayfada topla. Tasarla, canli onizle ve saniyeler icinde yayina al."
        >
        <meta property="og:image" content="{{ asset('og-image.png') }}">

        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url('/') }}">
        <meta property="twitter:title" content="byoo.pro | Linklerini mini bir web sitesine donustur">
        <meta
            property="twitter:description"
            content="Linklerini, urunlerini ve WhatsApp siparis akisini tek sayfada yonet. byoo.pro ile hizli, modern ve donusum odakli profil sayfalari olustur."
        >
        <meta property="twitter:image" content="{{ asset('og-image.png') }}">

        <title>byoo.pro | Link-in-bio, blok builder ve canli tema deneyimi</title>

        <link rel="icon" href="{{ asset('brand/byoo-icon.svg') }}" type="image/svg+xml">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@500;600;700;800&display=swap"
            rel="stylesheet"
        >
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

        @include('partials.landing.styles')
        @include('partials.landing.scripts')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="landing-body antialiased">
        <div x-data="landingExperience()" x-init="init()" class="relative min-h-screen overflow-x-hidden">
            <div class="landing-grid-overlay"></div>
            <div class="landing-noise"></div>
            <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[38rem] bg-[radial-gradient(circle_at_top,rgba(0,255,204,0.18),transparent_38%),radial-gradient(circle_at_20%_20%,rgba(108,92,231,0.2),transparent_26%),linear-gradient(180deg,#07111d_0%,#040913_44%,#030712_100%)]"></div>
            <div class="pointer-events-none absolute left-[-8rem] top-40 -z-10 h-72 w-72 rounded-full bg-[#00ffcc]/10 blur-3xl"></div>
            <div class="pointer-events-none absolute right-[-10rem] top-[32rem] -z-10 h-80 w-80 rounded-full bg-[#6c5ce7]/20 blur-3xl"></div>

            @include('partials.landing.navbar')

            <div class="pointer-events-none fixed right-6 top-1/2 z-30 hidden -translate-y-1/2 xl:block 2xl:right-12">
                @include('partials.landing.phone-preview', ['wrapperClass' => 'w-[320px]'])
            </div>

            <main class="relative pb-24">
                @include('partials.landing.hero')
                @include('partials.landing.problem-solution')
                @include('partials.landing.builder-demo')
                @include('partials.landing.product-showcase')
                @include('partials.landing.customization-demo')
                @include('partials.landing.social-proof')
                @include('partials.landing.faq')
                @include('partials.landing.cta')
            </main>

            @include('partials.landing.footer')
        </div>
    </body>
</html>
