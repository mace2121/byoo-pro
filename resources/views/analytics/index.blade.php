<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Analytics') }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Detailed statistics for your profile and links (Last 30 days).') }}</p>
                </div>
            </div>

            <!-- Main Charts -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('Overview') }}</h3>
                <div class="h-[400px] w-full">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Top Blocks / Links -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('Top Performing Links') }}</h3>
                    <div class="space-y-4">
                        @forelse($topLinks as $block)
                            <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600">
                                        <i class="{{ $block->data['icon'] ?? ($block->sourceLink?->icon_class ?? 'fas fa-link') }}"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $block->title }}</p>
                                        <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $block->button_link ?: ($block->url ?: '#') }}</p>
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $block->clicks }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">{{ __('Clicks') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-8">{{ __('No data yet') }}</p>
                        @endforelse
                    </div>
                </div>

                <div class="space-y-8">
                    <!-- Top Locations (Countries) -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('Top Visitor Locations') }}</h3>
                        <div class="space-y-4">
                            @forelse($topCountries as $item)
                                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 font-bold uppercase">
                                            {{ $item->country ? substr($item->country, 0, 2) : '??' }}
                                        </div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white">{{ __($item->country ?: 'Global') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ $item->count }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">{{ __('Views') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-8">{{ __('No data yet') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Top Cities -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('Cities') }}</h3>
                        <div class="space-y-4">
                            @forelse($topCities as $item)
                                <div class="flex items-center justify-between p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50 border border-gray-100 dark:border-gray-600">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                            <i class="fas fa-city text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $item->city }}</p>
                                            <p class="text-[10px] text-gray-400 uppercase font-bold">{{ $item->country }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ $item->count }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">{{ __('Views') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-8">{{ __('No data yet') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Browser Stats -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('Browsers') }}</h3>
                    <div class="space-y-4">
                        @foreach($topBrowsers as $item)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __($item->browser ?: 'Other') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $item->total }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $topBrowsers->sum('total') > 0 ? min(100, ($item->total / $topBrowsers->sum('total')) * 100) : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- OS Stats -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('Operating Systems') }}</h3>
                    <div class="space-y-4">
                        @foreach($topOS as $item)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600 dark:text-gray-400">{{ __($item->os ?: 'Other') }}</span>
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $item->total }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                    <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $topOS->sum('total') > 0 ? min(100, ($item->total / $topOS->sum('total')) * 100) : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6">{{ __('Recent Clicks') }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase font-bold tracking-wider border-b border-gray-100 dark:border-gray-700">
                                <th class="pb-4">{{ __('Title') }}</th>
                                <th class="pb-4">{{ __('Location') }}</th>
                                <th class="pb-4">{{ __('Time') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($recentClicks as $click)
                                <tr>
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-xs opacity-75">
                                                <i class="{{ $click->block?->data['icon'] ?? 'fas fa-link' }}"></i>
                                            </div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-white truncate max-w-[200px]">{{ $click->block?->title ?: __('Unknown') }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex flex-col">
                                            <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $click->city ?: __('Unknown') }}</p>
                                            <p class="text-[10px] text-gray-500 uppercase font-bold">{{ __($click->country ?: 'Global') }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <p class="text-xs text-gray-500">{{ $click->created_at->diffForHumans() }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-8 text-sm text-gray-500 text-center">{{ __('No data yet') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('mainChart').getContext('2d');
            const chartData = @json($chartData);
            
            const gradientViews = ctx.createLinearGradient(0, 0, 0, 400);
            gradientViews.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
            gradientViews.addColorStop(1, 'rgba(79, 70, 229, 0)');

            const gradientClicks = ctx.createLinearGradient(0, 0, 0, 400);
            gradientClicks.addColorStop(0, 'rgba(147, 51, 234, 0.2)');
            gradientClicks.addColorStop(1, 'rgba(147, 51, 234, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [
                        {
                            label: '{{ __('Profile Views') }}',
                            data: chartData.views,
                            borderColor: '#4f46e5',
                            backgroundColor: gradientViews,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#4f46e5',
                            pointBorderWidth: 2,
                        },
                        {
                            label: '{{ __('Link Clicks') }}',
                            data: chartData.clicks,
                            borderColor: '#9333ea',
                            backgroundColor: gradientClicks,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: '#9333ea',
                            pointBorderWidth: 2,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            padding: 12,
                            titleFont: { size: 14 },
                            bodyFont: { size: 13 },
                            cornerRadius: 8,
                            boxPadding: 6
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0,0,0,0.05)'
                            },
                            ticks: {
                                precision: 0
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
