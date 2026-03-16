@php
    $variantClass = '';
    if (($design['buttons']['variant'] ?? '') === 'offset') {
        $variantClass = 'variant-offset';
    } elseif (($design['buttons']['variant'] ?? '') === 'glass') {
        $variantClass = 'backdrop-blur-md variant-glass';
    }

    $preview = $block->preview ?? null;
    $displayMode = $block->display_mode ?? 'link';
    $hasRichPreview = $displayMode === 'card' && (filled($preview?->image) || filled($preview?->description) || filled($preview?->domain));
    $displayTitle = $block->title ?: ($preview?->title ?: 'Baglanti');
    $displayDescription = $preview?->description;
    $displayDomain = $preview?->domain;
    $favicon = $preview?->favicon;
    $usesManualIcon = ($block->icon_source ?? 'auto') === 'manual' || filled($block->manual_icon ?? null);
@endphp

<a href="{{ $block->href }}" target="_blank" rel="noopener noreferrer" class="group relative block overflow-hidden transition-all duration-300 theme-card {{ $hasRichPreview ? 'theme-card-stacked' : '' }} {{ $variantClass }}">
    @if($hasRichPreview && $preview?->image)
        <div class="aspect-[16/9] overflow-hidden border-b border-black/5">
            <img src="{{ $preview->image }}" alt="{{ $displayTitle }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-[1.03]">
        </div>
    @endif

    <div class="flex items-{{ $hasRichPreview ? 'start' : 'center' }} gap-3 p-3 {{ $hasRichPreview ? 'md:p-4' : '' }}">
        <div class="theme-card-icon-wrap flex h-10 w-10 flex-shrink-0 items-center justify-center overflow-hidden rounded-lg bg-black/5 dark:bg-white/5 transition-transform group-hover:scale-110" style="color: var(--btn-icon, var(--link-color))">
            @if(! $usesManualIcon && $favicon)
                <img src="{{ $favicon }}" alt="" class="h-5 w-5 object-contain" loading="lazy">
            @else
                <i class="{{ $block->icon ?: 'fas fa-link' }} theme-card-icon text-xl"></i>
            @endif
        </div>

        <div class="min-w-0 flex-1 text-left">
            <div class="theme-card-label font-bold {{ $hasRichPreview ? '' : (($design['buttons']['align'] ?? 'center') === 'center' ? 'pr-10' : '') }}">
                {{ $displayTitle }}
            </div>

            @if($hasRichPreview && $displayDescription)
                <p class="mt-1 overflow-hidden text-sm font-medium opacity-75" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                    {{ $displayDescription }}
                </p>
            @elseif($hasRichPreview && $displayDomain)
                <p class="mt-1 text-xs font-semibold uppercase tracking-widest opacity-60">{{ $displayDomain }}</p>
            @endif
        </div>

        @if($block->password_protected)
            <div class="absolute right-4 top-4 text-gray-400 opacity-50">
                <i class="fas fa-lock text-xs"></i>
            </div>
        @endif
    </div>
</a>
