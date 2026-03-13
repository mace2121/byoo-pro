@props(['title', 'value', 'icon', 'color' => 'black'])

<div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] p-6 shadow-sm">
    <div class="flex flex-row items-center justify-between space-y-0 pb-2">
        <h3 class="text-sm font-medium tracking-tight text-[hsl(var(--foreground))]">{{ $title }}</h3>
        <i class="{{ $icon }} text-muted-foreground w-4 h-4 text-center"></i>
    </div>
    <div class="pt-1">
        <div class="text-2xl font-bold tracking-tighter">{{ $value }}</div>
        <p class="text-[10px] text-muted-foreground mt-1 uppercase tracking-widest font-medium">{{ __('Last 30 Days') }}</p>
    </div>
</div>
