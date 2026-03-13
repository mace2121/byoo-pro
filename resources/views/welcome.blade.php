<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="byoo.pro - Tüm linklerini tek bir sayfada topla, paylaş ve takip et. Ücretsiz kayıt ol!">
        <meta name="keywords" content="linktree, bio link, biyo link, link paylaşımı, dijital kartvizit, byoo">
        <meta name="author" content="byoo.pro">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="byoo.pro - Linklerini Tek Sayfada Topla">
        <meta property="og:description" content="Tüm linklerini tek bir sayfada topla, paylaş ve takip et. Saniyeler içinde kendi sayfanı oluştur.">
        <meta property="og:image" content="{{ asset('og-image.png') }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url('/') }}">
        <meta property="twitter:title" content="byoo.pro - Linklerini Tek Sayfada Topla">
        <meta property="twitter:description" content="Tüm linklerini tek bir sayfada topla, paylaş ve takip et. Saniyeler içinde kendi sayfanı oluştur.">
        <meta property="twitter:image" content="{{ asset('og-image.png') }}">
        
        <title>byoo.pro - Linklerini Tek Sayfada Topla</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            body { font-family: 'Inter', sans-serif; }
            .animate-fade-in {
                animation: fadeIn 0.8s ease-out forwards;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased">
        
        @include('partials.landing.navbar')

        <main>
            @include('partials.landing.hero')
            @include('partials.landing.features')
            @include('partials.landing.showcase')
            @include('partials.landing.faq')
        </main>

        @include('partials.landing.footer')

    </body>
</html>
