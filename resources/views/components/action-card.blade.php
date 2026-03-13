@props(['title', 'description' => null, 'icon', 'href', 'color' => 'indigo'])

@php
    $colors = [
        'indigo' => 'text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 dark:text-indigo-400',
        'blue' => 'text-blue-600 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400',
        'purple' => 'text-purple-600 bg-purple-50 dark:bg-purple-900/20 dark:text-purple-400',
        'amber' => 'text-amber-600 bg-amber-50 dark:bg-amber-900/20 dark:text-amber-400',
    ];
    $colorClass = $colors[$color] ?? $colors['indigo'];
@endphp

<a href="{{ $href }}" class="group block p-6 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm hover:shadow-md hover:border-indigo-100 dark:hover:border-indigo-900/50 transition-all">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl {{ $colorClass }} flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
            <i class="{{ $icon }}"></i>
        </div>
        <div class="flex-1">
            <h4 class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $title }}</h4>
            @if($description)
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $description }}</p>
            @endif
        </div>
        <div class="text-gray-300 dark:text-gray-600 group-hover:translate-x-1 group-hover:text-indigo-500 transition-all">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
        </div>
    </div>
</a>
