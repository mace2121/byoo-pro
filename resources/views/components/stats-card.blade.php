@props(['title', 'value', 'icon' => null, 'trend' => null, 'color' => 'indigo'])

@php
    $colors = [
        'indigo' => 'bg-indigo-500 text-indigo-500 dark:bg-indigo-900/30 dark:text-indigo-400',
        'green' => 'bg-green-500 text-green-500 dark:bg-green-900/30 dark:text-green-400',
        'blue' => 'bg-blue-500 text-blue-500 dark:bg-blue-900/30 dark:text-blue-400',
        'purple' => 'bg-purple-500 text-purple-500 dark:bg-purple-900/30 dark:text-purple-400',
        'amber' => 'bg-amber-500 text-amber-500 dark:bg-amber-900/30 dark:text-amber-400',
    ];
    $colorClass = $colors[$color] ?? $colors['indigo'];
@endphp

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-6 flex items-center gap-5 transition-all hover:shadow-md group">
    @if($icon)
        <div class="flex-shrink-0 w-12 h-12 rounded-xl {{ explode(' ', $colorClass)[0] ?? 'bg-indigo-500' }} flex items-center justify-center text-white shadow-lg shadow-{{ $color }}-500/20 group-hover:scale-110 transition-transform">
            <i class="{{ $icon }} text-lg"></i>
        </div>
    @endif
    
    <div class="flex-1 min-w-0">
        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">{{ $title }}</p>
        <div class="flex items-baseline gap-2">
            <h4 class="text-2xl font-black text-gray-900 dark:text-white leading-none">
                {{ $value }}
            </h4>
            @if($trend)
                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded {{ $trend > 0 ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400' }}">
                    {{ $trend > 0 ? '+' : '' }}{{ $trend }}%
                </span>
            @endif
        </div>
    </div>
</div>
