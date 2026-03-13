@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'space-y-1.5 mb-6']) }}>
    <h3 class="text-2xl font-semibold leading-none tracking-tight text-foreground">{{ $title }}</h3>
    @if($subtitle)
        <p class="text-sm text-muted-foreground">{{ $subtitle }}</p>
    @endif
</div>
