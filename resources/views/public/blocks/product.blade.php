@php
    $variantClass = '';
    if (($design['buttons']['variant'] ?? '') === 'offset') {
        $variantClass = 'variant-offset';
    } elseif (($design['buttons']['variant'] ?? '') === 'glass') {
        $variantClass = 'backdrop-blur-md variant-glass';
    }
@endphp

<div class="overflow-hidden transition-all duration-300 theme-card theme-card-stacked group relative {{ $variantClass }}">
    @if($block->image)
        <div class="aspect-[16/9] overflow-hidden border-b border-black/5">
            <img src="{{ $block->image }}" alt="{{ $block->title }}" class="h-full w-full object-cover">
        </div>
    @endif

    <div class="p-4 space-y-3">
        <div class="space-y-1 text-left">
            <div class="flex items-center gap-3">
                <div class="theme-card-icon-wrap flex h-10 w-10 items-center justify-center rounded-lg bg-black/5 dark:bg-white/5">
                    <i class="{{ $block->icon ?: 'fas fa-bag-shopping' }} theme-card-icon text-lg"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h3 class="truncate text-base font-bold">{{ $block->title }}</h3>
                    @if($block->price)
                        <p class="text-sm opacity-70">{{ $block->price }}</p>
                    @endif
                </div>
            </div>

            @if($block->description)
                <p class="text-sm opacity-80">{{ $block->description }}</p>
            @endif
        </div>

        <a href="{{ $block->href }}" target="_blank" rel="noopener noreferrer" class="inline-flex w-full items-center justify-center rounded-[inherit] border border-current/10 px-4 py-3 text-sm font-semibold transition-opacity hover:opacity-90">
            {{ $block->button_label ?: 'Urunu incele' }}
        </a>
    </div>
</div>
