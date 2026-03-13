<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->username ?? $user->name }} - byoo.pro</title>
    <meta name="description" content="{{ $profile->bio ? Str::limit($profile->bio, 160) : $user->name . ' adlı kullanıcının byoo.pro profili.' }}">
    <link rel="canonical" href="{{ url('/' . $user->username) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Open Graph -->
    <meta property="og:type" content="profile">
    <meta property="og:title" content="{{ $user->name }} (@{{ $profile->username ?? $user->username }})">
    <meta property="og:description" content="{{ $profile->bio ? Str::limit($profile->bio, 160) : $user->name . ' - byoo.pro' }}">
    <meta property="og:url" content="{{ url('/' . $user->username) }}">
    @if($profile->avatar)
        <meta property="og:image" content="{{ asset('storage/' . $profile->avatar) }}">
    @else
        <meta property="og:image" content="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=512">
    @endif
    <meta property="og:site_name" content="byoo.pro">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $user->name }} - byoo.pro">
    <meta name="twitter:description" content="{{ $profile->bio ? Str::limit($profile->bio, 160) : $user->name . ' - byoo.pro' }}">
    @if($profile->avatar)
        <meta name="twitter:image" content="{{ asset('storage/' . $profile->avatar) }}">
    @else
        <meta name="twitter:image" content="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=512">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== THEME SYSTEM ===== */
        :root {
            --bg: #f9fafb;
            --text: #111827;
            --text-secondary: #6b7280;
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --card-hover: #f3f4f6;
            --card-shadow: 0 1px 3px rgba(0,0,0,0.1);
            --avatar-ring: #ffffff;
            --link-color: #374151;
            --footer-color: #9ca3af;
        }

        /* Minimal (default) */
        .theme-minimal { --bg: #f9fafb; --text: #111827; --text-secondary: #6b7280; --card-bg: #ffffff; --card-border: #e5e7eb; --card-hover: #f3f4f6; --avatar-ring: #ffffff; --link-color: #374151; --footer-color: #9ca3af; }

        /* Dark */
        .theme-dark { --bg: #0f172a; --text: #f1f5f9; --text-secondary: #94a3b8; --card-bg: #1e293b; --card-border: #334155; --card-hover: #334155; --avatar-ring: #334155; --link-color: #e2e8f0; --footer-color: #64748b; }

        /* Neon */
        .theme-neon { --bg: #0a0a0a; --text: #39ff14; --text-secondary: #00ff88; --card-bg: rgba(57,255,20,0.05); --card-border: #39ff14; --card-hover: rgba(57,255,20,0.15); --avatar-ring: #39ff14; --link-color: #39ff14; --footer-color: #00ff8866; }

        /* Glass */
        .theme-glass { --bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%); --text: #ffffff; --text-secondary: rgba(255,255,255,0.8); --card-bg: rgba(255,255,255,0.15); --card-border: rgba(255,255,255,0.25); --card-hover: rgba(255,255,255,0.25); --avatar-ring: rgba(255,255,255,0.5); --link-color: #ffffff; --footer-color: rgba(255,255,255,0.5); }

        /* Midnight */
        .theme-midnight { --bg: #1a1a2e; --text: #e0e0ff; --text-secondary: #8888bb; --card-bg: #16213e; --card-border: #0f3460; --card-hover: #0f3460; --avatar-ring: #e94560; --link-color: #e0e0ff; --footer-color: #535380; }

        /* Sunset */
        .theme-sunset { --bg: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #fda085 100%); --text: #ffffff; --text-secondary: rgba(255,255,255,0.85); --card-bg: rgba(255,255,255,0.2); --card-border: rgba(255,255,255,0.3); --card-hover: rgba(255,255,255,0.3); --avatar-ring: rgba(255,255,255,0.6); --link-color: #ffffff; --footer-color: rgba(255,255,255,0.5); }

        /* Aurora */
        .theme-aurora { --bg: linear-gradient(135deg, #0c3547 0%, #1a5e63 40%, #204060 100%); --text: #a7f3d0; --text-secondary: #6ee7b7; --card-bg: rgba(167,243,208,0.08); --card-border: rgba(167,243,208,0.2); --card-hover: rgba(167,243,208,0.15); --avatar-ring: #34d399; --link-color: #a7f3d0; --footer-color: rgba(110,231,183,0.4); }

        /* Forest */
        .theme-forest { --bg: #1a2f1a; --text: #d4edda; --text-secondary: #8fbc8f; --card-bg: #2d4a2d; --card-border: #3d6b3d; --card-hover: #3d6b3d; --avatar-ring: #5cb85c; --link-color: #d4edda; --footer-color: #6b8e6b; }

        /* Cyber */
        .theme-cyber { --bg: #0d0221; --text: #ff00ff; --text-secondary: #00ffff; --card-bg: rgba(255,0,255,0.05); --card-border: #ff00ff; --card-hover: rgba(255,0,255,0.12); --avatar-ring: #00ffff; --link-color: #ff00ff; --footer-color: #00ffff66; }

        /* Obsidian */
        .theme-obsidian { --bg: #121212; --text: #e0e0e0; --text-secondary: #888888; --card-bg: #1e1e1e; --card-border: #333333; --card-hover: #2a2a2a; --avatar-ring: #555555; --link-color: #cccccc; --footer-color: #555555; }

        /* Apply Theme */
        .theme-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 3rem 1rem;
        }

        /* Solid backgrounds */
        .theme-minimal .theme-page,
        .theme-dark .theme-page,
        .theme-neon .theme-page,
        .theme-midnight .theme-page,
        .theme-forest .theme-page,
        .theme-cyber .theme-page,
        .theme-obsidian .theme-page {
            background-color: var(--bg);
        }

        /* Gradient backgrounds */
        .theme-glass .theme-page,
        .theme-sunset .theme-page,
        .theme-aurora .theme-page {
            background: var(--bg);
        }

        .theme-name { color: var(--text); }
        .theme-username { color: var(--text-secondary); }
        .theme-bio { color: var(--text-secondary); }

        .theme-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--link-color);
            transition: all 0.2s ease;
        }
        .theme-card:hover {
            background: var(--card-hover);
            box-shadow: var(--card-shadow, none);
        }

        /* Glass effect for specific themes */
        .theme-glass .theme-card,
        .theme-sunset .theme-card,
        .theme-aurora .theme-card {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Neon glow */
        .theme-neon .theme-card:hover {
            box-shadow: 0 0 15px rgba(57, 255, 20, 0.3);
        }

        /* Cyber glow */
        .theme-cyber .theme-card:hover {
            box-shadow: 0 0 15px rgba(255, 0, 255, 0.3);
        }

        .theme-avatar-ring { box-shadow: 0 0 0 3px var(--avatar-ring); }
        .theme-footer { color: var(--footer-color); }
        .theme-empty { color: var(--text-secondary); background: var(--card-bg); border-color: var(--card-border); }
    </style>
</head>
@php
    $theme = $profile->theme ?? 'minimal';
@endphp
<body class="h-full theme-{{ $theme }}">
    <div class="theme-page">
        <div class="max-w-md w-full space-y-8">
            
            <!-- Profil Kartı -->
            <div class="text-center">
                <img class="mx-auto h-24 w-24 rounded-full object-cover theme-avatar-ring" src="{{ $profile->avatar_url }}" alt="{{ $user->name }}">
                
                <h2 class="mt-4 text-3xl font-extrabold tracking-tight theme-name">
                    {{ $user->name }}
                </h2>
                
                <p class="mt-1 text-sm font-medium theme-username">
                    {{ '@' . ($profile->username ?? $user->username) }}
                </p>

                @if($profile->bio)
                    <p class="mt-4 text-base leading-relaxed theme-bio">
                        {{ $profile->bio }}
                    </p>
                @endif
            </div>

            <!-- Linkler -->
            <div class="mt-8 space-y-4">
                @forelse($links as $link)
                    <a href="{{ route('public.redirect', $link->id) }}" target="_blank" rel="noopener noreferrer" 
                       class="flex items-center p-3 rounded-xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg theme-card group relative">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800/50 text-indigo-500 group-hover:scale-110 transition-transform">
                            @if($link->platform === 'instagram')
                                <i class="fab fa-instagram text-xl"></i>
                            @elseif($link->platform === 'twitter')
                                <i class="fab fa-twitter text-xl"></i>
                            @elseif($link->platform === 'facebook')
                                <i class="fab fa-facebook text-xl"></i>
                            @elseif($link->platform === 'linkedin')
                                <i class="fab fa-linkedin text-xl"></i>
                            @elseif($link->platform === 'youtube')
                                <i class="fab fa-youtube text-xl"></i>
                            @elseif($link->platform === 'tiktok')
                                <i class="fab fa-tiktok text-xl"></i>
                            @elseif($link->platform === 'whatsapp')
                                <i class="fab fa-whatsapp text-xl"></i>
                            @elseif($link->platform === 'github')
                                <i class="fab fa-github text-xl"></i>
                            @elseif($link->platform === 'telegram')
                                <i class="fab fa-telegram text-xl"></i>
                            @else
                                <i class="fas fa-link text-xl"></i>
                            @endif
                        </div>
                        <div class="flex-1 text-center font-bold pr-10">
                            {{ $link->title }}
                        </div>
                        @if($link->password)
                            <div class="absolute right-4 text-gray-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                        @endif
                    </a>
                @empty
                    <div class="text-center p-6 rounded-xl border border-dashed theme-empty">
                        <p>Bu profil henüz bir link eklememiş.</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="mt-12 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-semibold transition-colors theme-footer">
                    <span>by byoo.pro</span>
                </a>
            </div>
            
        </div>
    </div>
</body>
</html>
