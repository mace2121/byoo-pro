@php
    $design = $profile->design_settings ?? [];
    
    // Theme Defaults & Overrides
    $theme = $profile->theme ?? 'minimal';
    if(isset($design['theme']) && !empty($design['theme'])) {
        if(($design['theme']['custom_theme'] ?? false) == true) {
            $theme = 'custom';
            $profile->theme_type = 'custom'; 
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
        $heroCoverClass = 'absolute top-0 left-0 w-full h-48 bg-cover bg-center rounded-t-[3rem] border-b border-white/10 shadow-lg';
    }
@endphp
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
                
                $titleColor = $design['colors']['title'] ?? $profile->title_color ?? ($design['colors']['text'] ?? $profile->text_color ?? '#111827');
                $pageTextColor = $design['colors']['page_text'] ?? $profile->page_text_color ?? ($design['colors']['text'] ?? $profile->text_color ?? '#111827');
                
                $btnColor = $design['buttons']['bg_color'] ?? $profile->button_color ?? '#ffffff';
                $btnTextColor = $design['buttons']['text_color'] ?? $profile->button_text_color ?? '#111827';
                $btnShadow = $design['buttons']['shadow'] ?? $profile->button_shadow ?? true;
                $btnStyle = $design['buttons']['style'] ?? $profile->button_style ?? 'pill';
                $btnVariant = $design['buttons']['variant'] ?? $profile->button_variant ?? 'solid';
                $btnAlign = $design['buttons']['align'] ?? $profile->button_align ?? 'center';
                
                $fontFamily = $design['theme']['font_family'] ?? $profile->font_family ?? 'inter';
            @endphp
            
            @if($bgType === 'color')
                --bg: {{ $bgColor }};
            @elseif($bgType === 'gradient')
                --bg: {{ $bgGradient }};
            @endif
            --text-title: {{ $titleColor }};
            --text-page: {{ $pageTextColor }};
            --text-secondary: {{ $pageTextColor . 'cc' }};
            --card-bg: {{ $btnVariant === 'outline' ? 'transparent' : ($btnVariant === 'glass' ? 'rgba(255,255,255,0.1)' : $btnColor) }};
            --card-border: {{ $btnVariant === 'outline' ? $btnColor : 'transparent' }};
            --card-hover: {{ $btnVariant === 'outline' ? $btnColor . '11' : ($btnVariant === 'glass' ? 'rgba(255,255,255,0.2)' : $btnColor . 'ee') }};
            --link-color: {{ $btnVariant === 'outline' ? $btnColor : $btnTextColor }};
            --footer-color: {{ $pageTextColor . '88' }};
            --card-shadow: {{ $btnShadow && $btnVariant !== 'glass' ? '0 10px 15px -3px rgba(0, 0, 0, 0.1)' : 'none' }};
            --btn-align: {{ $btnAlign === 'left' ? 'flex-start' : ($btnAlign === 'right' ? 'flex-end' : 'center') }};
            --btn-text-align: {{ $btnAlign }};
            
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
            @elseif($fontFamily === 'mono')
                --font-family: 'JetBrains Mono', monospace;
            @endif

            @if($btnStyle === 'pill')
                --btn-radius: 9999px;
            @elseif($btnStyle === 'square')
                --btn-radius: 0px;
            @elseif($btnStyle === 'soft')
                --btn-radius: 1.25rem;
            @endif

            /* Animation Colors */
            @php
                $animColors = $design['background']['animation_colors'] ?? ['#6366f1', '#a855f7'];
            @endphp
            --anim-color-1: {{ $animColors[0] }};
            --anim-color-2: {{ $animColors[1] }};
        }
        @endif

        /* ===== BACKGROUND ANIMATIONS ===== */
        .bg-anim-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            pointer-events: none;
        }

        /* Animasyon 1: Zigzag Gradient */
        .bg-anim-1 {
            background-color: var(--anim-color-1);
            background-image:  linear-gradient(135deg, var(--anim-color-2) 25%, transparent 25%), 
                               linear-gradient(225deg, var(--anim-color-2) 25%, transparent 25%), 
                               linear-gradient(45deg, var(--anim-color-2) 25%, transparent 25%), 
                               linear-gradient(315deg, var(--anim-color-2) 25%, var(--anim-color-1) 25%);
            background-position:  40px 0, 40px 0, 0 0, 0 0;
            background-size: 80px 80px;
            background-repeat: repeat;
            animation: bg-move-1 20s linear infinite;
        }
        @keyframes bg-move-1 { from { background-position: 40px 0, 40px 0, 0 0, 0 0; } to { background-position: 40px 80px, 40px 80px, 0 80px, 0 80px; } }

        /* Animasyon 2: Floating Circles */
        .bg-anim-2 {
            background: var(--anim-color-1);
            background-image: radial-gradient(circle at 20% 30%, var(--anim-color-2) 0%, transparent 20%),
                              radial-gradient(circle at 80% 70%, var(--anim-color-2) 0%, transparent 25%);
            background-size: 200% 200%;
            animation: bg-move-2 15s ease infinite alternate;
        }
        @keyframes bg-move-2 { from { background-position: 0% 0%; } to { background-position: 100% 100%; } }

        /* Animasyon 3: Scanning Stripes */
        .bg-anim-3 {
            background: repeating-linear-gradient(45deg, var(--anim-color-1), var(--anim-color-1) 100px, var(--anim-color-2) 100px, var(--anim-color-2) 200px);
            background-size: 400% 400%;
            animation: bg-move-3 30s linear infinite;
        }
        @keyframes bg-move-3 { from { background-position: 0 0; } to { background-position: 400% 400%; } }

        /* Animasyon 4: Mesh Gradient */
        .bg-anim-4 {
            background: var(--anim-color-1);
            background-image: conic-gradient(from 180deg at 50% 50%, var(--anim-color-2), var(--anim-color-1), var(--anim-color-2));
            animation: bg-move-4 10s linear infinite;
        }
        @keyframes bg-move-4 { from { transform: scale(1.5) rotate(0deg); } to { transform: scale(1.5) rotate(360deg); } }

        /* Animasyon 5: Large Moving Chevrons (User requested) */
        .bg-anim-5 {
            background-color: var(--anim-color-1);
            background-image: linear-gradient(135deg, var(--anim-color-2) 25%, transparent 25%), 
                               linear-gradient(225deg, var(--anim-color-2) 25%, transparent 25%);
            background-position: 0 0;
            background-size: 100px 100px;
            animation: bg-move-5 4s linear infinite;
        }
        @keyframes bg-move-5 { from { background-position: 0 0; } to { background-position: 0 100px; } }

        /* Apply Styles */
        body { font-family: var(--font-family); }

        .theme-page {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            padding: 3rem 1rem;
            position: relative;
            background: var(--bg);
            overflow-x: hidden;
            @if((($design['theme']['custom_theme'] ?? false) || $profile->theme_type === 'custom') && ($design['background']['type'] ?? $profile->bg_type ?? '') === 'image')
                background-image: url('{{ $design['background']['image_url'] ?? $profile->bg_image_url ?? '' }}');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            @endif
        }

        .bg-video-container {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        .bg-video-container video {
            min-width: 100%; min-height: 100%;
            width: auto; height: auto;
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        .bg-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0, {{ ($design['background']['overlay'] ?? 0) / 100 }});
            backdrop-filter: blur({{ $design['background']['blur'] ?? 0 }}px);
            -webkit-backdrop-filter: blur({{ $design['background']['blur'] ?? 0 }}px);
            z-index: 0;
            pointer-events: none;
        }

        /* Animations */
        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .anim-floating { animation: floating 3s ease-in-out infinite; }

        @keyframes pulse-soft {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .anim-pulse { animation: pulse-soft 2s ease-in-out infinite; }

        .theme-name { color: var(--text-title, var(--text)); }
        .theme-username { color: var(--text-secondary); }
        .theme-bio { color: var(--text-page, var(--text)); }

        .theme-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--link-color);
            border-radius: var(--btn-radius);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: var(--btn-align, center);
            text-align: var(--btn-text-align, center);
        }
        .theme-card:hover {
            background: var(--card-hover);
            box-shadow: var(--card-shadow, none);
            transform: translateY(-2px);
        }

        /* Offset Style */
        .variant-offset {
            box-shadow: 4px 4px 0px 0px var(--link-color);
        }
        .variant-offset:hover {
            box-shadow: 2px 2px 0px 0px var(--link-color);
            transform: translate(2px, 2px);
        }

        .theme-avatar-ring { box-shadow: 0 0 0 3px var(--avatar-ring, rgba(255,255,255,0.2)); }
        .avatar-polygon { clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); }
        .theme-footer { color: var(--footer-color); }
        .theme-empty { color: var(--text-secondary); background: var(--card-bg); border-color: var(--card-border); }
    </style>
</head>
@php
    $design = $profile->design_settings ?? [];
@endphp
<body class="h-full theme-{{ $theme }} {{ $profile->theme_type === 'custom' ? 'theme-custom' : '' }}">
    <div class="theme-page">
        <!-- Background Video -->
        @if(($design['background']['type'] ?? '') === 'video' && ($design['background']['video_url'] ?? $profile->bg_video_url))
            <div class="bg-video-container">
                <video autoplay muted loop playsinline>
                    <source src="{{ $design['background']['video_url'] ?? $profile->bg_video_url }}" type="video/mp4">
                </video>
            </div>
        @endif

        @if(($design['background']['type'] ?? '') === 'animation' && ($design['background']['animation'] ?? 'none') !== 'none')
            <div class="bg-anim-container bg-{{ $design['background']['animation'] }}"></div>
        @endif

        <!-- Background Overlay -->
        <div class="bg-overlay"></div>

        <div class="max-w-md w-full space-y-8 relative {{ $headerLayout === 'hero-cover' ? 'pt-16' : '' }}">
            
            @if($headerLayout === 'hero-cover')
                <div class="absolute top-0 left-[-2rem] right-[-2rem] h-48 bg-cover bg-center rounded-b-[3rem] border-b border-white/10 shadow-lg pointer-events-none z-0 overflow-hidden"
                     style="background-image: url('{{ $design['header']['hero_image_url'] ?? $profile->hero_image_url ?? 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809' }}')">
                    <div class="absolute inset-0 bg-black/20"></div>
                </div>
            @endif

            <!-- Profil Kartı -->
            <div class="{{ $layoutWrapperClass }} relative z-10 p-2 anim-{{ $design['background']['animation'] ?? 'none' }}">
                <div class="{{ $layoutFlexClass }}">
                    <!-- Avatar -->
                    <img class="{{ $avatarClasses }} {{ $frameClasses }} object-cover theme-avatar-ring flex-shrink-0 {{ $headerLayout === 'hero-cover' ? 'w-32 h-32 -mt-24 border-4 border-background bg-background shadow-2xl scale-110' : '' }} {{ $headerLayout === 'left-aligned' ? 'w-20 h-20' : '' }}" 
                         src="{{ $profile->avatar_url }}" alt="{{ $user->name }}">
                    
                    <!-- Text Info -->
                    <div class="{{ $headerLayout === 'left-aligned' ? 'flex-1 pt-1' : 'w-full' }}">
                        @if($showName)
                            <h2 class="{{ $headerLayout === 'hero-cover' ? 'mt-6 text-4xl' : 'mt-4 text-3xl' }} font-extrabold tracking-tight theme-name break-words">
                                {{ $profile->user_name ?? $user->name }}
                            </h2>
                        @endif
                        
                        @if($showUsername)
                            <p class="{{ $headerLayout === 'left-aligned' ? 'mt-0.5' : 'mt-1' }} text-sm font-medium theme-username opacity-80">
                                {{ '@' . ($profile->username ?? $user->username) }}
                            </p>
                        @endif

                        @if($showBio && ($profile->bio || isset($design['profile']['bio'])))
                            <p class="{{ $headerLayout === 'hero-cover' ? 'mt-6 px-4' : 'mt-4' }} {{ $headerLayout === 'left-aligned' ? 'text-sm' : 'text-base' }} leading-relaxed theme-bio break-words">
                                {{ $profile->bio }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Linkler -->
            <div class="mt-8 space-y-4">
                @forelse($links as $link)
                    @php
                        $variantClass = '';
                        if(($design['buttons']['variant'] ?? '') === 'offset') $variantClass = 'variant-offset';
                        elseif(($design['buttons']['variant'] ?? '') === 'glass') $variantClass = 'backdrop-blur-md';
                    @endphp
                    <a href="{{ route('public.redirect', $link->id) }}" target="_blank" rel="noopener noreferrer" 
                       class="flex items-center p-3 transition-all duration-300 theme-card group relative {{ $variantClass }}">
                        
                        @if(($design['buttons']['variant'] ?? '') !== 'glass')
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-black/5 dark:bg-white/5 group-hover:scale-110 transition-transform" style="color: var(--icon-color, var(--link-color))">
                            <i class="{{ $link->icon_class }} text-xl"></i>
                        </div>
                        @else
                           <i class="{{ $link->icon_class }} text-xl mr-3" style="color: var(--icon-color, var(--link-color))"></i>
                        @endif

                        <div class="flex-1 font-bold {{ ($design['buttons']['align'] ?? 'center') === 'center' ? 'pr-10' : '' }}">
                            {{ $link->title }}
                        </div>

                        @if($link->password)
                            <div class="absolute right-4 text-gray-400 opacity-50">
                                <i class="fas fa-lock text-xs"></i>
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
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-semibold transition-colors theme-footer hover:opacity-100 opacity-60">
                    <span>by byoo.pro</span>
                </a>
            </div>
            
        </div>
    </div>

    <script>
        if (window.self !== window.top) {
            window.addEventListener('message', (event) => {
                if (event.data?.type === 'DESIGN_UPDATE') {
                    const design = event.data.payload;
                    if (!design) return;

                    const root = document.documentElement;
                    const body = document.body;

                    // 1. Theme Mode
                    if (design.theme) {
                        body.classList.remove('theme-custom');
                        const classes = Array.from(body.classList);
                        classes.forEach(c => { if(c.startsWith('theme-') && c !== 'theme-page') body.classList.remove(c); });
                        
                        if (design.theme.custom_theme) {
                            body.classList.add('theme-custom');
                        } else {
                            body.classList.add('theme-' + (design.theme.preset || 'minimal'));
                        }
                    }

                    // 2. Colors & Buttons Sync
                    if (design.colors) {
                        root.style.setProperty('--text-title', design.colors.title || design.colors.text || '#111827');
                        root.style.setProperty('--text-page', design.colors.page_text || design.colors.text || '#111827');
                    }

                    if (design.buttons) {
                        const btns = design.buttons;
                        root.style.setProperty('--card-bg', btns.variant === 'outline' ? 'transparent' : (btns.variant === 'glass' ? 'rgba(255,255,255,0.1)' : (btns.bg_color || '#ffffff')));
                        root.style.setProperty('--card-border', btns.variant === 'outline' ? (btns.bg_color || '#ffffff') : 'transparent');
                        root.style.setProperty('--link-color', btns.variant === 'outline' ? (btns.bg_color || '#ffffff') : (btns.text_color || '#111827'));
                        root.style.setProperty('--card-shadow', btns.shadow && btns.variant !== 'glass' ? '0 10px 15px -3px rgba(0, 0, 0, 0.1)' : 'none');
                        
                        // Icon Color Sync
                        root.style.setProperty('--icon-color', btns.text_color || (btns.variant === 'outline' ? btns.bg_color : '#111827'));
                        
                        const alignMap = { left: 'flex-start', center: 'center', right: 'flex-end' };
                        root.style.setProperty('--btn-align', alignMap[btns.align] || 'center');
                        root.style.setProperty('--btn-text-align', btns.align || 'center');

                        const radiusMap = { pill: '9999px', square: '0px', soft: '1.25rem' };
                        root.style.setProperty('--btn-radius', radiusMap[btns.style] || '0.75rem');

                        document.querySelectorAll('.theme-card').forEach(card => {
                            card.classList.remove('variant-offset', 'backdrop-blur-md');
                            if (btns.variant === 'offset') card.classList.add('variant-offset');
                            else if (btns.variant === 'glass') card.classList.add('backdrop-blur-md');
                        });
                    }

                    // 3. Background Sync
                    if (design.background) {
                        const bg = design.background;
                        const themePage = document.querySelector('.theme-page');
                        const overlayEl = document.querySelector('.bg-overlay');
                        let videoContainer = document.querySelector('.bg-video-container');

                        if (themePage) {
                            themePage.style.background = '';
                            themePage.style.backgroundImage = '';
                            if (videoContainer) videoContainer.style.display = 'none';

                            if (bg.type === 'color') {
                                root.style.setProperty('--bg', bg.color || '#f9fafb');
                            } else if (bg.type === 'gradient') {
                                root.style.setProperty('--bg', bg.gradient || '');
                            } else if (bg.type === 'image') {
                                themePage.style.backgroundImage = `url('${bg.image_url}')`;
                                themePage.style.backgroundSize = 'cover';
                                themePage.style.backgroundPosition = 'center';
                            } else if (bg.type === 'video') {
                                if (!videoContainer) {
                                    videoContainer = document.createElement('div');
                                    videoContainer.className = 'bg-video-container';
                                    videoContainer.innerHTML = '<video autoplay muted loop playsinline></video>';
                                    themePage.parentElement.insertBefore(videoContainer, themePage);
                                }
                                videoContainer.style.display = 'block';
                                const video = videoContainer.querySelector('video');
                                if (video.src !== bg.video_url) {
                                    video.src = bg.video_url;
                                    video.load();
                                }
                            }

                            // Background Animation Pattern
                            let animContainer = document.querySelector('.bg-anim-container');
                            if (bg.type === 'animation' && bg.animation !== 'none') {
                                if (!animContainer) {
                                    animContainer = document.createElement('div');
                                    animContainer.className = 'bg-anim-container';
                                    themePage.parentElement.insertBefore(animContainer, themePage);
                                }
                                animContainer.className = 'bg-anim-container bg-' + bg.animation;
                                if (bg.animation_colors) {
                                    root.style.setProperty('--anim-color-1', bg.animation_colors[0]);
                                    root.style.setProperty('--anim-color-2', bg.animation_colors[1]);
                                }
                            } else if (animContainer) {
                                animContainer.remove();
                            }

                            if (overlayEl) {
                                overlayEl.style.backgroundColor = `rgba(0, 0, 0, ${(bg.overlay || 0) / 100})`;
                                overlayEl.style.backdropFilter = overlayEl.style.webkitBackdropFilter = `blur(${bg.blur || 0}px)`;
                            }
                        }
                    }

                    // 4. Header & Layout Sync
                    if (design.header) {
                        const header = design.header;
                        const avatarImg = document.querySelector('img[alt="{{ $user->name }}"]');
                        const nameEl = document.querySelector('.theme-name');
                        const usernameEl = document.querySelector('.theme-username');
                        const bioEl = document.querySelector('.theme-bio');
                        const maxWContainer = document.querySelector('.max-w-md');
                        const cardWrapper = avatarImg?.closest('.z-10');
                        const flexContainer = avatarImg?.parentElement;
                        
                        if (avatarImg) {
                            avatarImg.classList.remove('w-16', 'h-16', 'w-24', 'h-24', 'w-32', 'h-32', 'w-40', 'h-40', 'w-20', 'h-20');
                            avatarImg.classList.remove('rounded-full', 'rounded-xl', 'rounded-none', 'avatar-polygon');
                            const sizeMap = { sm: 'w-16', md: 'w-24', lg: 'w-32', xl: 'w-40' };
                            const heightMap = { sm: 'h-16', md: 'h-24', lg: 'h-32', xl: 'h-40' };
                            avatarImg.classList.add(sizeMap[header.avatar_size] || 'w-24');
                            avatarImg.classList.add(heightMap[header.avatar_size] || 'h-24');
                            const frameMap = { 'rounded-xl': 'rounded-xl', 'square': 'rounded-none', 'polygon': 'avatar-polygon', 'circle': 'rounded-full' };
                            avatarImg.classList.add(frameMap[header.avatar_frame] || 'rounded-full');
                        }

                        if (nameEl) nameEl.style.display = header.show_name ? 'block' : 'none';
                        if (usernameEl) usernameEl.style.display = header.show_username ? 'block' : 'none';
                        if (bioEl) bioEl.style.display = (header.show_bio) ? 'block' : 'none';

                        if (cardWrapper && flexContainer && maxWContainer) {
                            let heroCover = document.querySelector('.absolute.top-0.left-\\[-2rem\\]');
                            cardWrapper.classList.remove('text-left', 'text-center', 'relative', 'pt-12', 'mt-16');
                            flexContainer.classList.remove('flex-row', 'items-center', 'gap-6', 'flex-col');
                            avatarImg?.classList.remove('-mt-24', 'border-4', 'border-background', 'bg-background', 'shadow-2xl', 'scale-110');
                            maxWContainer.classList.remove('pt-16');

                            if (header.layout === 'left-aligned') {
                                cardWrapper.classList.add('text-left');
                                flexContainer.classList.add('flex', 'flex-row', 'items-center', 'gap-6');
                                if (heroCover) heroCover.style.display = 'none';
                            } else if (header.layout === 'hero-cover') {
                                cardWrapper.classList.add('text-center', 'relative', 'pt-12', 'mt-16');
                                flexContainer.classList.add('flex', 'flex-col', 'items-center');
                                maxWContainer.classList.add('pt-16');
                                if (avatarImg) avatarImg.classList.add('-mt-24', 'border-4', 'border-background', 'bg-background', 'shadow-2xl', 'scale-110');
                                if (!heroCover) {
                                    heroCover = document.createElement('div');
                                    heroCover.className = 'absolute top-0 left-[-2rem] right-[-2rem] h-48 bg-cover bg-center rounded-b-[3rem] border-b border-white/10 shadow-lg pointer-events-none z-0 overflow-hidden';
                                    heroCover.innerHTML = '<div class="absolute inset-0 bg-black/20"></div>';
                                    maxWContainer.insertBefore(heroCover, maxWContainer.firstChild);
                                }
                                heroCover.style.display = 'block';
                                heroCover.style.backgroundImage = `url('${header.hero_image_url || 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809'}')`;
                            } else {
                                cardWrapper.classList.add('text-center');
                                flexContainer.classList.add('flex', 'flex-col', 'items-center');
                                if (heroCover) heroCover.style.display = 'none';
                            }
                        }
                    }

                    if (design.theme && design.theme.font_family) {
                        const fontMap = { outfit: "'Outfit'", inter: "'Inter'", roboto: "'Roboto'", montserrat: "'Montserrat'", playfair: "'Playfair Display'", mono: "'JetBrains Mono'" };
                        root.style.setProperty('--font-family', (fontMap[design.theme.font_family] || "'Inter'") + ", sans-serif");
                    }
                }
            });
        }
    </script>
</body>
</html>
