<div class="col-span-full">
    <x-section-header 
        :title="__('Genel Bakış')" 
        :subtitle="__('Profilinizin ve linklerinizin son 30 günlük performans özeti.')" 
    />
</div>

<x-stats-card 
    :title="__('Toplam Link')" 
    :value="number_format($total_links)" 
    icon="fas fa-link" 
    color="indigo"
/>

<x-stats-card 
    :title="__('Toplam Tıklanma')" 
    :value="number_format($total_clicks)" 
    icon="fas fa-mouse-pointer" 
    color="green"
/>

<x-stats-card 
    :title="__('Profil Görüntülenme')" 
    :value="number_format($profile_views)" 
    icon="fas fa-eye" 
    color="blue"
/>

<!-- Detailed Stats Header -->
<div class="col-span-full mt-4">
    <x-section-header 
        :title="__('Ziyaretçi Detayları')" 
    />
</div>

<!-- Detailed Stats Grid -->
<div class="col-span-full grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Top Browsers -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-sm font-black text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2 uppercase tracking-widest">
            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
            {{ __('Top Browsers') }}
        </h3>
        <div class="space-y-3">
            @forelse($top_browsers as $item)
                <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $item->browser ?: 'Other' }}</span>
                    <span class="text-xs font-black text-indigo-600 dark:text-indigo-400">{{ $item->count }}</span>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">{{ __('No data yet') }}</div>
            @endforelse
        </div>
    </div>

    <!-- Top OS -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-sm font-black text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2 uppercase tracking-widest">
            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            {{ __('Top Platforms') }}
        </h3>
        <div class="space-y-3">
            @forelse($top_os as $item)
                <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $item->os ?: 'Other' }}</span>
                    <span class="text-xs font-black text-blue-600 dark:text-blue-400">{{ $item->count }}</span>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">{{ __('No data yet') }}</div>
            @endforelse
        </div>
    </div>

    <!-- Top Countries -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-800 p-6">
        <h3 class="text-sm font-black text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2 uppercase tracking-widest">
            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V11a2 2 0 012-2h1.065" /></svg>
            {{ __('Top Locations') }}
        </h3>
        <div class="space-y-3">
            @forelse($top_countries as $item)
                <div class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <span class="text-xs font-bold text-gray-600 dark:text-gray-400">{{ $item->country ?: __('Global') }}</span>
                    <span class="text-xs font-black text-green-600 dark:text-green-400">{{ $item->count }}</span>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">{{ __('No data yet') }}</div>
            @endforelse
        </div>
    </div>
</div>
