<x-app-layout>
    <div class="py-6" x-data="{ tab: 'stats' }">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Main Content Area -->
                <div class="flex-1">
                    <!-- Tabs Navigation -->
                    <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
                        <nav class="-mb-px flex space-x-8 overflow-x-auto" aria-label="Tabs">
                            <button @click="tab = 'stats'" :class="tab === 'stats' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('Analytics') }}
                            </button>
                            <button @click="tab = 'links'" :class="tab === 'links' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('My Links') }}
                            </button>
                            <button @click="tab = 'profile'" :class="tab === 'profile' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('Profile Display') }}
                            </button>
                            <button @click="tab = 'appearance'" :class="tab === 'appearance' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('Appearance') }}
                            </button>
                            <button @click="tab = 'settings'" :class="tab === 'settings' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                {{ __('Settings') }}
                            </button>
                        </nav>
                    </div>

                    <!-- Quick Actions Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                        <x-action-card 
                            :title="__('Yeni Link')" 
                            :description="__('Sayfanıza hızlıca yeni bir bağlantı ekleyin.')" 
                            icon="fas fa-plus-circle" 
                            href="#" 
                            @click.prevent="tab = 'links'"
                            color="indigo"
                        />
                        <x-action-card 
                            :title="__('Görünüm')" 
                            :description="__('Sayfa tasarımınızı ve renklerinizi özelleştirin.')" 
                            icon="fas fa-paint-brush" 
                            href="#" 
                            @click.prevent="tab = 'appearance'"
                            color="purple"
                        />
                        <x-action-card 
                            :title="__('İstatistikler')" 
                            :description="__('Ziyaretçi trafiğinizi detaylıca inceleyin.')" 
                            icon="fas fa-chart-line" 
                            href="#" 
                            @click.prevent="tab = 'stats'"
                            color="blue"
                        />
                        <x-action-card 
                            :title="__('Profil')" 
                            :description="__('Kullanıcı bilgilerinizi ve profil ayarlarınızı yönetin.')" 
                            icon="fas fa-user-cog" 
                            href="#" 
                            @click.prevent="tab = 'profile'"
                            color="amber"
                        />
                    </div>

                    <!-- Share Profile Section (Quick Access) -->
                    <div class="mb-8 p-6 bg-indigo-600 rounded-2xl text-white shadow-xl shadow-indigo-500/20 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden relative">
                        <div class="relative z-10">
                            <h3 class="text-xl font-black mb-2">{{ __('Profilini Dünyayla Paylaş!') }}</h3>
                            <p class="text-indigo-100 text-sm max-w-md">{{ __('QR kodunu indirebilir veya profil linkini kopyalayarak takipçilerinle paylaşabilirsin.') }}</p>
                            <div class="mt-4 flex flex-wrap gap-3">
                                <button @click="navigator.clipboard.writeText('{{ route('public.profile', $user->username) }}'); alert('Link kopyalandı!')" class="px-5 py-2 bg-white text-indigo-600 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-indigo-50 transition-colors">
                                    <i class="fas fa-copy mr-2"></i> {{ __('Linki Kopyala') }}
                                </button>
                                <a href="{{ $qr_code_url }}&download=1" target="_blank" class="px-5 py-2 bg-indigo-500 text-white rounded-xl text-xs font-black uppercase tracking-wider hover:bg-indigo-400 transition-colors border border-indigo-400">
                                    <i class="fas fa-download mr-2"></i> {{ __('QR Kodu İndir') }}
                                </a>
                            </div>
                        </div>
                        <div class="relative z-10 bg-white p-3 rounded-2xl shadow-lg">
                            <img src="{{ $qr_code_url }}" alt="QR Code" class="w-24 h-24">
                        </div>
                        <!-- Background Decorations -->
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-500 rounded-full opacity-50 blur-3xl"></div>
                        <div class="absolute -left-10 -top-10 w-40 h-40 bg-purple-500 rounded-full opacity-30 blur-3xl"></div>
                    </div>

                    <!-- Tab Content -->
                    <div class="space-y-6">
                        
                        <!-- Stats Tab -->
                        <div x-show="tab === 'stats'" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @include('dashboard.partials.stats-cards')
                        </div>

                        <!-- Links Tab -->
                        <div x-show="tab === 'links'" x-cloak>
                            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-2xl p-6">
                                @include('dashboard.partials.links-management')
                            </div>
                        </div>

                        <!-- Profile Display Tab -->
                        <div x-show="tab === 'profile'" x-cloak class="space-y-6">
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-2xl">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-2xl">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-custom-domain-form')
                                </div>
                            </div>
                        </div>

                        <!-- Appearance Tab -->
                        <div x-show="tab === 'appearance'" x-cloak>
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-2xl">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-theme-form')
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div x-show="tab === 'settings'" x-cloak class="space-y-6">
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-2xl">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-2xl border-t-4 border-red-500">
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Preview Area (Sidebar) -->
                <div class="hidden lg:block w-[350px]">
                    <x-profile-preview :user="$user" />
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
