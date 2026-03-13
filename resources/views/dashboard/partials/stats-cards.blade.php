<div class="col-span-full">
    <x-section-header 
        :title="__('Genel Bakış')" 
        :subtitle="__('Profilinizin ve linklerinizin son 30 günlük performans özeti.')" 
    />
</div>

<div class="col-span-full grid grid-cols-1 md:grid-cols-3 gap-6">
    <x-stats-card 
        :title="__('Toplam Link')" 
        :value="number_format($total_links)" 
        icon="fas fa-link" 
    />

    <x-stats-card 
        :title="__('Toplam Tıklanma')" 
        :value="number_format($total_clicks)" 
        icon="fas fa-mouse-pointer" 
    />

    <x-stats-card 
        :title="__('Profil Görüntülenme')" 
        :value="number_format($profile_views)" 
        icon="fas fa-eye" 
    />

    <!-- Detailed Stats -->
    <div class="col-span-full mt-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Top Browsers -->
            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-sm font-semibold leading-none tracking-tight flex items-center gap-2">
                        <i class="fas fa-globe text-muted-foreground w-4 h-4"></i>
                        {{ __('Browsers') }}
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($top_browsers as $item)
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-muted-foreground">{{ $item->browser ?: 'Other' }}</span>
                                <span class="font-bold">{{ $item->count }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-[hsl(var(--muted))] rounded-full overflow-hidden">
                                <div class="h-full bg-[hsl(var(--primary))] transition-all duration-1000" style="width: {{ ($total_clicks > 0) ? ($item->count / $total_clicks * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-xs text-muted-foreground italic">{{ __('No data yet') }}</div>
                    @endforelse
                </div>
            </div>

            <!-- Top OS -->
            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-sm font-semibold leading-none tracking-tight flex items-center gap-2">
                        <i class="fas fa-desktop text-muted-foreground w-4 h-4"></i>
                        {{ __('Platforms') }}
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($top_os as $item)
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-muted-foreground">{{ $item->os ?: 'Other' }}</span>
                                <span class="font-bold">{{ $item->count }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-[hsl(var(--muted))] rounded-full overflow-hidden">
                                <div class="h-full bg-[hsl(var(--primary))] transition-all duration-1000" style="width: {{ ($total_clicks > 0) ? ($item->count / $total_clicks * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-xs text-muted-foreground italic">{{ __('No data yet') }}</div>
                    @endforelse
                </div>
            </div>

            <!-- Top Countries -->
            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-sm font-semibold leading-none tracking-tight flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-muted-foreground w-4 h-4"></i>
                        {{ __('Locations') }}
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($top_countries as $item)
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-muted-foreground">{{ $item->country ?: __('Global') }}</span>
                                <span class="font-bold">{{ $item->count }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-[hsl(var(--muted))] rounded-full overflow-hidden">
                                <div class="h-full bg-[hsl(var(--primary))] transition-all duration-1000" style="width: {{ ($total_clicks > 0) ? ($item->count / $total_clicks * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-xs text-muted-foreground italic">{{ __('No data yet') }}</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
