<x-app-layout>
    <div class="h-[calc(100vh-65px)] overflow-hidden" x-data="{ tab: 'links' }">
        <div class="h-full flex">
            <!-- Sidebar Navigation -->
            <aside class="w-64 border-r border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 flex-shrink-0 transition-all duration-300" :class="sidebarOpen ? 'ml-0' : '-ml-64'">
                <div class="h-full flex flex-col p-4">
                    <div class="space-y-1 mt-4">
                        <button @click="tab = 'links'" :class="tab === 'links' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800'" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all group">
                            <i class="fas fa-link w-5 text-center" :class="tab === 'links' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600'"></i>
                            {{ __('Linklerim') }}
                        </button>
                        <button @click="tab = 'stats'" :class="tab === 'stats' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800'" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all group">
                            <i class="fas fa-chart-pie w-5 text-center" :class="tab === 'stats' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600'"></i>
                            {{ __('Analytics') }}
                        </button>
                        <button @click="tab = 'appearance'" :class="tab === 'appearance' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800'" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all group">
                            <i class="fas fa-palette w-5 text-center" :class="tab === 'appearance' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600'"></i>
                            {{ __('Görünüm') }}
                        </button>
                        <button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800'" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all group">
                            <i class="fas fa-id-card w-5 text-center" :class="tab === 'profile' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600'"></i>
                            {{ __('Profil Bilgileri') }}
                        </button>
                        <button @click="tab = 'settings'" :class="tab === 'settings' ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-500 hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-800'" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold transition-all group">
                            <i class="fas fa-cog w-5 text-center" :class="tab === 'settings' ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-600'"></i>
                            {{ __('Genel Ayarlar') }}
                        </button>
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-50 dark:border-gray-800">
                        <div class="bg-indigo-600 p-4 rounded-2xl text-white shadow-lg overflow-hidden relative">
                            <div class="relative z-10">
                                <p class="text-[10px] font-black uppercase opacity-80 mb-1">QR Kodun</p>
                                <img src="{{ $qr_code_url }}" alt="QR" class="w-16 h-16 rounded-lg bg-white p-1 mb-2">
                                <button @click="navigator.clipboard.writeText('{{ route('public.profile', $user->username) }}'); alert('Kopyalandı!')" class="text-[10px] font-bold bg-white/20 hover:bg-white/30 px-2 py-1 rounded transition-colors block w-full text-center">
                                    {{ __('Linki Kopyala') }}
                                </button>
                            </div>
                            <div class="absolute -right-4 -bottom-4 w-12 h-12 bg-indigo-500 rounded-full blur-xl opacity-50"></div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-950 p-6 sm:p-8">
                <div class="max-w-4xl mx-auto">
                    <!-- Tab Content -->
                    <div class="mb-12">
                        <!-- Links Tab -->
                        <div x-show="tab === 'links'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                            @include('dashboard.partials.links-management')
                        </div>

                        <!-- Stats Tab -->
                        <div x-show="tab === 'stats'" x-cloak x-transition>
                            <x-section-header :title="__('Analizler')" :subtitle="__('Profilinizin son durumunu ve ziyaretçi verilerini takip edin.')" />
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                                @include('dashboard.partials.stats-cards')
                            </div>
                        </div>

                        <!-- Profile Tab -->
                        <div x-show="tab === 'profile'" x-cloak x-transition class="space-y-6">
                            <x-section-header :title="__('Profil')" :subtitle="__('Kullanıcı bilgilerinizi ve profil ayarlarınızı yönetin.')" />
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-custom-domain-form')
                                </div>
                            </div>
                        </div>

                        <!-- Appearance Tab -->
                        <div x-show="tab === 'appearance'" x-cloak x-transition>
                            <x-section-header :title="__('Görünüm')" :subtitle="__('Sayfanızın tasarımını, renklerini ve yazı tiplerini kişiselleştirin.')" />
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl mt-6">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-theme-form')
                                </div>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div x-show="tab === 'settings'" x-cloak x-transition class="space-y-6">
                            <x-section-header :title="__('Ayarlar')" :subtitle="__('Hesap güvenliğini ve tercihlerini yönetin.')" />
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-2xl">
                                <div class="max-w-xl">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>
                            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm border border-red-100 dark:border-red-900/30 rounded-2xl">
                                <div class="max-w-xl">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Preview Sidebar (Persistent) -->
            <aside class="hidden xl:flex w-[400px] border-l border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 flex-col overflow-hidden">
                <div class="p-4 border-b border-gray-50 dark:border-gray-800 flex items-center justify-between">
                    <span class="text-xs font-black uppercase tracking-widest text-gray-400">{{ __('Canlı Önizleme') }}</span>
                    <a href="{{ route('public.profile', $user->username) }}" target="_blank" class="text-[10px] font-black bg-gray-50 dark:bg-gray-800 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 px-2 py-1 rounded transition-colors">
                        <i class="fas fa-external-link-alt mr-1"></i> {{ __('Görüntüle') }}
                    </a>
                </div>
                <div class="flex-1 overflow-y-auto p-8 flex justify-center bg-gray-50/50 dark:bg-gray-950/50">
                    <div class="w-full max-w-[320px]">
                        <x-profile-preview :user="$user" />
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
