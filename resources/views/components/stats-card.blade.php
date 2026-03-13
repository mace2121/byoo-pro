@props(['title', 'value', 'icon' => null, 'trend' => null, 'color' => 'black'])

@php
    $colorClass = 'bg-black text-white dark:bg-white dark:text-black';
@endphp

<div class="bg-white dark:bg-black overflow-hidden rounded-3xl border border-gray-100 dark:border-gray-800 p-6 flex items-center gap-5 transition-all hover:bg-gray-50/50 dark:hover:bg-gray-900/30 group">
    @if($icon)
        <div class="flex-shrink-0 w-12 h-12 rounded-2xl {{ $colorClass }} flex items-center justify-center shadow-xl shadow-black/5 group-hover:scale-105 transition-transform">
            <i class="{{ $icon }} text-lg"></i>
        </div>
    @endif
    
    <div class="flex-1 min-w-0">
        <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">{{ $title }}</p>
        <div class="flex items-baseline gap-2">
            <h4 class="text-2xl font-black text-gray-900 dark:text-white leading-none">
                {{ $value }}
            </h4>
            @if($trend)
                <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                    {{ $trend > 0 ? '+' : '' }}{{ $trend }}%
                </span>
            @endif
        </div>
    </div>
</div>
