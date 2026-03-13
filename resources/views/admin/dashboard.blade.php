<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Users Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-lg p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dt class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('Users') }}
                                </dt>
                                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($total_users) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Views Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-lg p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dt class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('Total Views') }}
                                </dt>
                                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($total_views) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Clicks Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dt class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('Total Clicks') }}
                                </dt>
                                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($total_clicks) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Links Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <div class="ml-5">
                                <dt class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('Total Links') }}
                                </dt>
                                <dd class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ number_format($total_links) }}
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Popular Profiles -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('Popular Profiles') }}</h3>
                        <div class="space-y-4">
                            @foreach($popular_profiles as $profile)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $profile->avatar_url }}" class="w-10 h-10 rounded-full object-cover">
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $profile->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ '@' . $profile->username }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($profile->views) }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase font-bold">{{ __('Views') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('Recent Users') }}</h3>
                        <div class="space-y-4">
                            @foreach($recent_users as $user)
                                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        @if($user->is_active)
                                            <span class="px-2 py-1 text-[10px] font-bold rounded-full bg-green-100 text-green-700 uppercase tracking-wider">Active</span>
                                        @else
                                            <span class="px-2 py-1 text-[10px] font-bold rounded-full bg-red-100 text-red-700 uppercase tracking-wider">Suspended</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150 shadow-lg shadow-indigo-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    {{ __('Manage Users') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
