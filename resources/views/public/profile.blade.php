<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->meta_title ?: ($profile->username ?? $user->name) . ' - byoo.pro' }}</title>
    <meta name="description" content="{{ $profile->meta_description ?: ($profile->bio ? Str::limit($profile->bio, 160) : $user->name . ' adlı kullanıcının byoo.pro profili.') }}">
    <meta name="robots" content="index, follow">
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
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $user->name }} - byoo.pro">
    <meta name="twitter:description" content="{{ $profile->bio ? Str::limit($profile->bio, 160) : $user->name . ' - byoo.pro' }}">
    @if($profile->avatar)
        <meta name="twitter:image" content="{{ asset('storage/' . $profile->avatar) }}">
    @else
        <meta name="twitter:image" content="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=512">
    @endif

    <!-- Theme Fonts -->
    @if($profile->theme_type === 'custom')
        @php
            $google_fonts = [
                'outfit' => 'Outfit:wght@400;500;600;700;800',
                'inter' => 'Inter:wght@400;500;600;700;800',
                'roboto' => 'Roboto:wght@400;500;700',
                'montserrat' => 'Montserrat:wght@400;500;600;700',
                'playfair' => 'Playfair+Display:wght@400;700',
            ];
            $selected_font = $profile->font_family;
            $font_query = $google_fonts[$selected_font] ?? null;
        @endphp

        @if($font_query)
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family={{ $font_query }}&display=swap" rel="stylesheet">
        @endif
    @endif

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
            --font-family: 'Inter', sans-serif;
            --btn-radius: 0.75rem; /* rounded-xl */
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

        /* Custom Theme Overrides */
        @if(($design['theme']['custom_theme'] ?? false) || $profile->theme_type === 'custom')
        .theme-custom {
            @php
                $bgType = $design['background']['type'] ?? $profile->bg_type ?? 'color';
                $bgColor = $design['background']['color'] ?? $profile->bg_color ?? '#f9fafb';
                $bgGradient = $design['background']['gradient'] ?? $profile->bg_gradient ?? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                
                $textColor = $design['colors']['text'] ?? $profile->text_color ?? '#111827';
                
                $btnColor = $design['buttons']['bg_color'] ?? $profile->button_color ?? '#ffffff';
                $btnTextColor = $design['buttons']['text_color'] ?? $profile->button_text_color ?? '#111827';
                $btnShadow = $design['buttons']['shadow'] ?? $profile->button_shadow ?? true;
                $btnStyle = $design['buttons']['style'] ?? $profile->button_style ?? 'pill';
                
                $fontFamily = $design['theme']['font_family'] ?? $profile->font_family ?? 'inter';
            @endphp
            
            @if($bgType === 'color')
                --bg: {{ $bgColor }};
            @elseif($bgType === 'gradient')
                --bg: {{ $bgGradient }};
            @endif
            --text: {{ $textColor }};
            --text-secondary: {{ $textColor . 'cc' }}; /* 80% opacity */
            --card-bg: {{ $btnColor }};
            --card-border: transparent;
            --card-hover: {{ $btnColor . 'ee' }};
            --link-color: {{ $btnTextColor }};
            --footer-color: {{ $textColor . '88' }};
            --card-shadow: {{ $btnShadow ? '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)' : 'none' }};
            
            @if($fontFamily === 'outfit')
                --font-family: 'Outfit', sans-serif;
            @elseif($fontFamily === 'inter')
                --font-family: 'Inter', sans-serif;
            @elseif($fontFamily === 'roboto')
                --font-family: 'Roboto', sans-serif;
            @elseif($fontFamily === 'montserrat')
                --font-family: 'Montserrat', sans-serif;
            @elseif($fontFamily === 'playfair')
                --font-family: 'Playfair Display', serif;
            @elseif($fontFamily === 'serif')
                --font-family: Georgia, serif;
            @elseif($fontFamily === 'mono')
                --font-family: 'JetBrains Mono', SFMono-Regular, Consolas, monospace;
            @endif

            @if($btnStyle === 'pill')
                --btn-radius: 9999px;
            @elseif($btnStyle === 'square')
                --btn-radius: 0px;
            @elseif($btnStyle === 'soft')
                --btn-radius: 2rem;
            @endif
        }
        @endif

        /* Apply Styles */
        body { font-family: var(--font-family); }

        .theme-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 3rem 1rem;
            position: relative;
            background: var(--bg);
            @if((($design['theme']['custom_theme'] ?? false) || $profile->theme_type === 'custom') && ($design['background']['type'] ?? $profile->bg_type ?? '') === 'image')
                background-image: url('{{ $design['background']['image_url'] ?? $profile->bg_image_url ?? '' }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            @endif
        }

        @if((($design['theme']['custom_theme'] ?? false) || $profile->theme_type === 'custom') && ($design['background']['type'] ?? $profile->bg_type ?? '') === 'image')
        .theme-page::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0, {{ ($design['background']['overlay'] ?? 0) / 100 }});
            backdrop-filter: blur({{ $design['background']['blur'] ?? 0 }}px);
            -webkit-backdrop-filter: blur({{ $design['background']['blur'] ?? 0 }}px);
            z-index: 0;
        }
        .theme-page > div { position: relative; z-index: 10; }
        @endif

        /* Solid backgrounds for presets */
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
            border-radius: var(--btn-radius);
            transition: all 0.2s ease;
        }
        .theme-card:hover {
            background: var(--card-hover);
            box-shadow: var(--card-shadow, none);
        }

        /* Custom CSS Injection */
        {!! $profile->custom_css !!}

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
        .avatar-polygon { clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); }
        .theme-footer { color: var(--footer-color); }
        .theme-empty { color: var(--text-secondary); background: var(--card-bg); border-color: var(--card-border); }
    </style>
</head>
@php
    $design = $profile->design_settings ?? [];
    
    // Theme Defaults & Overrides
    $theme = $profile->theme ?? 'minimal';
    if(isset($design['theme']) && !empty($design['theme'])) {
        if(($design['theme']['custom_theme'] ?? false) == true) {
            $theme = 'custom';
            $profile->theme_type = 'custom'; // For backward compatibility with CSS blocks below
        } else if(isset($design['theme']['preset'])) {
            $theme = $design['theme']['preset'];
            $profile->theme_type = 'preset';
        }
    }
    $headerLayout = $design['header']['layout'] ?? 'centered-classic';
    $avatarSize = $design['header']['avatar_size'] ?? 'md';
    $avatarFrame = $design['header']['avatar_frame'] ?? 'circle';
    $showName = $design['header']['show_name'] ?? true;
    $showUsername = $design['header']['show_username'] ?? true;
    $showBio = $design['header']['show_bio'] ?? true;

    // Avatar Size Mapping
    $avatarClasses = '';
    switch($avatarSize) {
        case 'sm': $avatarClasses = 'w-16 h-16'; break;
        case 'lg': $avatarClasses = 'w-32 h-32'; break;
        case 'xl': $avatarClasses = 'w-40 h-40'; break;
        case 'md':
        default: $avatarClasses = 'w-24 h-24'; break;
    }

    // Avatar Frame Mapping
    $frameClasses = '';
    switch($avatarFrame) {
        case 'rounded-xl': $frameClasses = 'rounded-xl'; break;
        case 'square': $frameClasses = 'rounded-none'; break;
        case 'polygon': $frameClasses = 'avatar-polygon'; break;
        case 'circle':
        default: $frameClasses = 'rounded-full'; break;
    }

    // Layout Classes
    $layoutWrapperClass = 'text-center';
    $layoutFlexClass = 'flex flex-col items-center';
    $heroCoverClass = '';
    
    if ($headerLayout === 'left-aligned') {
        $layoutWrapperClass = 'text-left';
        $layoutFlexClass = 'flex flex-row items-center gap-6';
    } elseif ($headerLayout === 'hero-cover') {
        $layoutWrapperClass = 'text-center relative pt-12 mt-16';
        $layoutFlexClass = 'flex flex-col items-center';
        $heroCoverClass = 'absolute top-0 left-0 w-full h-32 bg-foreground/10 rounded-t-3xl';
    }
@endphp
<body class="h-full theme-{{ $theme }} {{ $profile->theme_type === 'custom' ? 'theme-custom' : '' }}">
    <div class="theme-page">
        <div class="max-w-md w-full space-y-8 relative {{ $headerLayout === 'hero-cover' ? 'pt-16' : '' }}">
            
            @if($headerLayout === 'hero-cover')
                <div class="absolute top-0 left-[-2rem] right-[-2rem] h-40 bg-card/30 backdrop-blur-md rounded-b-[3rem] border-b border-card-border pointer-events-none z-0"></div>
            @endif

            <!-- Profil Kartı -->
            <div class="{{ $layoutWrapperClass }} relative z-10 p-2">
                <div class="{{ $layoutFlexClass }}">
                    <!-- Avatar -->
                    <img class="{{ $avatarClasses }} {{ $frameClasses }} object-cover theme-avatar-ring flex-shrink-0 {{ $headerLayout === 'hero-cover' ? 'w-32 h-32 -mt-20 border-4 border-background bg-background shadow-xl' : '' }} {{ $headerLayout === 'left-aligned' ? 'w-20 h-20' : '' }}" 
                         src="{{ $profile->avatar_url }}" alt="{{ $user->name }}">
                    
                    <!-- Text Info -->
                    <div class="{{ $headerLayout === 'left-aligned' ? 'flex-1 pt-1' : 'w-full' }}">
                        @if($showName)
                            <h2 class="{{ $headerLayout === 'hero-cover' ? 'mt-6 text-4xl' : 'mt-4 text-3xl' }} font-extrabold tracking-tight theme-name break-words">
                                {{ $user->name }}
                            </h2>
                        @endif
                        
                        @if($showUsername)
                            <p class="{{ $headerLayout === 'left-aligned' ? 'mt-0.5' : 'mt-1' }} text-sm font-medium theme-username opacity-80">
                                {{ '@' . ($profile->username ?? $user->username) }}
                            </p>
                        @endif

                        @if($showBio && $profile->bio)
                            <p class="{{ $headerLayout === 'hero-cover' ? 'mt-6 px-4' : 'mt-4' }} {{ $headerLayout === 'left-aligned' ? 'text-sm' : 'text-base' }} leading-relaxed theme-bio text-center md:{{ $headerLayout === 'left-aligned' ? 'text-left' : 'text-center' }}">
                                {{ $profile->bio }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Linkler -->
            <div class="mt-8 space-y-4">
                @forelse($links as $link)
                    <a href="{{ route('public.redirect', $link->id) }}" target="_blank" rel="noopener noreferrer" 
                       class="flex items-center p-3 rounded-xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg theme-card group relative">
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800/50 text-indigo-500 group-hover:scale-110 transition-transform">
                            <i class="{{ $link->icon_class }} text-xl"></i>
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

    @if(request()->headers->has('referer') && str_contains(request()->headers->get('referer'), '/dashboard'))
    <script>
        // Sadece iframe içindeyken (dashboard'dan geliyorsa) çalışır
        window.addEventListener('message', (event) => {
            if (event.data?.type === 'DESIGN_UPDATE') {
                const design = event.data.payload;
                if (!design || !design.header) return;

                const header = design.header;
                const avatarImg = document.querySelector('img[alt="{{ $user->name }}"]');
                const nameEl = document.querySelector('.theme-name');
                const usernameEl = document.querySelector('.theme-username');
                const bioEl = document.querySelector('.theme-bio');
                const cardWrapper = avatarImg?.closest('.relative.z-10');
                const flexContainer = avatarImg?.parentElement;
                const heroCover = document.querySelector('.bg-card\\/30.backdrop-blur-md');
                const maxWContainer = document.querySelector('.max-w-md');
                const textWrapper = nameEl?.parentElement;

                // 1. Avatar Size
                if (avatarImg) {
                    avatarImg.classList.remove('w-16', 'h-16', 'w-24', 'h-24', 'w-32', 'h-32', 'w-40', 'h-40');
                    if (header.layout === 'hero-cover') {
                        avatarImg.classList.add('w-32', 'h-32'); 
                    } else if (header.layout === 'left-aligned') {
                        avatarImg.classList.add('w-20', 'h-20');
                    } else {
                        switch(header.avatar_size) {
                            case 'sm': avatarImg.classList.add('w-16', 'h-16'); break;
                            case 'lg': avatarImg.classList.add('w-32', 'h-32'); break;
                            case 'xl': avatarImg.classList.add('w-40', 'h-40'); break;
                            case 'md':
                            default: avatarImg.classList.add('w-24', 'h-24'); break;
                        }
                    }
                }

                // 2. Avatar Frame
                if (avatarImg) {
                    avatarImg.classList.remove('rounded-full', 'rounded-xl', 'rounded-none', 'avatar-polygon');
                    switch(header.avatar_frame) {
                        case 'rounded-xl': avatarImg.classList.add('rounded-xl'); break;
                        case 'square': avatarImg.classList.add('rounded-none'); break;
                        case 'polygon': avatarImg.classList.add('avatar-polygon'); break;
                        case 'circle':
                        default: avatarImg.classList.add('rounded-full'); break;
                    }
                }

                // 3. Visibility
                if (nameEl) nameEl.style.display = header.show_name ? 'block' : 'none';
                if (usernameEl) usernameEl.style.display = header.show_username ? 'block' : 'none';
                if (bioEl) bioEl.style.display = header.show_bio ? 'block' : 'none';

                // 4. Layout
                if (cardWrapper && flexContainer && maxWContainer && textWrapper && avatarImg) {
                    // Reset all specific layout classes
                    cardWrapper.className = 'relative z-10 p-2';
                    flexContainer.className = '';
                    avatarImg.classList.remove('-mt-20', 'border-4', 'border-background', 'bg-background', 'shadow-xl');
                    maxWContainer.classList.remove('pt-16');
                    textWrapper.className = '';
                    if (nameEl) nameEl.className = 'font-extrabold tracking-tight theme-name break-words';
                    if (usernameEl) usernameEl.className = 'font-medium theme-username opacity-80';
                    if (bioEl) bioEl.className = 'leading-relaxed theme-bio';

                    if (heroCover) heroCover.style.display = 'none';

                    if (header.layout === 'left-aligned') {
                        cardWrapper.classList.add('text-left');
                        flexContainer.classList.add('flex', 'flex-row', 'items-center', 'gap-6');
                        textWrapper.classList.add('flex-1', 'pt-1');
                        if (nameEl) nameEl.classList.add('mt-4', 'text-3xl');
                        if (usernameEl) usernameEl.classList.add('mt-0.5', 'text-sm');
                        if (bioEl) bioEl.classList.add('mt-4', 'text-sm', 'text-left', 'md:text-left');
                    } else if (header.layout === 'hero-cover') {
                        cardWrapper.classList.add('text-center', 'relative', 'pt-12', 'mt-16');
                        flexContainer.classList.add('flex', 'flex-col', 'items-center');
                        maxWContainer.classList.add('pt-16');
                        avatarImg.classList.add('-mt-20', 'border-4', 'border-background', 'bg-background', 'shadow-xl');
                        textWrapper.classList.add('w-full');
                        if (nameEl) nameEl.classList.add('mt-6', 'text-4xl');
                        if (usernameEl) usernameEl.classList.add('mt-1', 'text-sm');
                        if (bioEl) bioEl.classList.add('mt-6', 'px-4', 'text-base', 'text-center', 'md:text-center');
                        
                        if (heroCover) {
                            heroCover.style.display = 'block';
                        } else {
                            // Dinamik olarak hero cover ekle
                            const newHeroCover = document.createElement('div');
                            newHeroCover.className = 'absolute top-0 left-[-2rem] right-[-2rem] h-40 bg-card/30 backdrop-blur-md rounded-b-[3rem] border-b border-card-border pointer-events-none z-0';
                            maxWContainer.insertBefore(newHeroCover, cardWrapper);
                        }
                    } else { // centered-classic
                        cardWrapper.classList.add('text-center');
                        flexContainer.classList.add('flex', 'flex-col', 'items-center');
                        textWrapper.classList.add('w-full');
                        if (nameEl) nameEl.classList.add('mt-4', 'text-3xl');
                        if (usernameEl) usernameEl.classList.add('mt-1', 'text-sm');
                        if (bioEl) bioEl.classList.add('mt-4', 'text-base', 'text-center', 'md:text-center');
                    }
                }

                // 5. Theme Updates
                if (design.theme) {
                    const bodyEl = document.body;
                    
                    if (!design.theme.custom_theme && design.theme.preset) {
                        bodyEl.classList.remove('theme-custom');
                        // Mevcut preset temasını bul ve kaldır (theme-X formatında)
                        const classes = Array.from(bodyEl.classList);
                        classes.forEach(c => {
                            if(c.startsWith('theme-') && c !== 'theme-page') {
                                bodyEl.classList.remove(c);
                            }
                        });
                        
                        // Yeni temayı ekle
                        bodyEl.classList.add(`theme-${design.theme.preset}`);
                    } else if (design.theme.custom_theme) {
                        bodyEl.classList.add('theme-custom');
                        
                        // Set CSS variables for Live Preview based on design draft
                        const bgType = design.background?.type || 'color';
                        const bgColor = design.background?.color || '#f9fafb';
                        const bgGradient = design.background?.gradient || 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                        const bgImage = design.background?.image_url || '';
                        const bgOverlay = design.background?.overlay || 0;
                        const bgBlur = design.background?.blur || 0;
                        
                        const textColor = design.colors?.text || '#111827';
                        
                        const btnColor = design.buttons?.bg_color || '#ffffff';
                        const btnTextColor = design.buttons?.text_color || '#111827';
                        const btnShadow = design.buttons?.shadow ?? true;
                        const btnStyle = design.buttons?.style || 'pill';
                        
                        const fontFamily = design.theme?.font_family || 'inter';

                        // Background
                        const themePage = document.querySelector('.theme-page');
                        if (bgType === 'color') {
                            document.documentElement.style.setProperty('--bg', bgColor);
                            if(themePage) {
                                themePage.style.backgroundImage = 'none';
                                themePage.style.backgroundColor = 'var(--bg)';
                            }
                        } else if (bgType === 'gradient') {
                            document.documentElement.style.setProperty('--bg', bgGradient);
                            if(themePage) {
                                themePage.style.backgroundImage = 'none';
                                themePage.style.background = 'var(--bg)';
                            }
                        } else if (bgType === 'image') {
                            if(themePage) {
                                themePage.style.background = 'none';
                                themePage.style.backgroundImage = `url('${bgImage}')`;
                                themePage.style.backgroundSize = 'cover';
                                themePage.style.backgroundPosition = 'center';
                                themePage.style.backgroundAttachment = 'fixed';
                            }
                        }

                        // Background Overlay/Blur (Requires pseudo-element handling or wrapper div)
                        // Note: Inline styles can't edit ::before directly. So we find/create the pseudo-overlay instead.
                        if (themePage) {
                            let overlayEl = themePage.querySelector('.bg-dynamic-overlay');
                            if (bgType === 'image') {
                                if (!overlayEl) {
                                    overlayEl = document.createElement('div');
                                    overlayEl.className = 'bg-dynamic-overlay absolute inset-0 z-0 pointer-events-none';
                                    themePage.insertBefore(overlayEl, themePage.firstChild);
                                }
                                overlayEl.style.backgroundColor = `rgba(0, 0, 0, ${bgOverlay / 100})`;
                                overlayEl.style.backdropFilter = `blur(${bgBlur}px)`;
                                overlayEl.style.webkitBackdropFilter = `blur(${bgBlur}px)`;
                            } else {
                                if (overlayEl) overlayEl.remove();
                            }
                        }

                        // Text & Cards
                        document.documentElement.style.setProperty('--text', textColor);
                        document.documentElement.style.setProperty('--text-secondary', textColor + 'cc');
                        document.documentElement.style.setProperty('--card-bg', btnColor);
                        document.documentElement.style.setProperty('--card-hover', btnColor + 'ee');
                        document.documentElement.style.setProperty('--link-color', btnTextColor);
                        document.documentElement.style.setProperty('--footer-color', textColor + '88');
                        document.documentElement.style.setProperty('--card-shadow', btnShadow ? '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)' : 'none');

                        // Buttons Border Radius
                        if (btnStyle === 'pill') document.documentElement.style.setProperty('--btn-radius', '9999px');
                        else if (btnStyle === 'square') document.documentElement.style.setProperty('--btn-radius', '0px');
                        else if (btnStyle === 'soft') document.documentElement.style.setProperty('--btn-radius', '2rem');

                        // Font
                        if (fontFamily === 'outfit') document.documentElement.style.setProperty('--font-family', "'Outfit', sans-serif");
                        else if (fontFamily === 'inter') document.documentElement.style.setProperty('--font-family', "'Inter', sans-serif");
                        else if (fontFamily === 'roboto') document.documentElement.style.setProperty('--font-family', "'Roboto', sans-serif");
                        else if (fontFamily === 'montserrat') document.documentElement.style.setProperty('--font-family', "'Montserrat', sans-serif");
                        else if (fontFamily === 'playfair') document.documentElement.style.setProperty('--font-family', "'Playfair Display', serif");
                        else if (fontFamily === 'serif') document.documentElement.style.setProperty('--font-family', "Georgia, serif");
                        else if (fontFamily === 'mono') document.documentElement.style.setProperty('--font-family', "'JetBrains Mono', monospace");
                    }
                }
            }
        });
    </script>
    @endif
</body>
</html>
