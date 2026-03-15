const THEME_PRESETS = {
    minimal: {
        id: 'minimal',
        label: 'Minimal',
        background: {
            active_type: 'color',
            color: '#f8fafc',
        },
        colors: {
            title: '#111827',
            username: '#4b5563',
            bio: '#111827',
            button_bg: '#ffffff',
            button_text: '#111827',
            button_border: '#d1d5db',
            button_icon: '#111827',
            button_bg_hover: '#f3f4f6',
            button_text_hover: '#111827',
            button_border_hover: '#9ca3af',
            button_icon_hover: '#111827',
        },
        buttons: {
            variant: 'solid',
            border_style: 'solid',
            border_width: 1,
            shadow: true,
        },
    },
    dark: {
        id: 'dark',
        label: 'Gece',
        background: {
            active_type: 'color',
            color: '#0f172a',
        },
        colors: {
            title: '#f8fafc',
            username: '#94a3b8',
            bio: '#e2e8f0',
            button_bg: '#1e293b',
            button_text: '#f8fafc',
            button_border: '#334155',
            button_icon: '#f8fafc',
            button_bg_hover: '#334155',
            button_text_hover: '#ffffff',
            button_border_hover: '#475569',
            button_icon_hover: '#ffffff',
        },
        buttons: {
            variant: 'solid',
            border_style: 'solid',
            border_width: 1,
            shadow: true,
        },
    },
    neon: {
        id: 'neon',
        label: 'Neon',
        background: {
            active_type: 'color',
            color: '#050816',
        },
        colors: {
            title: '#67e8f9',
            username: '#22d3ee',
            bio: '#cffafe',
            button_bg: '#0f172a',
            button_text: '#67e8f9',
            button_border: '#22d3ee',
            button_icon: '#67e8f9',
            button_bg_hover: '#111827',
            button_text_hover: '#a5f3fc',
            button_border_hover: '#67e8f9',
            button_icon_hover: '#a5f3fc',
        },
        buttons: {
            variant: 'outline',
            border_style: 'solid',
            border_width: 1,
            shadow: false,
        },
    },
    glass: {
        id: 'glass',
        label: 'Cam',
        background: {
            active_type: 'gradient',
            gradient_color_1: '#70a1ff',
            gradient_color_2: '#7f5af0',
            gradient_angle: 135,
        },
        colors: {
            title: '#ffffff',
            username: '#e2e8f0',
            bio: '#f8fafc',
            button_bg: '#ffffff',
            button_text: '#ffffff',
            button_border: 'rgba(255,255,255,0.28)',
            button_icon: '#ffffff',
            button_bg_hover: 'rgba(255,255,255,0.22)',
            button_text_hover: '#ffffff',
            button_border_hover: 'rgba(255,255,255,0.4)',
            button_icon_hover: '#ffffff',
        },
        buttons: {
            variant: 'glass',
            border_style: 'solid',
            border_width: 1,
            shadow: false,
        },
    },
    midnight: {
        id: 'midnight',
        label: 'Gece Yarisi',
        background: {
            active_type: 'gradient',
            gradient_color_1: '#111827',
            gradient_color_2: '#1d4ed8',
            gradient_angle: 160,
        },
        colors: {
            title: '#eff6ff',
            username: '#93c5fd',
            bio: '#dbeafe',
            button_bg: '#0f172a',
            button_text: '#eff6ff',
            button_border: '#1d4ed8',
            button_icon: '#eff6ff',
            button_bg_hover: '#1e293b',
            button_text_hover: '#ffffff',
            button_border_hover: '#3b82f6',
            button_icon_hover: '#ffffff',
        },
        buttons: {
            variant: 'solid',
            border_style: 'solid',
            border_width: 1,
            shadow: true,
        },
    },
    sunset: {
        id: 'sunset',
        label: 'Gun Batimi',
        background: {
            active_type: 'gradient',
            gradient_color_1: '#f97316',
            gradient_color_2: '#ec4899',
            gradient_angle: 145,
        },
        colors: {
            title: '#ffffff',
            username: '#ffedd5',
            bio: '#fff7ed',
            button_bg: '#ffffff',
            button_text: '#9a3412',
            button_border: '#fdba74',
            button_icon: '#9a3412',
            button_bg_hover: '#ffedd5',
            button_text_hover: '#7c2d12',
            button_border_hover: '#fb923c',
            button_icon_hover: '#7c2d12',
        },
        buttons: {
            variant: 'solid',
            border_style: 'solid',
            border_width: 1,
            shadow: true,
        },
    },
    aurora: {
        id: 'aurora',
        label: 'Aurora',
        background: {
            active_type: 'gradient',
            gradient_color_1: '#0f766e',
            gradient_color_2: '#1d4ed8',
            gradient_angle: 135,
        },
        colors: {
            title: '#d1fae5',
            username: '#6ee7b7',
            bio: '#ecfeff',
            button_bg: 'rgba(255,255,255,0.08)',
            button_text: '#d1fae5',
            button_border: '#34d399',
            button_icon: '#d1fae5',
            button_bg_hover: 'rgba(255,255,255,0.14)',
            button_text_hover: '#ffffff',
            button_border_hover: '#6ee7b7',
            button_icon_hover: '#ffffff',
        },
        buttons: {
            variant: 'outline',
            border_style: 'solid',
            border_width: 1,
            shadow: false,
        },
    },
    forest: {
        id: 'forest',
        label: 'Orman',
        background: {
            active_type: 'color',
            color: '#163020',
        },
        colors: {
            title: '#ecfdf5',
            username: '#86efac',
            bio: '#d1fae5',
            button_bg: '#1f4d2f',
            button_text: '#ecfdf5',
            button_border: '#4ade80',
            button_icon: '#ecfdf5',
            button_bg_hover: '#166534',
            button_text_hover: '#ffffff',
            button_border_hover: '#86efac',
            button_icon_hover: '#ffffff',
        },
        buttons: {
            variant: 'solid',
            border_style: 'solid',
            border_width: 1,
            shadow: true,
        },
    },
    cyber: {
        id: 'cyber',
        label: 'Siber',
        background: {
            active_type: 'color',
            color: '#09090b',
        },
        colors: {
            title: '#f0abfc',
            username: '#22d3ee',
            bio: '#fae8ff',
            button_bg: '#18181b',
            button_text: '#f0abfc',
            button_border: '#22d3ee',
            button_icon: '#22d3ee',
            button_bg_hover: '#27272a',
            button_text_hover: '#ffffff',
            button_border_hover: '#67e8f9',
            button_icon_hover: '#ffffff',
        },
        buttons: {
            variant: 'offset',
            border_style: 'solid',
            border_width: 1,
            shadow: false,
        },
    },
    obsidian: {
        id: 'obsidian',
        label: 'Obsidyen',
        background: {
            active_type: 'color',
            color: '#111111',
        },
        colors: {
            title: '#f5f5f5',
            username: '#a3a3a3',
            bio: '#d4d4d4',
            button_bg: '#1f1f1f',
            button_text: '#f5f5f5',
            button_border: '#3f3f46',
            button_icon: '#f5f5f5',
            button_bg_hover: '#2a2a2a',
            button_text_hover: '#ffffff',
            button_border_hover: '#71717a',
            button_icon_hover: '#ffffff',
        },
        buttons: {
            variant: 'solid',
            border_style: 'solid',
            border_width: 1,
            shadow: true,
        },
    },
};

const FONT_OPTIONS = [
    { id: 'inter', label: 'Inter', family: 'Inter', query: 'Inter:wght@400;500;600;700;800' },
    { id: 'roboto', label: 'Roboto', family: 'Roboto', query: 'Roboto:wght@400;500;700' },
    { id: 'oswald', label: 'Oswald', family: 'Oswald', query: 'Oswald:wght@400;500;600;700' },
    { id: 'poppins', label: 'Poppins', family: 'Poppins', query: 'Poppins:wght@400;500;600;700' },
    { id: 'bai-jamjuree', label: 'Bai Jamjuree', family: 'Bai Jamjuree', query: 'Bai+Jamjuree:wght@400;500;600;700' },
    { id: 'playfair-display', label: 'Playfair Display', family: 'Playfair Display', query: 'Playfair+Display:wght@400;500;700' },
    { id: 'montserrat', label: 'Montserrat', family: 'Montserrat', query: 'Montserrat:wght@400;500;600;700' },
    { id: 'mono', label: 'JetBrains Mono', family: 'JetBrains Mono', query: 'JetBrains+Mono:wght@400;500;700' },
];

const FONT_SIZE_PRESETS = {
    sm: {
        id: 'sm',
        label: 'Kucuk',
        vars: {
            title: '1.875rem',
            username: '0.875rem',
            bio: '0.95rem',
            button: '0.95rem',
        },
    },
    md: {
        id: 'md',
        label: 'Orta',
        vars: {
            title: '2.25rem',
            username: '0.95rem',
            bio: '1rem',
            button: '1rem',
        },
    },
    lg: {
        id: 'lg',
        label: 'Buyuk',
        vars: {
            title: '2.625rem',
            username: '1rem',
            bio: '1.075rem',
            button: '1.05rem',
        },
    },
    xl: {
        id: 'xl',
        label: 'Cok Buyuk',
        vars: {
            title: '3rem',
            username: '1.075rem',
            bio: '1.15rem',
            button: '1.1rem',
        },
    },
};

const DEFAULTS = {
    profile: {
        name: '',
        username: '',
        bio: '',
    },
    header: {
        layout: 'centered-classic',
        hero_image_url: '',
        avatar_size: 'md',
        avatar_frame: 'circle',
        show_name: true,
        show_username: true,
        show_bio: true,
    },
    typography: {
        font_family: 'inter',
        font_size_preset: 'md',
    },
    theme: {
        preset: 'minimal',
    },
    background: {
        active_type: 'color',
        color: '#f8fafc',
        gradient_color_1: '#667eea',
        gradient_color_2: '#764ba2',
        gradient_direction: 'linear',
        gradient_angle: 135,
        image_url: '',
        video_url: '',
        animation: 'anim-1',
        animation_colors: ['#6366f1', '#a855f7'],
        overlay: 0,
        blur: 0,
    },
    colors: {
        title: '#111827',
        username: '#4b5563',
        bio: '#111827',
        button_bg: '#ffffff',
        button_text: '#111827',
        button_border: '#d1d5db',
        button_icon: '#111827',
        button_bg_hover: '#f3f4f6',
        button_text_hover: '#111827',
        button_border_hover: '#9ca3af',
        button_icon_hover: '#111827',
    },
    buttons: {
        variant: 'solid',
        radius: 18,
        border_style: 'solid',
        border_width: 1,
        align: 'center',
        shadow: true,
    },
};

const ALLOWED_LAYOUTS = ['centered-classic', 'left-aligned', 'hero-cover'];
const ALLOWED_AVATAR_SIZES = ['sm', 'md', 'lg', 'xl'];
const ALLOWED_AVATAR_FRAMES = ['circle', 'rounded-xl', 'square', 'polygon'];
const ALLOWED_PRESETS = Object.keys(THEME_PRESETS);
const ALLOWED_FONTS = FONT_OPTIONS.map((option) => option.id);
const ALLOWED_FONT_SIZES = Object.keys(FONT_SIZE_PRESETS);
const ALLOWED_BACKGROUND_TYPES = ['color', 'gradient', 'image', 'video', 'animation'];
const ALLOWED_ANIMATIONS = ['anim-1', 'anim-2', 'anim-3', 'anim-4', 'anim-5'];
const ALLOWED_BUTTON_VARIANTS = ['solid', 'outline', 'glass', 'offset'];
const ALLOWED_BORDER_STYLES = ['solid', 'dashed', 'dotted', 'double'];
const ALLOWED_ALIGNMENTS = ['left', 'center', 'right'];

const clamp = (value, min, max) => Math.min(max, Math.max(min, value));

const parseGradientAngle = (gradient) => {
    if (typeof gradient !== 'string') {
        return DEFAULTS.background.gradient_angle;
    }

    const match = gradient.match(/(-?\d+(?:\.\d+)?)deg/i);
    if (!match) {
        return DEFAULTS.background.gradient_angle;
    }

    return clamp(Number(match[1]) || DEFAULTS.background.gradient_angle, 0, 360);
};

const parseGradientColors = (gradient) => {
    if (typeof gradient !== 'string') {
        return [
            DEFAULTS.background.gradient_color_1,
            DEFAULTS.background.gradient_color_2,
        ];
    }

    const matches = gradient.match(/#[0-9a-fA-F]{3,8}/g);
    if (!Array.isArray(matches) || matches.length < 2) {
        return [
            DEFAULTS.background.gradient_color_1,
            DEFAULTS.background.gradient_color_2,
        ];
    }

    return [matches[0], matches[1]];
};

const sanitizeHexColor = (value, fallback) => {
    if (typeof value !== 'string') {
        return fallback;
    }

    const trimmed = value.trim();

    if (/^#[0-9a-fA-F]{6}$/.test(trimmed)) {
        return trimmed;
    }

    if (/^#[0-9a-fA-F]{3}$/.test(trimmed)) {
        return '#' + trimmed.slice(1).split('').map((char) => char + char).join('');
    }

    return fallback;
};

const sanitizeColorToken = (value, fallback) => {
    if (typeof value !== 'string') {
        return fallback;
    }

    const trimmed = value.trim();

    if (/^#[0-9a-fA-F]{6}$/.test(trimmed) || /^#[0-9a-fA-F]{3}$/.test(trimmed)) {
        return sanitizeHexColor(trimmed, fallback);
    }

    if (/^rgba?\(/i.test(trimmed)) {
        return trimmed;
    }

    return fallback;
};

const sanitizeUrl = (value) => (typeof value === 'string' ? value : '');

const getThemePreset = (presetId) => THEME_PRESETS[presetId] || THEME_PRESETS.minimal;

const buildGradient = (background) => {
    const angle = clamp(Number(background?.gradient_angle) || DEFAULTS.background.gradient_angle, 0, 360);
    const colorOne = sanitizeHexColor(
        background?.gradient_color_1,
        DEFAULTS.background.gradient_color_1,
    );
    const colorTwo = sanitizeHexColor(
        background?.gradient_color_2,
        DEFAULTS.background.gradient_color_2,
    );

    if (background?.gradient_direction === 'radial') {
        return `radial-gradient(circle at center, ${colorOne} 0%, ${colorTwo} 100%)`;
    }

    return `linear-gradient(${angle}deg, ${colorOne} 0%, ${colorTwo} 100%)`;
};

const mapLegacyButtonRadius = (legacyStyle) => {
    if (legacyStyle === 'square') return 0;
    if (legacyStyle === 'soft' || legacyStyle === 'rounded') return 18;
    if (legacyStyle === 'pill') return 30;
    return DEFAULTS.buttons.radius;
};

const normalizeDesign = (input, runtimeDefaults = {}) => {
    const safe = input && typeof input === 'object' ? input : {};
    const themePreset = safe?.theme?.preset || DEFAULTS.theme.preset;
    const preset = getThemePreset(themePreset);
    const legacyGradientColors = parseGradientColors(safe?.background?.gradient);
    const profileDefaults = {
        ...DEFAULTS.profile,
        ...(runtimeDefaults.profile || {}),
    };

    const design = {
        profile: {
            ...profileDefaults,
            ...(safe.profile || {}),
        },
        header: {
            ...DEFAULTS.header,
            ...(safe.header || {}),
        },
        typography: {
            ...DEFAULTS.typography,
            ...(safe.typography || {}),
            font_family:
                safe?.typography?.font_family ||
                safe?.theme?.font_family ||
                DEFAULTS.typography.font_family,
            font_size_preset:
                safe?.typography?.font_size_preset ||
                safe?.theme?.font_size_preset ||
                DEFAULTS.typography.font_size_preset,
        },
        theme: {
            preset: themePreset,
        },
        background: {
            ...DEFAULTS.background,
            ...(preset.background || {}),
            ...(safe.background || {}),
            active_type:
                safe?.background?.active_type ||
                safe?.background?.type ||
                preset.background?.active_type ||
                DEFAULTS.background.active_type,
            gradient_color_1:
                safe?.background?.gradient_color_1 ||
                legacyGradientColors[0] ||
                preset.background?.gradient_color_1 ||
                DEFAULTS.background.gradient_color_1,
            gradient_color_2:
                safe?.background?.gradient_color_2 ||
                legacyGradientColors[1] ||
                preset.background?.gradient_color_2 ||
                DEFAULTS.background.gradient_color_2,
            gradient_angle:
                safe?.background?.gradient_angle ??
                parseGradientAngle(safe?.background?.gradient) ??
                preset.background?.gradient_angle ??
                DEFAULTS.background.gradient_angle,
            animation_colors: Array.isArray(safe?.background?.animation_colors)
                ? safe.background.animation_colors
                : DEFAULTS.background.animation_colors,
        },
        colors: {
            ...DEFAULTS.colors,
            ...(preset.colors || {}),
            ...(safe.colors || {}),
            title:
                safe?.colors?.title ||
                safe?.colors?.text ||
                preset.colors?.title ||
                DEFAULTS.colors.title,
            username:
                safe?.colors?.username ||
                safe?.colors?.page_text ||
                preset.colors?.username ||
                DEFAULTS.colors.username,
            bio:
                safe?.colors?.bio ||
                safe?.colors?.page_text ||
                safe?.colors?.text ||
                preset.colors?.bio ||
                DEFAULTS.colors.bio,
            button_bg:
                safe?.colors?.button_bg ||
                safe?.colors?.btn_bg ||
                safe?.buttons?.bg_color ||
                preset.colors?.button_bg ||
                DEFAULTS.colors.button_bg,
            button_text:
                safe?.colors?.button_text ||
                safe?.colors?.btn_text ||
                safe?.buttons?.text_color ||
                preset.colors?.button_text ||
                DEFAULTS.colors.button_text,
            button_border:
                safe?.colors?.button_border ||
                safe?.buttons?.border_color ||
                preset.colors?.button_border ||
                DEFAULTS.colors.button_border,
            button_icon:
                safe?.colors?.button_icon ||
                safe?.buttons?.icon_color ||
                safe?.buttons?.text_color ||
                preset.colors?.button_icon ||
                DEFAULTS.colors.button_icon,
            button_bg_hover:
                safe?.colors?.button_bg_hover ||
                preset.colors?.button_bg_hover ||
                DEFAULTS.colors.button_bg_hover,
            button_text_hover:
                safe?.colors?.button_text_hover ||
                preset.colors?.button_text_hover ||
                DEFAULTS.colors.button_text_hover,
            button_border_hover:
                safe?.colors?.button_border_hover ||
                preset.colors?.button_border_hover ||
                DEFAULTS.colors.button_border_hover,
            button_icon_hover:
                safe?.colors?.button_icon_hover ||
                preset.colors?.button_icon_hover ||
                DEFAULTS.colors.button_icon_hover,
        },
        buttons: {
            ...DEFAULTS.buttons,
            ...(preset.buttons || {}),
            ...(safe.buttons || {}),
            radius:
                safe?.buttons?.radius ??
                mapLegacyButtonRadius(safe?.buttons?.style),
            border_style:
                safe?.buttons?.border_style ||
                DEFAULTS.buttons.border_style,
            border_width:
                safe?.buttons?.border_width ??
                DEFAULTS.buttons.border_width,
        },
    };

    if (!ALLOWED_LAYOUTS.includes(design.header.layout)) {
        design.header.layout = DEFAULTS.header.layout;
    }
    if (!ALLOWED_AVATAR_SIZES.includes(design.header.avatar_size)) {
        design.header.avatar_size = DEFAULTS.header.avatar_size;
    }
    if (!ALLOWED_AVATAR_FRAMES.includes(design.header.avatar_frame)) {
        design.header.avatar_frame = DEFAULTS.header.avatar_frame;
    }
    if (!ALLOWED_PRESETS.includes(design.theme.preset)) {
        design.theme.preset = DEFAULTS.theme.preset;
    }
    if (!ALLOWED_FONTS.includes(design.typography.font_family)) {
        design.typography.font_family = DEFAULTS.typography.font_family;
    }
    if (!ALLOWED_FONT_SIZES.includes(design.typography.font_size_preset)) {
        design.typography.font_size_preset = DEFAULTS.typography.font_size_preset;
    }
    if (!ALLOWED_BACKGROUND_TYPES.includes(design.background.active_type)) {
        design.background.active_type = DEFAULTS.background.active_type;
    }
    if (!ALLOWED_ANIMATIONS.includes(design.background.animation)) {
        design.background.animation = DEFAULTS.background.animation;
    }
    if (!ALLOWED_BUTTON_VARIANTS.includes(design.buttons.variant)) {
        design.buttons.variant = DEFAULTS.buttons.variant;
    }
    if (!ALLOWED_BORDER_STYLES.includes(design.buttons.border_style)) {
        design.buttons.border_style = DEFAULTS.buttons.border_style;
    }
    if (!ALLOWED_ALIGNMENTS.includes(design.buttons.align)) {
        design.buttons.align = DEFAULTS.buttons.align;
    }

    design.profile.name = String(design.profile.name ?? profileDefaults.name);
    design.profile.username = String(design.profile.username ?? profileDefaults.username);
    design.profile.bio = String(design.profile.bio ?? profileDefaults.bio);

    design.header.hero_image_url = sanitizeUrl(design.header.hero_image_url);
    design.header.show_name = !!design.header.show_name;
    design.header.show_username = !!design.header.show_username;
    design.header.show_bio = !!design.header.show_bio;

    design.background.color = sanitizeHexColor(
        design.background.color,
        preset.background?.color || DEFAULTS.background.color,
    );
    design.background.gradient_color_1 = sanitizeHexColor(
        design.background.gradient_color_1,
        preset.background?.gradient_color_1 || DEFAULTS.background.gradient_color_1,
    );
    design.background.gradient_color_2 = sanitizeHexColor(
        design.background.gradient_color_2,
        preset.background?.gradient_color_2 || DEFAULTS.background.gradient_color_2,
    );
    design.background.gradient_angle = clamp(
        Number(design.background.gradient_angle) || DEFAULTS.background.gradient_angle,
        0,
        360,
    );
    design.background.image_url = sanitizeUrl(design.background.image_url);
    design.background.video_url = sanitizeUrl(design.background.video_url);
    design.background.overlay = clamp(Number(design.background.overlay) || 0, 0, 100);
    design.background.blur = clamp(Number(design.background.blur) || 0, 0, 50);
    design.background.animation_colors = design.background.animation_colors
        .slice(0, 2)
        .map((color, index) =>
            sanitizeHexColor(color, DEFAULTS.background.animation_colors[index]),
        );

    design.colors.title = sanitizeColorToken(design.colors.title, DEFAULTS.colors.title);
    design.colors.username = sanitizeColorToken(
        design.colors.username,
        DEFAULTS.colors.username,
    );
    design.colors.bio = sanitizeColorToken(design.colors.bio, DEFAULTS.colors.bio);
    design.colors.button_bg = sanitizeColorToken(
        design.colors.button_bg,
        preset.colors?.button_bg || DEFAULTS.colors.button_bg,
    );
    design.colors.button_text = sanitizeColorToken(
        design.colors.button_text,
        preset.colors?.button_text || DEFAULTS.colors.button_text,
    );
    design.colors.button_border = sanitizeColorToken(
        design.colors.button_border,
        preset.colors?.button_border || DEFAULTS.colors.button_border,
    );
    design.colors.button_icon = sanitizeColorToken(
        design.colors.button_icon,
        preset.colors?.button_icon || DEFAULTS.colors.button_icon,
    );
    design.colors.button_bg_hover = sanitizeColorToken(
        design.colors.button_bg_hover,
        preset.colors?.button_bg_hover || DEFAULTS.colors.button_bg_hover,
    );
    design.colors.button_text_hover = sanitizeColorToken(
        design.colors.button_text_hover,
        preset.colors?.button_text_hover || DEFAULTS.colors.button_text_hover,
    );
    design.colors.button_border_hover = sanitizeColorToken(
        design.colors.button_border_hover,
        preset.colors?.button_border_hover || DEFAULTS.colors.button_border_hover,
    );
    design.colors.button_icon_hover = sanitizeColorToken(
        design.colors.button_icon_hover,
        preset.colors?.button_icon_hover || DEFAULTS.colors.button_icon_hover,
    );

    design.buttons.radius = clamp(Number(design.buttons.radius) || 0, 0, 36);
    design.buttons.border_width = clamp(Number(design.buttons.border_width) || 1, 0, 8);
    design.buttons.shadow = !!design.buttons.shadow;

    if (design.buttons.variant === 'glass') {
        design.colors.button_bg = 'rgba(255,255,255,0.12)';
        design.colors.button_bg_hover = 'rgba(255,255,255,0.2)';
    }

    if (design.buttons.variant === 'offset') {
        design.buttons.border_style = 'solid';
    }

    design.background.gradient = buildGradient(design.background);
    design.background.type = design.background.active_type;
    design.theme.font_family = design.typography.font_family;
    design.theme.font_size_preset = design.typography.font_size_preset;
    design.theme.custom_theme = false;
    design.colors.text = design.colors.bio;
    design.colors.page_text = design.colors.bio;
    design.colors.btn_bg = design.colors.button_bg;
    design.colors.btn_text = design.colors.button_text;
    design.buttons.bg_color = design.colors.button_bg;
    design.buttons.text_color = design.colors.button_text;
    design.buttons.style =
        design.buttons.radius <= 1 ? 'square' : design.buttons.radius >= 24 ? 'pill' : 'soft';

    return design;
};

const clone = (value) => JSON.parse(JSON.stringify(value));

const applyThemePreset = (input, presetId, runtimeDefaults = {}) => {
    const base = normalizeDesign(input, runtimeDefaults);
    const preset = getThemePreset(presetId);

    base.theme.preset = preset.id;
    base.background = {
        ...base.background,
        ...preset.background,
    };
    base.colors = {
        ...base.colors,
        ...preset.colors,
    };
    base.buttons = {
        ...base.buttons,
        ...preset.buttons,
    };

    return normalizeDesign(base, runtimeDefaults);
};

const getFontOption = (fontId) =>
    FONT_OPTIONS.find((option) => option.id === fontId) || FONT_OPTIONS[0];

const getFontFamilyCss = (fontId) => {
    const option = getFontOption(fontId);
    return option.family;
};

const getFontSizeVars = (presetId) =>
    FONT_SIZE_PRESETS[presetId]?.vars || FONT_SIZE_PRESETS.md.vars;

const loadGoogleFont = (fontId) => {
    if (typeof document === 'undefined') {
        return;
    }

    const option = getFontOption(fontId);
    const id = `design-font-${option.id}`;

    if (document.getElementById(id)) {
        return;
    }

    const link = document.createElement('link');
    link.id = id;
    link.rel = 'stylesheet';
    link.href = `https://fonts.googleapis.com/css2?family=${option.query}&display=swap`;
    document.head.appendChild(link);
};

const DesignEditorShared = {
    themePresets: THEME_PRESETS,
    fontOptions: FONT_OPTIONS,
    fontSizePresets: FONT_SIZE_PRESETS,
    defaults: clone(DEFAULTS),
    normalizeDesign,
    applyThemePreset,
    buildGradient,
    getThemePreset,
    getFontFamilyCss,
    getFontSizeVars,
    getFontOption,
    loadGoogleFont,
    sanitizeHexColor,
};

export default DesignEditorShared;
