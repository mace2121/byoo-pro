<x-app-layout>
    <div class="h-[calc(100vh-65px)] overflow-hidden" x-data="{ tab: 'links' }">
        <div class="h-full flex bg-gray-50 dark:bg-black p-4 gap-4">
            <!-- Sidebar Navigation -->
            <aside class="w-72 border border-gray-100 dark:border-gray-800 bg-white dark:bg-black flex-shrink-0 transition-all duration-300 rounded-3xl shadow-sm overflow-hidden" :class="sidebarOpen ? 'ml-0' : '-ml-80 opacity-0'">
                <div class="h-full flex flex-col p-6">
                    <div class="mb-8">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-4 mb-4">{{ __('Navigasyon') }}</p>
                        <nav class="space-y-1">
                            <button @click="tab = 'links'" 
                                    :class="tab === 'links' ? 'bg-black text-white dark:bg-white dark:text-black shadow-xl shadow-black/10' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                                <i class="fas fa-link w-4 text-center"></i>
                                {{ __('Linklerim') }}
                            </button>
                            <button @click="tab = 'stats'" 
                                    :class="tab === 'stats' ? 'bg-black text-white dark:bg-white dark:text-black shadow-xl shadow-black/10' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                                <i class="fas fa-chart-pie w-4 text-center"></i>
                                {{ __('Analytics') }}
                            </button>
                            <button @click="tab = 'design'" 
                                    :class="tab === 'design' ? 'bg-black text-white dark:bg-white dark:text-black shadow-xl shadow-black/10' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                                <i class="fas fa-paint-brush w-4 text-center"></i>
                                {{ __('Tasarım') }}
                            </button>
                            <button @click="tab = 'settings'" 
                                    :class="tab === 'settings' ? 'bg-black text-white dark:bg-white dark:text-black shadow-xl shadow-black/10' : 'text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-900'"
                                    class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                                <i class="fas fa-cog w-4 text-center"></i>
                                {{ __('Ayarlar') }}
                            </button>
                        </nav>
                    </div>

                    <div class="mt-auto">
                        <div class="bg-gray-50 dark:bg-gray-900 p-5 rounded-3xl border border-gray-100 dark:border-gray-800">
                            <p class="text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest">Hızlı Paylaş</p>
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-white dark:bg-black border border-gray-100 dark:border-gray-800 flex items-center justify-center">
                                    <i class="fas fa-qrcode text-black dark:text-white"></i>
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-[10px] font-bold text-gray-500 truncate">{{ route('public.profile', $user->username) }}</p>
                                </div>
                            </div>
                            <button @click="navigator.clipboard.writeText('{{ route('public.profile', $user->username) }}'); $dispatch('notify', 'Kopyalandı!')" class="w-full py-2 bg-black dark:bg-white text-white dark:text-black rounded-xl text-[10px] font-black uppercase tracking-widest transition-all hover:opacity-80">
                                {{ __('Linki Kopyala') }}
                            </button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto px-4 sm:px-8 pb-12 custom-scrollbar transition-all duration-300">
                <div class="max-w-4xl mx-auto py-6">
                    <!-- Links Tab -->
                    <div x-show="tab === 'links'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        @include('dashboard.partials.links-management')
                    </div>
                    
                    <!-- Stats Tab -->
                    <div x-show="tab === 'stats'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="grid grid-cols-1 gap-8">
                            @include('dashboard.partials.stats-cards')
                        </div>
                    </div>

                    <!-- Design Tab -->
                    <div x-show="tab === 'design'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="bg-white dark:bg-black p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                            @include('profile.partials.update-theme-form')
                        </div>
                    </div>

                    <!-- Settings Tab -->
                    <div x-show="tab === 'settings'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="space-y-6">
                            <div class="bg-white dark:bg-black p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                            <div class="bg-white dark:bg-black p-8 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm">
                                @include('profile.partials.update-password-form')
                            </div>
                            <div class="bg-white dark:bg-black p-8 rounded-3xl border border-red-100 dark:border-red-900/30">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Preview Panel (Fixed) -->
            <aside class="hidden xl:block w-[400px] border border-gray-100 dark:border-gray-800 bg-white dark:bg-black p-8 flex-shrink-0 rounded-3xl shadow-sm">
                <div class="sticky top-0 h-full flex flex-col">
                    <header class="mb-6 flex items-center justify-between">
                        <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Canlı Önizleme') }}</h3>
                        <div class="flex gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-gray-100 dark:bg-gray-800"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-gray-100 dark:bg-gray-800"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-gray-100 dark:bg-gray-800"></div>
                        </div>
                    </header>
                    <div class="relative mx-auto w-full max-w-[300px] aspect-[9/19] bg-white dark:bg-black rounded-[3rem] border-[10px] border-black shadow-2xl overflow-hidden ring-4 ring-gray-100 dark:ring-gray-900"
                         x-on:links-updated.window="$refs.previewIframe.src = $refs.previewIframe.src"
                         x-on:profile-updated.window="$refs.previewIframe.src = $refs.previewIframe.src">
                        <iframe x-ref="previewIframe" src="{{ route('public.profile', auth()->user()->username) }}" class="w-full h-full border-none"></iframe>
                    </div>
                    <div class="mt-6 text-center">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ __('Gerçek Zamanlı Senkronize') }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
