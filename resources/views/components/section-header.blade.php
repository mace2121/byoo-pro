@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'mb-8']) }}>
    <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-[0.2em]">{{ $title }}</h3>
    @if($subtitle)
        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 mt-2 leading-relaxed max-w-2xl">{{ $subtitle }}</p>
    @endif
    <div class="w-12 h-1 bg-black dark:bg-white mt-4 rounded-full"></div>
</div>
