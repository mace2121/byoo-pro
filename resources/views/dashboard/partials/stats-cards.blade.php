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
        color="black"
    />

    <x-stats-card 
        :title="__('Toplam Tıklanma')" 
        :value="number_format($total_clicks)" 
        icon="fas fa-mouse-pointer" 
        color="black"
    />

    <x-stats-card 
        :title="__('Profil Görüntülenme')" 
        :value="number_format($profile_views)" 
        icon="fas fa-eye" 
        color="black"
    />

    <!-- Detailed Stats Header -->
    <div class="col-span-full mt-8 mb-2">
        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ __('Ziyaretçi Analizi') }}</h3>
    </div>

    <!-- Top Browsers -->
    <div class="bg-white dark:bg-black rounded-3xl border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-xs font-black text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2 uppercase tracking-widest">
            <i class="fas fa-globe text-black dark:text-white"></i>
            {{ __('Browsers') }}
        </h3>
        <div class="space-y-4">
            @forelse($top_browsers as $item)
                <div class="flex items-center justify-between group">
                    <span class="text-xs font-bold text-gray-500 group-hover:text-black dark:group-hover:text-white transition-colors">{{ $item->browser ?: 'Other' }}</span>
                    <span class="text-xs font-black text-black dark:text-white">{{ $item->count }}</span>
                </div>
                <div class="w-full h-1 bg-gray-50 dark:bg-gray-900 rounded-full mt-1 overflow-hidden">
                    <div class="h-full bg-black dark:bg-white transition-all duration-1000" style="width: {{ ($total_clicks > 0) ? ($item->count / $total_clicks * 100) : 0 }}%"></div>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">{{ __('No data yet') }}</div>
            @endforelse
        </div>
    </div>

    <!-- Top OS -->
    <div class="bg-white dark:bg-black rounded-3xl border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-xs font-black text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2 uppercase tracking-widest">
            <i class="fas fa-desktop text-black dark:text-white"></i>
            {{ __('Platforms') }}
        </h3>
        <div class="space-y-4">
            @forelse($top_os as $item)
                <div class="flex items-center justify-between group">
                    <span class="text-xs font-bold text-gray-500 group-hover:text-black dark:group-hover:text-white transition-colors">{{ $item->os ?: 'Other' }}</span>
                    <span class="text-xs font-black text-black dark:text-white">{{ $item->count }}</span>
                </div>
                <div class="w-full h-1 bg-gray-50 dark:bg-gray-900 rounded-full mt-1 overflow-hidden">
                    <div class="h-full bg-black dark:bg-white transition-all duration-1000" style="width: {{ ($total_clicks > 0) ? ($item->count / $total_clicks * 100) : 0 }}%"></div>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">{{ __('No data yet') }}</div>
            @endforelse
        </div>
    </div>

    <!-- Top Countries -->
    <div class="bg-white dark:bg-black rounded-3xl border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-xs font-black text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2 uppercase tracking-widest">
            <i class="fas fa-map-marker-alt text-black dark:text-white"></i>
            {{ __('Locations') }}
        </h3>
        <div class="space-y-4">
            @forelse($top_countries as $item)
                <div class="flex items-center justify-between group">
                    <span class="text-xs font-bold text-gray-500 group-hover:text-black dark:group-hover:text-white transition-colors">{{ $item->country ?: __('Global') }}</span>
                    <span class="text-xs font-black text-black dark:text-white">{{ $item->count }}</span>
                </div>
                <div class="w-full h-1 bg-gray-50 dark:bg-gray-900 rounded-full mt-1 overflow-hidden">
                    <div class="h-full bg-black dark:bg-white transition-all duration-1000" style="width: {{ ($total_clicks > 0) ? ($item->count / $total_clicks * 100) : 0 }}%"></div>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">{{ __('No data yet') }}</div>
            @endforelse
        </div>
    </div>
</div>
