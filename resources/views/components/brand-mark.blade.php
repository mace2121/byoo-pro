@props([
    'iconClass' => 'h-6 w-6 text-current',
    'textClass' => 'font-bold tracking-tight',
    'dotClass' => 'text-muted-foreground',
])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2']) }}>
    <x-application-logo class="{{ $iconClass }}" />
    <span class="{{ $textClass }}">byoo<span class="{{ $dotClass }}">.pro</span></span>
</span>
