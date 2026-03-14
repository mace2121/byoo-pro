<x-app-layout>
    <div class="h-[calc(100vh-57px)] overflow-hidden flex flex-col" x-data="{ tab: '{{ request()->query('tab', 'links') }}' }">
        <div class="flex-1 flex overflow-hidden">
            <!-- Sidebar Navigation (Shadcn Style) -->
            <aside class="border-r border-border bg-background flex-shrink-0 transition-all duration-300 z-30 flex flex-col" 
                   :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden'">
                <div class="h-full flex flex-col">
                    <!-- Sidebar Header: Logo + Toggle -->
                    <div class="h-14 flex items-center justify-between px-4 border-b border-border">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            <x-application-logo class="h-5 w-5 fill-current" />
                            <span class="font-bold text-sm tracking-tight italic">byoo<span class="text-muted-foreground">.pro</span></span>
                        </a>
                        <button @click="sidebarOpen = false" class="p-1 rounded-md hover:bg-accent text-muted-foreground hover:text-foreground transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                    </div>

                    <!-- Menu -->
                    <div class="flex-1 py-4">
                        <div class="px-4 mb-2">
                            <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest">{{ __('Menu') }}</p>
                        </div>
                        <nav class="space-y-1 px-2">
                            <button @click="tab = 'links'; if(window.innerWidth < 768) sidebarOpen = false" 
                                    :class="tab === 'links' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                                    class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-link w-4 text-center"></i>
                                {{ __('Linklerim') }}
                            </button>
                            <button @click="tab = 'stats'; if(window.innerWidth < 768) sidebarOpen = false" 
                                    :class="tab === 'stats' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                                    class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-chart-pie w-4 text-center"></i>
                                {{ __('Analizler') }}
                            </button>
                            <button @click="tab = 'design'; if(window.innerWidth < 768) sidebarOpen = false" 
                                    :class="tab === 'design' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                                    class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-paint-brush w-4 text-center"></i>
                                {{ __('Tasarım') }}
                            </button>
                            <button @click="tab = 'settings'; if(window.innerWidth < 768) sidebarOpen = false" 
                                    :class="tab === 'settings' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                                    class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-cog w-4 text-center"></i>
                                {{ __('Ayarlar') }}
                            </button>
                        </nav>

                        @if(auth()->user()->is_admin)
                        <div class="px-4 mt-6 mb-2">
                            <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest">{{ __('Yönetim') }}</p>
                        </div>
                        <nav class="space-y-1 px-2">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-muted-foreground hover:bg-accent hover:text-accent-foreground transition-colors">
                                <i class="fas fa-shield-alt w-4 text-center"></i>
                                {{ __('Admin Paneli') }}
                            </a>
                        </nav>
                        @endif
                    </div>

                    <!-- Copy URL Card -->
                    <div class="px-3 pb-4">
                        <div class="rounded-lg border border-border bg-card p-3 shadow-sm">
                            <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest mb-2">{{ __('Profil Linki') }}</p>
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-7 h-7 rounded bg-muted flex items-center justify-center">
                                    <i class="fas fa-qrcode text-[10px]"></i>
                                </div>
                                <p class="text-xs font-medium text-foreground truncate">{{ $user->username }}</p>
                            </div>
                            <button @click="navigator.clipboard.writeText('https://byoo.pro/{{ $user->username }}'); $el.textContent = '{{ __('Kopyalandı!') }}'; setTimeout(() => $el.textContent = '{{ __('Kopyala') }}', 2000)" 
                                    class="w-full py-1.5 bg-primary text-primary-foreground rounded-md text-xs font-semibold hover:bg-primary/90 transition-colors">
                                {{ __('Kopyala') }}
                            </button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 min-w-0 overflow-y-auto bg-background">
                <!-- Collapsed sidebar open button -->
                <div x-show="!sidebarOpen" x-cloak class="sticky top-0 z-20 bg-background border-b border-border px-4 py-2">
                    <button @click="sidebarOpen = true" class="p-1.5 rounded-md hover:bg-accent text-muted-foreground hover:text-foreground transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>

                <div class="max-w-4xl mx-auto p-6 md:p-10 space-y-10">
                    <div x-show="tab === 'links'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        @include('dashboard.partials.links-management')
                    </div>
                    
                    <div x-show="tab === 'stats'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="grid grid-cols-1 gap-6">
                            @include('dashboard.partials.stats-cards')
                        </div>
                    </div>

                    <div x-show="tab === 'design'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="rounded-lg border border-border bg-card p-6 md:p-8 shadow-sm">
                            @include('profile.partials.update-theme-form')
                        </div>
                    </div>

                    <div x-show="tab === 'settings'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="space-y-6">
                            <div class="rounded-lg border border-border bg-card p-6 md:p-8 shadow-sm">
                                <h3 class="text-sm font-semibold mb-4">{{ __('Profil Bilgileri') }}</h3>
                                @include('profile.partials.update-profile-information-form')
                            </div>
                            <div class="rounded-lg border border-border bg-card p-6 md:p-8 shadow-sm">
                                <h3 class="text-sm font-semibold mb-4">{{ __('Özel Alan Adı') }}</h3>
                                @include('profile.partials.update-custom-domain-form')
                            </div>
                            <div class="rounded-lg border border-border bg-card p-6 md:p-8 shadow-sm">
                                <h3 class="text-sm font-semibold mb-4">{{ __('Şifreyi Güncelle') }}</h3>
                                @include('profile.partials.update-password-form')
                            </div>
                            <div class="rounded-lg border border-destructive/20 bg-destructive/5 p-6 md:p-8 rounded-lg">
                                <h3 class="text-sm font-semibold text-destructive mb-4">{{ __('Hesabı Sil') }}</h3>
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Preview Panel (Fixed) -->
            <aside class="hidden xl:block w-[420px] border-l border-border bg-muted/50 p-6 overflow-y-auto">
                <div class="sticky top-0">
                    <header class="mb-6 flex items-center justify-between">
                        <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-[0.2em]">{{ __('Canlı Önizleme') }}</h3>
                        <a href="{{ route('public.profile', auth()->user()->username) }}" target="_blank" class="text-[10px] text-muted-foreground hover:text-foreground transition-colors">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </header>
                    <div class="relative mx-auto w-full max-w-[300px] aspect-[9/18.5] bg-background rounded-[2.5rem] border-[6px] border-foreground/90 shadow-2xl overflow-hidden ring-1 ring-border"
                         x-on:links-updated.window="$refs.previewIframe.src = $refs.previewIframe.src"
                         x-on:profile-updated.window="$refs.previewIframe.src = $refs.previewIframe.src">
                        <iframe x-ref="previewIframe" src="{{ route('public.profile', auth()->user()->username) }}" class="w-full h-full border-none"></iframe>
                    </div>
                    <div class="mt-6 text-center">
                        <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest opacity-50">{{ __('Anlık Senkronize') }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
