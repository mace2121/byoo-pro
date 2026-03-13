<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="byoo.pro - Tüm linklerini tek bir sayfada topla ve paylaş.">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ config('app.name', 'byoo.pro') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <style>
            /* Minimalist Scrollbar */
            ::-webkit-scrollbar { width: 6px; height: 6px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 10px; }
            ::-webkit-scrollbar-thumb:hover { background: #d1d5db; }
            .dark ::-webkit-scrollbar-thumb { background: #374151; }
            .dark ::-webkit-scrollbar-thumb:hover { background: #4b5563; }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100 bg-white dark:bg-black selection:bg-black selection:text-white">
        @if(session('impersonator_id'))
            <div class="bg-black text-white py-2 px-4 flex items-center justify-between sticky top-0 z-50 shadow-lg border-b border-white/10">
                <div class="flex items-center gap-2">
                    <i class="fas fa-user-secret w-4 h-4"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">
                        {{ __('Impersonating') }}: <span class="text-gray-400">{{ auth()->user()->name }}</span>
                    </span>
                </div>
                <a href="{{ route('admin.stop-impersonating') }}" class="bg-white/10 hover:bg-white/20 text-white px-3 py-1 rounded-lg text-xs font-black uppercase transition-all">
                    {{ __('Stop') }}
                </a>
            </div>
        @endif
        <div class="min-h-screen" x-data="{ sidebarOpen: true }">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
