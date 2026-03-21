<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('brand/byoo-icon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900">
        <div class="flex min-h-screen">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-indigo-600 items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-700 opacity-90"></div>
                <!-- Background Pattern -->
                <div class="absolute inset-0" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px; opacity: 0.1;"></div>
                
                <div class="relative z-10 text-white flex flex-col items-center px-8 text-center">
                    <a href="/" class="mb-8 block">
                        <x-application-logo class="w-24 h-24 text-white drop-shadow-lg" />
                    </a>
                    <h2 class="text-4xl font-extrabold tracking-tight mb-4">Link-in-bio'nun<br>En Gelişmiş Hali</h2>
                    <p class="text-indigo-100 max-w-sm text-lg leading-relaxed">Tüm linklerinizi, ürünlerinizi ve iletişim kanallarınızı tek bir sayfada toplayın, kitlenizi büyütün.</p>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-white dark:bg-gray-900 relative">
                <!-- Mobile Logo -->
                <div class="absolute top-8 left-8 lg:hidden">
                    <a href="/">
                        <x-application-logo class="w-12 h-12 text-indigo-600 dark:text-indigo-400" />
                    </a>
                </div>
                
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
