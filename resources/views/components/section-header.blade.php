@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <h3 class="text-xl font-black text-gray-900 dark:text-white">{{ $title }}</h3>
    @if($subtitle)
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
    @endif
</div>
