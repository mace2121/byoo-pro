<?php

namespace App\Support;

use App\Models\Profile;

class DesignEditor
{
    private const FONT_OPTIONS = [
        'inter' => ['query' => 'Inter:wght@400;500;600;700;800', 'stack' => "'Inter', sans-serif"],
        'roboto' => ['query' => 'Roboto:wght@400;500;700', 'stack' => "'Roboto', sans-serif"],
        'oswald' => ['query' => 'Oswald:wght@400;500;600;700', 'stack' => "'Oswald', sans-serif"],
        'poppins' => ['query' => 'Poppins:wght@400;500;600;700', 'stack' => "'Poppins', sans-serif"],
        'bai-jamjuree' => ['query' => 'Bai+Jamjuree:wght@400;500;600;700', 'stack' => "'Bai Jamjuree', sans-serif"],
        'playfair-display' => ['query' => 'Playfair+Display:wght@400;500;700', 'stack' => "'Playfair Display', serif"],
        'montserrat' => ['query' => 'Montserrat:wght@400;500;600;700', 'stack' => "'Montserrat', sans-serif"],
        'mono' => ['query' => 'JetBrains+Mono:wght@400;500;700', 'stack' => "'JetBrains Mono', monospace"],
    ];

    private const FONT_SIZE_PRESETS = [
        'sm' => ['title' => '1.875rem', 'username' => '0.875rem', 'bio' => '0.95rem', 'button' => '0.95rem'],
        'md' => ['title' => '2.25rem', 'username' => '0.95rem', 'bio' => '1rem', 'button' => '1rem'],
        'lg' => ['title' => '2.625rem', 'username' => '1rem', 'bio' => '1.075rem', 'button' => '1.05rem'],
        'xl' => ['title' => '3rem', 'username' => '1.075rem', 'bio' => '1.15rem', 'button' => '1.1rem'],
    ];

    public static function resolve(?Profile $profile, array $runtimeDefaults = []): array
    {
        $design = is_array($profile?->design_settings) ? $profile->design_settings : [];
        $design = array_replace_recursive(self::legacyDesign($profile), $design);

        $design['profile'] = array_replace([
            'name' => '',
            'username' => '',
            'bio' => '',
        ], $runtimeDefaults['profile'] ?? [], $design['profile'] ?? []);

        $design['theme']['preset'] = self::allowed(
            $design['theme']['preset'] ?? ($profile?->theme ?: 'minimal'),
            ['minimal', 'dark', 'neon', 'glass', 'midnight', 'sunset', 'aurora', 'forest', 'cyber', 'obsidian'],
            'minimal',
        );
        $design['theme']['custom_theme'] = (bool) ($design['theme']['custom_theme'] ?? self::hasLegacyCustomDesign($profile));

        $design['typography']['font_family'] = self::allowed(
            $design['typography']['font_family'] ?? $design['theme']['font_family'] ?? self::mapLegacyFont($profile?->font_family) ?? 'inter',
            array_keys(self::FONT_OPTIONS),
            'inter',
        );
        $design['typography']['font_size_preset'] = self::allowed(
            $design['typography']['font_size_preset'] ?? $design['theme']['font_size_preset'] ?? 'md',
            array_keys(self::FONT_SIZE_PRESETS),
            'md',
        );

        $design['background']['active_type'] = self::allowed(
            $design['background']['active_type'] ?? $design['background']['type'] ?? 'color',
            ['color', 'gradient', 'image', 'video', 'animation'],
            'color',
        );
        $design['background']['type'] = $design['background']['active_type'];
        $design['background']['color'] = self::sanitizeColor($design['background']['color'] ?? '#f8fafc', '#f8fafc');
        $design['background']['gradient_color_1'] = self::sanitizeColor(
            $design['background']['gradient_color_1'] ?? self::parseGradientColors($design['background']['gradient'] ?? null)[0],
            '#667eea',
        );
        $design['background']['gradient_color_2'] = self::sanitizeColor(
            $design['background']['gradient_color_2'] ?? self::parseGradientColors($design['background']['gradient'] ?? null)[1],
            '#764ba2',
        );
        $design['background']['gradient_direction'] = self::allowed($design['background']['gradient_direction'] ?? 'linear', ['linear', 'radial'], 'linear');
        $design['background']['gradient_angle'] = self::clamp((int) ($design['background']['gradient_angle'] ?? self::parseGradientAngle($design['background']['gradient'] ?? null)), 0, 360);
        $design['background']['animation'] = self::allowed($design['background']['animation'] ?? 'anim-1', ['anim-1', 'anim-2', 'anim-3', 'anim-4', 'anim-5'], 'anim-1');
        $design['background']['animation_colors'] = array_values(array_replace(['#6366f1', '#a855f7'], array_slice((array) ($design['background']['animation_colors'] ?? []), 0, 2)));
        $design['background']['overlay'] = self::clamp((int) ($design['background']['overlay'] ?? 0), 0, 100);
        $design['background']['blur'] = self::clamp((int) ($design['background']['blur'] ?? 0), 0, 50);
        $design['background']['gradient'] = self::buildGradient($design['background']);

        $design['colors']['title'] = self::sanitizeColor($design['colors']['title'] ?? $design['colors']['text'] ?? '#111827', '#111827');
        $design['colors']['username'] = self::sanitizeColor($design['colors']['username'] ?? $design['colors']['page_text'] ?? '#4b5563', '#4b5563');
        $design['colors']['bio'] = self::sanitizeColor($design['colors']['bio'] ?? $design['colors']['page_text'] ?? $design['colors']['text'] ?? '#111827', '#111827');
        $design['colors']['button_bg'] = self::sanitizeColor($design['colors']['button_bg'] ?? $design['colors']['btn_bg'] ?? $design['buttons']['bg_color'] ?? '#ffffff', '#ffffff');
        $design['colors']['button_text'] = self::sanitizeColor($design['colors']['button_text'] ?? $design['colors']['btn_text'] ?? $design['buttons']['text_color'] ?? '#111827', '#111827');
        $design['colors']['button_border'] = self::sanitizeColor($design['colors']['button_border'] ?? '#d1d5db', '#d1d5db');
        $design['colors']['button_icon'] = self::sanitizeColor($design['colors']['button_icon'] ?? $design['colors']['button_text'], '#111827');
        $design['colors']['button_bg_hover'] = self::sanitizeColor($design['colors']['button_bg_hover'] ?? '#f3f4f6', '#f3f4f6');
        $design['colors']['button_text_hover'] = self::sanitizeColor($design['colors']['button_text_hover'] ?? $design['colors']['button_text'], '#111827');
        $design['colors']['button_border_hover'] = self::sanitizeColor($design['colors']['button_border_hover'] ?? $design['colors']['button_border'], '#9ca3af');
        $design['colors']['button_icon_hover'] = self::sanitizeColor($design['colors']['button_icon_hover'] ?? $design['colors']['button_icon'], '#111827');

        $design['buttons']['variant'] = self::allowed($design['buttons']['variant'] ?? 'solid', ['solid', 'outline', 'glass', 'offset'], 'solid');
        $design['buttons']['radius'] = self::clamp((int) ($design['buttons']['radius'] ?? self::mapLegacyRadius($design['buttons']['style'] ?? $profile?->button_style)), 0, 36);
        $design['buttons']['border_style'] = self::allowed($design['buttons']['border_style'] ?? 'solid', ['solid', 'dashed', 'dotted', 'double'], 'solid');
        $design['buttons']['border_width'] = self::clamp((int) ($design['buttons']['border_width'] ?? 1), 0, 8);
        $design['buttons']['align'] = self::allowed($design['buttons']['align'] ?? 'center', ['left', 'center', 'right'], 'center');
        $design['buttons']['shadow'] = (bool) ($design['buttons']['shadow'] ?? true);
        $design['buttons']['style'] = $design['buttons']['radius'] <= 1 ? 'square' : ($design['buttons']['radius'] >= 24 ? 'pill' : 'soft');
        $design['buttons']['bg_color'] = $design['colors']['button_bg'];
        $design['buttons']['text_color'] = $design['colors']['button_text'];

        $design['theme']['font_family'] = $design['typography']['font_family'];
        $design['theme']['font_size_preset'] = $design['typography']['font_size_preset'];

        return $design;
    }

    public static function getFontQuery(?string $fontId): ?string
    {
        $fontId = self::allowed($fontId, array_keys(self::FONT_OPTIONS), 'inter');

        return self::FONT_OPTIONS[$fontId]['query'] ?? null;
    }

    public static function getFontStack(?string $fontId): string
    {
        $fontId = self::allowed($fontId, array_keys(self::FONT_OPTIONS), 'inter');

        return self::FONT_OPTIONS[$fontId]['stack'] ?? self::FONT_OPTIONS['inter']['stack'];
    }

    public static function getFontSizeVars(?string $presetId): array
    {
        $presetId = self::allowed($presetId, array_keys(self::FONT_SIZE_PRESETS), 'md');

        return self::FONT_SIZE_PRESETS[$presetId];
    }

    public static function buildGradient(array $background): string
    {
        $colorOne = self::sanitizeColor($background['gradient_color_1'] ?? '#667eea', '#667eea');
        $colorTwo = self::sanitizeColor($background['gradient_color_2'] ?? '#764ba2', '#764ba2');
        $angle = self::clamp((int) ($background['gradient_angle'] ?? 135), 0, 360);

        if (($background['gradient_direction'] ?? 'linear') === 'radial') {
            return "radial-gradient(circle at center, {$colorOne} 0%, {$colorTwo} 100%)";
        }

        return "linear-gradient({$angle}deg, {$colorOne} 0%, {$colorTwo} 100%)";
    }

    public static function inlineCssVariables(array $design): string
    {
        $fontVars = self::getFontSizeVars($design['typography']['font_size_preset'] ?? 'md');
        $buttonBg = ($design['buttons']['variant'] ?? 'solid') === 'outline'
            ? 'transparent'
            : (($design['buttons']['variant'] ?? 'solid') === 'glass' ? 'rgba(255,255,255,0.12)' : ($design['colors']['button_bg'] ?? '#ffffff'));
        $buttonBgHover = ($design['buttons']['variant'] ?? 'solid') === 'glass'
            ? 'rgba(255,255,255,0.2)'
            : ($design['colors']['button_bg_hover'] ?? '#f3f4f6');
        $buttonAlign = match ($design['buttons']['align'] ?? 'center') {
            'left' => 'flex-start',
            'right' => 'flex-end',
            default => 'center',
        };
        $cardShadow = ($design['buttons']['shadow'] ?? true) && ($design['buttons']['variant'] ?? 'solid') !== 'glass'
            ? '0 10px 15px -3px rgba(0, 0, 0, 0.12)'
            : 'none';

        return implode('; ', [
            '--font-family: '.self::getFontStack($design['typography']['font_family'] ?? 'inter'),
            '--font-title-size: '.$fontVars['title'],
            '--font-username-size: '.$fontVars['username'],
            '--font-bio-size: '.$fontVars['bio'],
            '--font-button-size: '.$fontVars['button'],
            '--text-title: '.($design['colors']['title'] ?? '#111827'),
            '--text-page: '.($design['colors']['bio'] ?? '#111827'),
            '--text-secondary: '.($design['colors']['username'] ?? '#4b5563'),
            '--btn-bg: '.$buttonBg,
            '--btn-text: '.($design['colors']['button_text'] ?? '#111827'),
            '--btn-border: '.($design['colors']['button_border'] ?? '#d1d5db'),
            '--btn-icon: '.($design['colors']['button_icon'] ?? '#111827'),
            '--btn-bg-hover: '.$buttonBgHover,
            '--btn-text-hover: '.($design['colors']['button_text_hover'] ?? '#111827'),
            '--btn-border-hover: '.($design['colors']['button_border_hover'] ?? '#9ca3af'),
            '--btn-icon-hover: '.($design['colors']['button_icon_hover'] ?? '#111827'),
            '--link-color: '.($design['colors']['button_text'] ?? '#111827'),
            '--btn-radius: '.(($design['buttons']['radius'] ?? 18).'px'),
            '--btn-border-style: '.($design['buttons']['border_style'] ?? 'solid'),
            '--btn-border-width: '.(($design['buttons']['border_width'] ?? 1).'px'),
            '--card-shadow: '.$cardShadow,
            '--anim-color-1: '.(($design['background']['animation_colors'][0] ?? '#6366f1')),
            '--anim-color-2: '.(($design['background']['animation_colors'][1] ?? '#a855f7')),
            '--btn-align: '.$buttonAlign,
            '--btn-text-align: '.($design['buttons']['align'] ?? 'center'),
        ]);
    }

    private static function legacyDesign(?Profile $profile): array
    {
        if (! $profile) {
            return [];
        }

        $legacy = [
            'theme' => ['preset' => $profile->theme ?: 'minimal'],
        ];

        if ($font = self::mapLegacyFont($profile->font_family)) {
            $legacy['typography']['font_family'] = $font;
        }

        if (! self::hasLegacyCustomDesign($profile)) {
            return $legacy;
        }

        $gradientColors = self::parseGradientColors($profile->bg_gradient);
        $textColor = self::sanitizeColor($profile->text_color, '#111827');
        $buttonColor = self::sanitizeColor($profile->button_color, '#ffffff');
        $buttonTextColor = self::sanitizeColor($profile->button_text_color, '#111827');

        return array_replace_recursive($legacy, [
            'theme' => ['custom_theme' => true],
            'background' => [
                'active_type' => self::allowed($profile->bg_type, ['color', 'gradient', 'image'], 'color'),
                'color' => self::sanitizeColor($profile->bg_color, '#f8fafc'),
                'gradient_color_1' => $gradientColors[0],
                'gradient_color_2' => $gradientColors[1],
                'gradient_angle' => self::parseGradientAngle($profile->bg_gradient),
                'image_url' => $profile->bg_image_url ?? '',
                'overlay' => (int) $profile->bg_overlay,
                'blur' => (int) $profile->bg_blur,
            ],
            'colors' => [
                'title' => $textColor,
                'username' => $textColor,
                'bio' => $textColor,
                'button_bg' => $buttonColor,
                'button_text' => $buttonTextColor,
                'button_border' => $buttonColor,
                'button_icon' => $buttonTextColor,
            ],
            'buttons' => [
                'radius' => self::mapLegacyRadius($profile->button_style),
                'shadow' => (bool) $profile->button_shadow,
            ],
        ]);
    }

    private static function hasLegacyCustomDesign(?Profile $profile): bool
    {
        if (! $profile) {
            return false;
        }

        return $profile->theme_type === 'custom'
            || filled($profile->bg_type)
            || filled($profile->bg_color)
            || filled($profile->bg_gradient)
            || filled($profile->button_color)
            || filled($profile->button_text_color)
            || filled($profile->font_family);
    }

    private static function parseGradientColors(?string $gradient): array
    {
        preg_match_all('/#[0-9a-fA-F]{3,8}/', (string) $gradient, $matches);
        $colors = $matches[0] ?? [];

        return [
            self::sanitizeColor($colors[0] ?? '#667eea', '#667eea'),
            self::sanitizeColor($colors[1] ?? '#764ba2', '#764ba2'),
        ];
    }

    private static function parseGradientAngle(?string $gradient): int
    {
        if (! is_string($gradient) || ! preg_match('/(-?\d+(?:\.\d+)?)deg/i', $gradient, $matches)) {
            return 135;
        }

        return (int) round((float) ($matches[1] ?? 135));
    }

    private static function mapLegacyFont(?string $fontId): ?string
    {
        return match ($fontId) {
            'playfair' => 'playfair-display',
            'serif' => 'playfair-display',
            'sans' => 'inter',
            'outfit', 'inter', 'roboto', 'montserrat', 'oswald', 'poppins', 'bai-jamjuree', 'playfair-display', 'mono' => $fontId,
            default => null,
        };
    }

    private static function mapLegacyRadius(?string $style): int
    {
        return match ($style) {
            'square' => 0,
            'pill' => 30,
            default => 18,
        };
    }

    private static function sanitizeColor(mixed $value, string $fallback): string
    {
        if (! is_string($value) || trim($value) === '') {
            return $fallback;
        }

        $value = trim($value);

        if (preg_match('/^#[0-9a-fA-F]{3}$/', $value) || preg_match('/^#[0-9a-fA-F]{6}$/', $value) || preg_match('/^rgba?\\(/i', $value)) {
            return $value;
        }

        return $fallback;
    }

    private static function clamp(int $value, int $min, int $max): int
    {
        return min($max, max($min, $value));
    }

    private static function allowed(mixed $value, array $allowed, mixed $fallback): mixed
    {
        return in_array($value, $allowed, true) ? $value : $fallback;
    }
}
