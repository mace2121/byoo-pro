@php
    $design = \App\Support\DesignEditor::resolve($profile, [
        'profile' => [
            'name' => $user->name,
            'username' => $profile->username ?? $user->username,
            'bio' => $profile->bio ?? '',
        ],
    ]);
    $theme = $design['theme']['preset'] ?? 'minimal';
    $headerLayout = $design['header']['layout'] ?? 'centered-classic';
    $avatarSize = $design['header']['avatar_size'] ?? 'md';
    $avatarFrame = $design['header']['avatar_frame'] ?? 'circle';
    $showName = $design['header']['show_name'] ?? true;
    $showUsername = $design['header']['show_username'] ?? true;
    $showBio = $design['header']['show_bio'] ?? true;
    $fontQuery = \App\Support\DesignEditor::getFontQuery($design['typography']['font_family'] ?? 'inter');
    $bodyStyle = \App\Support\DesignEditor::inlineCssVariables($design);
    $activeBackgroundType = $design['background']['active_type'] ?? 'color';

    $avatarClasses = match ($avatarSize) {
        'sm' => 'w-16 h-16',
        'lg' => 'w-32 h-32',
        'xl' => 'w-40 h-40',
        default => 'w-24 h-24',
    };

    $frameClasses = match ($avatarFrame) {
        'rounded-xl' => 'rounded-xl',
        'square' => 'rounded-none',
        'polygon' => 'avatar-polygon',
        default => 'rounded-full',
    };

    $layoutWrapperClass = 'text-center';
    $layoutFlexClass = 'flex flex-col items-center';

    if ($headerLayout === 'left-aligned') {
        $layoutWrapperClass = 'text-left';
        $layoutFlexClass = 'flex flex-row items-center gap-6';
    } elseif ($headerLayout === 'hero-cover') {
        $layoutWrapperClass = 'text-center relative pt-12 mt-16';
        $layoutFlexClass = 'flex flex-col items-center';
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

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

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

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $user->name }} - byoo.pro">
    <meta name="twitter:description" content="{{ $profile->bio ? Str::limit($profile->bio, 160) : $user->name . ' - byoo.pro' }}">
    @if($profile->avatar)
        <meta name="twitter:image" content="{{ asset('storage/' . $profile->avatar) }}">
    @else
        <meta name="twitter:image" content="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=512">
    @endif

    @if($fontQuery)
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family={{ $fontQuery }}&display=swap" rel="stylesheet">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg: #f9fafb;
            --text: #111827;
            --text-secondary: #6b7280;
            --card-bg: #ffffff;
            --card-border: #e5e7eb;
            --card-hover: #f3f4f6;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --avatar-ring: #ffffff;
            --link-color: #374151;
            --footer-color: #9ca3af;
            --font-family: 'Inter', sans-serif;
            --font-title-size: 2.25rem;
            --font-username-size: 0.95rem;
            --font-bio-size: 1rem;
            --font-button-size: 1rem;
            --btn-radius: 18px;
            --btn-border-style: solid;
            --btn-border-width: 1px;
            --btn-bg: #ffffff;
            --btn-text: #111827;
            --btn-border: #d1d5db;
            --btn-icon: #111827;
            --btn-bg-hover: #f3f4f6;
            --btn-text-hover: #111827;
            --btn-border-hover: #9ca3af;
            --btn-icon-hover: #111827;
            --anim-color-1: #6366f1;
            --anim-color-2: #a855f7;
        }

        .theme-minimal { --bg: #f9fafb; --text: #111827; --text-secondary: #6b7280; --card-bg: #ffffff; --card-border: #e5e7eb; --card-hover: #f3f4f6; --avatar-ring: #ffffff; --link-color: #374151; --footer-color: #9ca3af; }
        .theme-dark { --bg: #0f172a; --text: #f1f5f9; --text-secondary: #94a3b8; --card-bg: #1e293b; --card-border: #334155; --card-hover: #334155; --avatar-ring: #334155; --link-color: #e2e8f0; --footer-color: #64748b; }
        .theme-neon { --bg: #0a0a0a; --text: #39ff14; --text-secondary: #00ff88; --card-bg: rgba(57,255,20,0.05); --card-border: #39ff14; --card-hover: rgba(57,255,20,0.15); --avatar-ring: #39ff14; --link-color: #39ff14; --footer-color: #00ff8866; }
        .theme-glass { --bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%); --text: #ffffff; --text-secondary: rgba(255,255,255,0.8); --card-bg: rgba(255,255,255,0.15); --card-border: rgba(255,255,255,0.25); --card-hover: rgba(255,255,255,0.25); --avatar-ring: rgba(255,255,255,0.5); --link-color: #ffffff; --footer-color: rgba(255,255,255,0.5); }
        .theme-midnight { --bg: #1a1a2e; --text: #e0e0ff; --text-secondary: #8888bb; --card-bg: #16213e; --card-border: #0f3460; --card-hover: #0f3460; --avatar-ring: #e94560; --link-color: #e0e0ff; --footer-color: #535380; }
        .theme-sunset { --bg: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #fda085 100%); --text: #ffffff; --text-secondary: rgba(255,255,255,0.85); --card-bg: rgba(255,255,255,0.2); --card-border: rgba(255,255,255,0.3); --card-hover: rgba(255,255,255,0.3); --avatar-ring: rgba(255,255,255,0.6); --link-color: #ffffff; --footer-color: rgba(255,255,255,0.5); }
        .theme-aurora { --bg: linear-gradient(135deg, #0c3547 0%, #1a5e63 40%, #204060 100%); --text: #a7f3d0; --text-secondary: #6ee7b7; --card-bg: rgba(167,243,208,0.08); --card-border: rgba(167,243,208,0.2); --card-hover: rgba(167,243,208,0.15); --avatar-ring: #34d399; --link-color: #a7f3d0; --footer-color: rgba(110,231,183,0.4); }
        .theme-forest { --bg: #1a2f1a; --text: #d4edda; --text-secondary: #8fbc8f; --card-bg: #2d4a2d; --card-border: #3d6b3d; --card-hover: #3d6b3d; --avatar-ring: #5cb85c; --link-color: #d4edda; --footer-color: #6b8e6b; }
        .theme-cyber { --bg: #0d0221; --text: #ff00ff; --text-secondary: #00ffff; --card-bg: rgba(255,0,255,0.05); --card-border: #ff00ff; --card-hover: rgba(255,0,255,0.12); --avatar-ring: #00ffff; --link-color: #ff00ff; --footer-color: #00ffff66; }
        .theme-obsidian { --bg: #121212; --text: #e0e0e0; --text-secondary: #888888; --card-bg: #1e1e1e; --card-border: #333333; --card-hover: #2a2a2a; --avatar-ring: #555555; --link-color: #cccccc; --footer-color: #555555; }

        .bg-anim-container { position: absolute; inset: 0; z-index: 2; pointer-events: none; }
        .bg-anim-1 { background-color: var(--anim-color-1); background-image: linear-gradient(135deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(225deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(45deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(315deg, var(--anim-color-2) 25%, var(--anim-color-1) 25%); background-position: 40px 0, 40px 0, 0 0, 0 0; background-size: 80px 80px; animation: bg-move-1 20s linear infinite; }
        @keyframes bg-move-1 { from { background-position: 40px 0, 40px 0, 0 0, 0 0; } to { background-position: 40px 80px, 40px 80px, 0 80px, 0 80px; } }
        .bg-anim-2 { background: var(--anim-color-1); background-image: radial-gradient(circle at 20% 30%, var(--anim-color-2) 0%, transparent 20%), radial-gradient(circle at 80% 70%, var(--anim-color-2) 0%, transparent 25%); background-size: 200% 200%; animation: bg-move-2 15s ease infinite alternate; }
        @keyframes bg-move-2 { from { background-position: 0% 0%; } to { background-position: 100% 100%; } }
        .bg-anim-3 { background: repeating-linear-gradient(45deg, var(--anim-color-1), var(--anim-color-1) 100px, var(--anim-color-2) 100px, var(--anim-color-2) 200px); background-size: 400% 400%; animation: bg-move-3 30s linear infinite; }
        @keyframes bg-move-3 { from { background-position: 0 0; } to { background-position: 400% 400%; } }
        .bg-anim-4 { background: var(--anim-color-1); background-image: conic-gradient(from 180deg at 50% 50%, var(--anim-color-2), var(--anim-color-1), var(--anim-color-2)); animation: bg-move-4 10s linear infinite; }
        @keyframes bg-move-4 { from { transform: scale(1.5) rotate(0deg); } to { transform: scale(1.5) rotate(360deg); } }
        .bg-anim-5 { background-color: var(--anim-color-1); background-image: linear-gradient(135deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(225deg, var(--anim-color-2) 25%, transparent 25%); background-size: 100px 100px; animation: bg-move-5 4s linear infinite; }
        @keyframes bg-move-5 { from { background-position: 0 0; } to { background-position: 0 100px; } }

        body { font-family: var(--font-family); }
        .theme-page { min-height: 100vh; display: flex; justify-content: center; padding: 3rem 1rem; position: relative; z-index: 10; }
        .bg-layer-wrapper { position: fixed; inset: 0; z-index: -10; pointer-events: none; background-color: var(--bg-color, #f9fafb); }
        .bg-image-layer { position: absolute; inset: 0; z-index: 1; background-size: cover; background-position: center; background-attachment: fixed; display: none; }
        .bg-video-container { position: absolute; inset: 0; z-index: 1; overflow: hidden; }
        .bg-video-container video { min-width: 100%; min-height: 100%; width: auto; height: auto; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); object-fit: cover; }
        .bg-overlay { position: absolute; inset: 0; background: rgba(0, 0, 0, {{ ($design['background']['overlay'] ?? 0) / 100 }}); backdrop-filter: blur({{ $design['background']['blur'] ?? 0 }}px); -webkit-backdrop-filter: blur({{ $design['background']['blur'] ?? 0 }}px); z-index: 10; pointer-events: none; }
        .hero-cover-container { position: absolute; top: 0; left: 0; right: 0; height: 24rem; overflow: hidden; pointer-events: none; z-index: 0; -webkit-mask-image: linear-gradient(to bottom, black 60%, transparent 100%); mask-image: linear-gradient(to bottom, black 60%, transparent 100%); }
        .hero-image-bg { width: 100%; height: 100%; background-size: cover; background-position: center; }
        .theme-name { color: var(--text-title, var(--text)); font-size: var(--font-title-size); }
        .theme-username { color: var(--text-secondary); font-size: var(--font-username-size); }
        .theme-bio { color: var(--text-page, var(--text)); font-size: var(--font-bio-size); }
        .theme-card { background: var(--btn-bg, var(--card-bg)); border: var(--btn-border-width, 1px) var(--btn-border-style, solid) var(--btn-border, var(--card-border)); color: var(--btn-text, var(--link-color)); border-radius: var(--btn-radius); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: flex; align-items: center; justify-content: var(--btn-align, center); text-align: var(--btn-text-align, center); font-size: var(--font-button-size); }
        .theme-card:hover { background: var(--btn-bg-hover, var(--card-hover)); border-color: var(--btn-border-hover, var(--btn-border, var(--card-border))); color: var(--btn-text-hover, var(--btn-text, var(--link-color))); box-shadow: var(--card-shadow, none); transform: translateY(-2px); }
        .theme-card-icon { color: var(--btn-icon, var(--link-color)); transition: color 0.3s ease; }
        .theme-card:hover .theme-card-icon,
        .theme-card:hover .theme-card-icon-wrap { color: var(--btn-icon-hover, var(--btn-icon, var(--link-color))); }
        .variant-offset { box-shadow: 4px 4px 0 0 var(--btn-border, var(--link-color)); }
        .variant-offset:hover { box-shadow: 2px 2px 0 0 var(--btn-border-hover, var(--btn-border, var(--link-color))); transform: translate(2px, 2px); }
        .theme-avatar-ring { box-shadow: 0 0 0 3px var(--avatar-ring, rgba(255,255,255,0.2)); }
        .avatar-polygon { clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); }
        .theme-footer { color: var(--footer-color); }
        .theme-empty { color: var(--text-secondary); background: var(--card-bg); border-color: var(--card-border); }
    </style>
</head>
<body class="h-full theme-{{ $theme }}" style="{{ $bodyStyle }}">
    <div class="theme-page">
        @if($headerLayout === 'hero-cover')
            <div class="hero-cover-container" style="display: block;">
                <div class="hero-image-bg" style="background-image: url('{{ $design['header']['hero_image_url'] ?? 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809' }}')"></div>
            </div>
        @else
            <div class="hero-cover-container" style="display: none;">
                <div class="hero-image-bg"></div>
            </div>
        @endif

        <div class="bg-layer-wrapper" style="{{ $activeBackgroundType === 'gradient' ? 'background-image: ' . ($design['background']['gradient'] ?? '') . ';' : '' }}">
            <div class="bg-image-layer" style="{{ $activeBackgroundType === 'image' ? 'display:block;background-image:url(\'' . ($design['background']['image_url'] ?? '') . '\')' : '' }}"></div>
            <div class="bg-video-container" style="display: {{ $activeBackgroundType === 'video' ? 'block' : 'none' }}">
                @if($activeBackgroundType === 'video' && !empty($design['background']['video_url']))
                    <video autoplay muted loop playsinline src="{{ $design['background']['video_url'] }}"></video>
                @endif
            </div>
            @if($activeBackgroundType === 'animation')
                <div class="bg-anim-container bg-{{ $design['background']['animation'] ?? 'anim-1' }}"></div>
            @endif
            <div class="bg-overlay"></div>
        </div>

        <div class="max-w-md w-full space-y-8 relative {{ $headerLayout === 'hero-cover' ? 'pt-16' : '' }}">
            <div class="{{ $layoutWrapperClass }} relative z-10 p-2 anim-target">
                <div class="{{ $layoutFlexClass }}">
                    <img class="{{ $avatarClasses }} {{ $frameClasses }} avatar-preview-img object-cover theme-avatar-ring flex-shrink-0 {{ $headerLayout === 'hero-cover' ? 'w-32 h-32 -mt-24 border-4 border-background bg-background shadow-2xl scale-110' : '' }} {{ $headerLayout === 'left-aligned' ? 'w-20 h-20' : '' }}"
                        src="{{ $profile->avatar_url }}" alt="{{ $user->name }}">

                    <div class="{{ $headerLayout === 'left-aligned' ? 'flex-1 pt-1' : 'w-full' }}">
                        <h2 class="{{ $headerLayout === 'hero-cover' ? 'mt-6 text-4xl' : 'mt-4 text-3xl' }} font-extrabold tracking-tight theme-name break-words" style="display: {{ $showName ? 'block' : 'none' }};">
                            {{ $design['profile']['name'] ?? $user->name }}
                        </h2>
                        <p class="{{ $headerLayout === 'left-aligned' ? 'mt-0.5' : 'mt-1' }} text-sm font-medium theme-username opacity-80" style="display: {{ $showUsername ? 'block' : 'none' }};">
                            {{ '@' . ($design['profile']['username'] ?? $profile->username ?? $user->username) }}
                        </p>
                        <p class="{{ $headerLayout === 'hero-cover' ? 'mt-6 px-4' : 'mt-4' }} {{ $headerLayout === 'left-aligned' ? 'text-sm' : 'text-base' }} leading-relaxed theme-bio break-words" style="display: {{ ($showBio && ($profile->bio || isset($design['profile']['bio']))) ? 'block' : 'none' }};">
                            {{ $design['profile']['bio'] ?? $profile->bio }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 space-y-4">
                @forelse($links as $link)
                    @php
                        $variantClass = '';
                        if (($design['buttons']['variant'] ?? '') === 'offset') {
                            $variantClass = 'variant-offset';
                        } elseif (($design['buttons']['variant'] ?? '') === 'glass') {
                            $variantClass = 'backdrop-blur-md';
                        }
                    @endphp
                    <a href="{{ route('public.redirect', $link->id) }}" target="_blank" rel="noopener noreferrer" class="flex items-center p-3 transition-all duration-300 theme-card group relative {{ $variantClass }}">
                        @if(($design['buttons']['variant'] ?? '') !== 'glass')
                            <div class="theme-card-icon-wrap flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-black/5 dark:bg-white/5 group-hover:scale-110 transition-transform" style="color: var(--btn-icon, var(--link-color))">
                                <i class="{{ $link->icon_class }} theme-card-icon text-xl"></i>
                            </div>
                        @else
                            <i class="{{ $link->icon_class }} theme-card-icon text-xl mr-3" style="color: var(--btn-icon, var(--link-color))"></i>
                        @endif

                        <div class="theme-card-label flex-1 font-bold {{ ($design['buttons']['align'] ?? 'center') === 'center' ? 'pr-10' : '' }}">
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

            <div class="mt-12 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-semibold transition-colors theme-footer hover:opacity-100 opacity-60">
                    <span>by byoo.pro</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const shared = window.DesignEditorShared;
            const initialDesign = @js($design);
            const runtimeDefaults = {
                profile: {
                    name: @js($user->name),
                    username: @js($profile->username ?? $user->username),
                    bio: @js($profile->bio ?? ''),
                },
            };
            const defaultHeroImage = 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809';

            const getFontStack = (fontKey) => {
                const option = shared.getFontOption(fontKey);
                if (option.id === 'playfair-display') return `'${option.family}', serif`;
                if (option.id === 'mono') return `'${option.family}', monospace`;
                return `'${option.family}', sans-serif`;
            };

            const applyDesign = (incomingDesign) => {
                const design = shared.normalizeDesign(incomingDesign, runtimeDefaults);
                const root = document.documentElement;
                const body = document.body;
                const setVar = (name, value) => {
                    root.style.setProperty(name, value);
                    body.style.setProperty(name, value);
                };
                const activeBackgroundType = design.background.active_type || design.background.type;
                const fontVars = shared.getFontSizeVars(design.typography.font_size_preset);

                shared.loadGoogleFont(design.typography.font_family);

                const nameEl = document.querySelector('.theme-name');
                const usernameEl = document.querySelector('.theme-username');
                const bioEl = document.querySelector('.theme-bio');
                const cardWrapper = document.querySelector('.anim-target');
                const avatarImg = document.querySelector('.avatar-preview-img');
                const flexContainer = avatarImg ? avatarImg.parentElement : null;
                const heroCover = document.querySelector('.hero-cover-container');
                const heroImage = heroCover ? heroCover.querySelector('.hero-image-bg') : null;
                const textContainer = nameEl ? nameEl.parentElement : null;
                const bgWrapper = document.querySelector('.bg-layer-wrapper');
                const bgImageLayer = document.querySelector('.bg-image-layer');
                const overlayEl = document.querySelector('.bg-overlay');
                let videoContainer = document.querySelector('.bg-video-container');
                let animContainer = document.querySelector('.bg-anim-container');

                if (nameEl) nameEl.textContent = design.profile.name || runtimeDefaults.profile.name;
                if (usernameEl) {
                    const username = String(design.profile.username || runtimeDefaults.profile.username).replace(/^@/, '');
                    usernameEl.textContent = username ? '@' + username : '';
                }
                if (bioEl) bioEl.textContent = design.profile.bio || '';

                if (nameEl) nameEl.style.display = design.header.show_name ? 'block' : 'none';
                if (usernameEl) usernameEl.style.display = design.header.show_username ? 'block' : 'none';
                if (bioEl) bioEl.style.display = design.header.show_bio ? 'block' : 'none';

                ['theme-minimal', 'theme-dark', 'theme-neon', 'theme-glass', 'theme-midnight', 'theme-sunset', 'theme-aurora', 'theme-forest', 'theme-cyber', 'theme-obsidian'].forEach((themeClass) => {
                    body.classList.remove(themeClass);
                });
                body.classList.add('theme-' + design.theme.preset);

                setVar('--font-family', getFontStack(design.typography.font_family));
                setVar('--font-title-size', fontVars.title);
                setVar('--font-username-size', fontVars.username);
                setVar('--font-bio-size', fontVars.bio);
                setVar('--font-button-size', fontVars.button);
                setVar('--text-title', design.colors.title);
                setVar('--text-page', design.colors.bio);
                setVar('--text-secondary', design.colors.username);
                setVar('--btn-bg', design.buttons.variant === 'outline' ? 'transparent' : (design.buttons.variant === 'glass' ? 'rgba(255,255,255,0.12)' : design.colors.button_bg));
                setVar('--btn-text', design.colors.button_text);
                setVar('--btn-border', design.colors.button_border);
                setVar('--btn-icon', design.colors.button_icon);
                setVar('--btn-bg-hover', design.buttons.variant === 'glass' ? 'rgba(255,255,255,0.2)' : design.colors.button_bg_hover);
                setVar('--btn-text-hover', design.colors.button_text_hover);
                setVar('--btn-border-hover', design.colors.button_border_hover);
                setVar('--btn-icon-hover', design.colors.button_icon_hover);
                setVar('--link-color', design.colors.button_text);
                setVar('--btn-radius', `${design.buttons.radius}px`);
                setVar('--btn-border-style', design.buttons.border_style);
                setVar('--btn-border-width', `${design.buttons.border_width}px`);
                setVar('--card-shadow', design.buttons.shadow && design.buttons.variant !== 'glass' ? '0 10px 15px -3px rgba(0, 0, 0, 0.12)' : 'none');
                setVar('--anim-color-1', design.background.animation_colors[0] || '#6366f1');
                setVar('--anim-color-2', design.background.animation_colors[1] || '#a855f7');
                setVar('--bg-color', design.background.color || '#f8fafc');

                const alignMap = { left: 'flex-start', center: 'center', right: 'flex-end' };
                setVar('--btn-align', alignMap[design.buttons.align] || 'center');
                setVar('--btn-text-align', design.buttons.align || 'center');

                document.querySelectorAll('.theme-card').forEach((card) => {
                    card.classList.remove('variant-offset', 'backdrop-blur-md');
                    if (design.buttons.variant === 'offset') card.classList.add('variant-offset');
                    if (design.buttons.variant === 'glass') card.classList.add('backdrop-blur-md');
                });

                document.querySelectorAll('.theme-card-label').forEach((titleEl) => {
                    titleEl.classList.toggle('pr-10', design.buttons.align === 'center');
                });

                if (bgWrapper) {
                    bgWrapper.style.backgroundImage = 'none';

                    if (bgImageLayer) {
                        bgImageLayer.style.display = 'none';
                        bgImageLayer.style.backgroundImage = 'none';
                    }

                    if (videoContainer) {
                        videoContainer.style.display = 'none';
                        const oldVideo = videoContainer.querySelector('video');
                        if (oldVideo && activeBackgroundType !== 'video') {
                            oldVideo.pause();
                            oldVideo.removeAttribute('src');
                            oldVideo.load();
                        }
                    }

                    if (animContainer) {
                        animContainer.style.display = 'none';
                    }

                    if (activeBackgroundType === 'gradient') {
                        bgWrapper.style.backgroundImage = shared.buildGradient(design.background);
                    } else if (activeBackgroundType === 'image' && bgImageLayer) {
                        bgImageLayer.style.display = 'block';
                        bgImageLayer.style.backgroundImage = design.background.image_url ? `url('${design.background.image_url}')` : 'none';
                    } else if (activeBackgroundType === 'video') {
                        if (!videoContainer) {
                            videoContainer = document.createElement('div');
                            videoContainer.className = 'bg-video-container';
                            videoContainer.innerHTML = '<video autoplay muted loop playsinline></video>';
                            bgWrapper.appendChild(videoContainer);
                        }
                        videoContainer.style.display = 'block';
                        const videoEl = videoContainer.querySelector('video');
                        if (videoEl && design.background.video_url && videoEl.src !== design.background.video_url) {
                            videoEl.src = design.background.video_url;
                            videoEl.load();
                        }
                    } else if (activeBackgroundType === 'animation') {
                        if (!animContainer) {
                            animContainer = document.createElement('div');
                            animContainer.className = 'bg-anim-container';
                            bgWrapper.appendChild(animContainer);
                        }
                        animContainer.style.display = 'block';
                        animContainer.className = 'bg-anim-container bg-' + design.background.animation;
                    }
                }

                if (overlayEl) {
                    overlayEl.style.backgroundColor = `rgba(0, 0, 0, ${design.background.overlay / 100})`;
                    const blurValue = `${design.background.blur}px`;
                    overlayEl.style.backdropFilter = `blur(${blurValue})`;
                    overlayEl.style.webkitBackdropFilter = `blur(${blurValue})`;
                }

                if (cardWrapper && flexContainer && avatarImg) {
                    avatarImg.className = 'avatar-preview-img object-cover theme-avatar-ring flex-shrink-0';
                    const sizeMap = { sm: 'w-16 h-16', md: 'w-24 h-24', lg: 'w-32 h-32', xl: 'w-40 h-40' };
                    const frameMap = { 'rounded-xl': 'rounded-xl', square: 'rounded-none', polygon: 'avatar-polygon', circle: 'rounded-full' };

                    if (design.header.layout !== 'left-aligned') {
                        (sizeMap[design.header.avatar_size] || sizeMap.md).split(' ').forEach((className) => avatarImg.classList.add(className));
                    }
                    avatarImg.classList.add(frameMap[design.header.avatar_frame] || 'rounded-full');

                    cardWrapper.className = 'relative z-10 p-2 anim-target';
                    if (textContainer) textContainer.className = 'w-full';

                    if (nameEl) nameEl.className = 'mt-4 font-extrabold tracking-tight theme-name break-words';
                    if (usernameEl) usernameEl.className = 'mt-1 font-medium theme-username opacity-80';
                    if (bioEl) bioEl.className = 'mt-4 leading-relaxed theme-bio break-words';

                    if (design.header.layout === 'left-aligned') {
                        cardWrapper.classList.add('text-left');
                        flexContainer.className = 'flex flex-row items-center gap-6';
                        if (textContainer) textContainer.className = 'flex-1 pt-1';
                        if (heroCover) heroCover.style.display = 'none';
                        avatarImg.classList.remove('w-16', 'h-16', 'w-24', 'h-24', 'w-32', 'h-32', 'w-40', 'h-40');
                        avatarImg.classList.add('w-20', 'h-20');
                        if (usernameEl) usernameEl.classList.add('mt-0.5');
                    } else if (design.header.layout === 'hero-cover') {
                        cardWrapper.classList.add('text-center', 'relative', 'pt-12', 'mt-16');
                        flexContainer.className = 'flex flex-col items-center';
                        if (heroCover) heroCover.style.display = 'block';
                        if (heroImage) heroImage.style.backgroundImage = `url('${design.header.hero_image_url || defaultHeroImage}')`;
                        avatarImg.classList.add('-mt-24', 'border-4', 'border-background', 'bg-background', 'shadow-2xl', 'mb-4');
                        if (bioEl) bioEl.classList.add('px-4', 'mt-6');
                        if (nameEl) nameEl.classList.add('mt-6');
                    } else {
                        cardWrapper.classList.add('text-center');
                        flexContainer.className = 'flex flex-col items-center';
                        if (heroCover) heroCover.style.display = 'none';
                    }
                }
            };

            document.addEventListener('DOMContentLoaded', () => {
                applyDesign(initialDesign);
            });

            window.addEventListener('message', (event) => {
                if (event.data?.type === 'DESIGN_UPDATE') {
                    applyDesign(event.data.payload);
                }
            });
        })();
    </script>
</body>
</html>
