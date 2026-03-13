<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <x-section-header 
                    :title="__('Yönetici Paneli')" 
                    :subtitle="__('Platform genelindeki kullanıcı aktiviteleri ve sistem istatistiklerine genel bakış.')" 
                />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <x-stats-card 
                    :title="__('Toplam Kullanıcı')" 
                    :value="number_format($total_users)" 
                    icon="fas fa-users" 
                    color="indigo"
                />
                
                <x-stats-card 
                    :title="__('Toplam Görüntülenme')" 
                    :value="number_format($total_views)" 
                    icon="fas fa-eye" 
                    color="purple"
                />

                <x-stats-card 
                    :title="__('Toplam Tıklanma')" 
                    :value="number_format($total_clicks)" 
                    icon="fas fa-mouse-pointer" 
                    color="blue"
                />

                <x-stats-card 
                    :title="__('Toplam Link')" 
                    :value="number_format($total_links)" 
                    icon="fas fa-link" 
                    color="green"
                />
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Popular Profiles -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="p-8">
                        <header class="mb-6 flex items-center justify-between">
                            <h3 class="text-sm font-black text-gray-900 dark:text-gray-100 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-fire text-orange-500"></i>
                                {{ __('Popüler Profiller') }}
                            </h3>
                        </header>
                        <div class="space-y-4">
                            @foreach($popular_profiles as $profile)
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900/40 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <img src="{{ $profile->avatar_url }}" class="w-12 h-12 rounded-xl object-cover shadow-sm">
                                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-900 dark:text-gray-100">{{ $profile->user->name }}</p>
                                            <p class="text-xs font-bold text-indigo-500">{{ '@' . $profile->username }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-black text-gray-900 dark:text-gray-100 leading-none">{{ number_format($profile->views) }}</p>
                                        <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">{{ __('Görüntülenme') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                    <div class="p-8">
                        <header class="mb-6 flex items-center justify-between">
                            <h3 class="text-sm font-black text-gray-900 dark:text-gray-100 uppercase tracking-widest flex items-center gap-2">
                                <i class="fas fa-user-plus text-indigo-500"></i>
                                {{ __('Yeni Kayıtlar') }}
                            </h3>
                        </header>
                        <div class="space-y-4">
                            @foreach($recent_users as $user)
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-transparent hover:border-indigo-100 dark:hover:border-indigo-900/40 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-black text-lg">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                                            <p class="text-xs font-bold text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div>
                                        @if($user->is_active)
                                            <span class="px-3 py-1 text-[10px] font-black rounded-lg bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400 uppercase tracking-widest border border-green-100 dark:border-green-900/50">AKTİF</span>
                                        @else
                                            <span class="px-3 py-1 text-[10px] font-black rounded-lg bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400 uppercase tracking-widest border border-red-100 dark:border-red-900/50">ASKIDA</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-indigo-900 rounded-3xl p-8 shadow-2xl shadow-indigo-500/20">
                <div class="text-center md:text-left">
                    <h3 class="text-xl font-black text-white mb-1">{{ __('Kullanıcı Yönetimi') }}</h3>
                    <p class="text-indigo-200 text-sm">{{ __('Tüm platform kullanıcılarını yönetin, yetkilerini düzenleyin veya sistem erişimlerini kontrol edin.') }}</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-8 py-4 bg-white border border-transparent rounded-2xl font-black text-sm text-indigo-900 uppercase tracking-widest hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-150 shadow-xl group">
                    <i class="fas fa-users-cog mr-3 group-hover:rotate-12 transition-transform"></i>
                    {{ __('Kullanıcıları Yönet') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
