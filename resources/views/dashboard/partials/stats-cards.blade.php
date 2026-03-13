<!-- Total Links Card -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('Total Links') }}</dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($total_links) }}</div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Total Clicks Card -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('Total Clicks') }}</dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($total_clicks) }}</div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Profile Views Card -->
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ __('Profile Views') }}</dt>
                    <dd class="flex items-baseline">
                        <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($profile_views) }}</div>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Stats -->
<div class="col-span-full grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
    <!-- Top Browsers -->
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 hover:shadow-md transition-shadow">
        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
            {{ __('Top Browsers') }}
        </h3>
        <div class="space-y-3">
            @forelse($top_browsers as $item)
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 dark:text-gray-400">{{ $item->browser ?: 'Other' }}</span>
                    <span class="text-xs font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded-full">{{ $item->count }}</span>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">No data yet</div>
            @endforelse
        </div>
    </div>

    <!-- Top OS -->
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 hover:shadow-md transition-shadow">
        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            {{ __('Top Platforms') }}
        </h3>
        <div class="space-y-3">
            @forelse($top_os as $item)
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 dark:text-gray-400">{{ $item->os ?: 'Other' }}</span>
                    <span class="text-xs font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 px-2 py-0.5 rounded-full">{{ $item->count }}</span>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">No data yet</div>
            @endforelse
        </div>
    </div>

    <!-- Top Countries -->
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 hover:shadow-md transition-shadow">
        <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V11a2 2 0 012-2h1.065" /></svg>
            {{ __('Top Locations') }}
        </h3>
        <div class="space-y-3">
            @forelse($top_countries as $item)
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 dark:text-gray-400">{{ $item->country ?: 'Global' }}</span>
                    <span class="text-xs font-bold bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 px-2 py-0.5 rounded-full">{{ $item->count }}</span>
                </div>
            @empty
                <div class="text-center py-4 text-xs text-gray-400 italic">No data yet</div>
            @endforelse
        </div>
    </div>
</div>
