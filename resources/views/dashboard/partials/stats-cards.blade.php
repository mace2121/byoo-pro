<div class="col-span-full flex items-center justify-between mb-4">
    <x-section-header 
        :title="__('Genel Bakış')" 
        :subtitle="__('Profilinizin ve linklerinizin son 30 günlük performans özeti.')" 
        class="mb-0"
    />
    <a href="{{ route('analytics') }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
        {{ __('Detaylı Analiz') }} <i class="fas fa-arrow-right text-[10px]"></i>
    </a>
</div>

<div class="col-span-full grid grid-cols-1 md:grid-cols-3 gap-6">
    <x-stats-card 
        :title="__('Toplam Blok')" 
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
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-zinc-400">{{ $item->browser }}</span>
                                <span class="font-medium text-zinc-300">{{ $item->total }}</span>
                            </div>
                            <div class="h-1 w-full overflow-hidden rounded-full bg-zinc-800">
                                <div class="h-full bg-primary transition-all" style="width: {{ $profile_views > 0 ? min(100, ($item->total / $profile_views) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-zinc-500">{{ __('Henüz veri yok') }}</p>
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
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-zinc-400">{{ $item->os }}</span>
                                <span class="font-medium text-zinc-300">{{ $item->total }}</span>
                            </div>
                            <div class="h-1 w-full overflow-hidden rounded-full bg-zinc-800">
                                <div class="h-full bg-zinc-400 transition-all" style="width: {{ $profile_views > 0 ? min(100, ($item->total / $profile_views) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-zinc-500">{{ __('Henüz veri yok') }}</p>
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
                        <div class="space-y-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-zinc-400">{{ $item->country }}</span>
                                <span class="font-medium text-zinc-300">{{ $item->total ?? $item->count }}</span>
                            </div>
                            <div class="h-1 w-full overflow-hidden rounded-full bg-zinc-800">
                                <div class="h-full bg-primary/40 transition-all" style="width: {{ $profile_views > 0 ? min(100, (($item->total ?? $item->count) / $profile_views) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-zinc-500">{{ __('Henüz veri yok') }}</p>
                    @endforelse
                </div>
            </div>

            <!-- Top Cities -->
            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-sm font-semibold leading-none tracking-tight flex items-center gap-2">
                        <i class="fas fa-city text-muted-foreground w-4 h-4"></i>
                        {{ __('Cities') }}
                    </h3>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($top_cities as $item)
                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-muted-foreground truncate max-w-[150px]">{{ $item->city }}</span>
                                <span class="font-bold">{{ $item->count }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-[hsl(var(--muted))] rounded-full overflow-hidden">
                                <div class="h-full bg-[hsl(var(--primary))] transition-all duration-1000" style="width: {{ ($profile_views > 0) ? ($item->count / $profile_views * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-xs text-muted-foreground italic">{{ __('No data yet') }}</div>
                    @endforelse
                </div>
            </div>

            <!-- Top Links/Blocks -->
            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm md:col-span-2">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-sm font-semibold leading-none tracking-tight flex items-center gap-2">
                        <i class="fas fa-bolt text-muted-foreground w-4 h-4"></i>
                        {{ __('Top Performing Links') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($top_links as $item)
                            <div class="flex items-center justify-between p-3 rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--muted))/10]">
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="{{ $item->data['icon'] ?? 'fas fa-link' }} text-primary/60 text-xs"></i>
                                    <span class="text-xs font-bold truncate">{{ $item->title }}</span>
                                </div>
                                <span class="text-xs font-bold text-primary">{{ $item->clicks }}</span>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-4 text-xs text-muted-foreground italic">{{ __('No data yet') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
