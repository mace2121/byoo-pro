<x-app-layout>
    <div class="h-full flex" x-data="{ tab: '{{ request()->query('tab', 'links') }}', previewOpen: window.innerWidth >= 1280 }">
        <!-- LEFT SIDEBAR (Navigation) -->
        <aside class="border-r border-border bg-background flex-shrink-0 transition-all duration-300 z-30 flex flex-col" 
               :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden'">
            <div class="h-full flex flex-col w-64">
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
                <div class="flex-1 py-4 overflow-y-auto">
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

        <!-- CENTER COLUMN: Navbar + Content -->
        <div class="flex-1 min-w-0 flex flex-col">
            <!-- Navbar -->
            <nav class="h-14 flex-shrink-0 border-b border-border/40 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 flex items-center px-4 md:px-6">
                <!-- Sidebar toggle (only when collapsed) -->
                <button x-show="!sidebarOpen" x-cloak @click="sidebarOpen = true" class="p-2 rounded-md hover:bg-accent transition-colors mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                </button>

                <div class="flex flex-1 items-center justify-end space-x-3">
                    <!-- Preview Toggle Button -->
                    <button @click="previewOpen = !previewOpen" 
                            :class="previewOpen ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md text-xs font-medium transition-colors">
                        <i class="fas fa-mobile-alt text-[10px]"></i>
                        <span class="hidden sm:inline">{{ __('Önizleme') }}</span>
                    </button>

                    <a href="{{ route('public.profile', auth()->user()->username) }}" target="_blank" 
                       class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary text-primary-foreground rounded-md text-xs font-medium hover:bg-primary/90 transition-colors shadow-sm">
                        <i class="fas fa-external-link-alt text-[10px]"></i>
                        {{ __('Sayfamı Gör') }}
                    </a>

                    <div class="flex items-center gap-2 border-l border-border pl-3">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-2 py-1.5 text-sm font-medium rounded-md hover:bg-accent hover:text-accent-foreground transition-colors group">
                                    <span class="mr-2">{{ Auth::user()->name }}</span>
                                    <svg class="h-4 w-4 text-muted-foreground group-hover:text-foreground transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-2 py-1.5 text-xs font-semibold text-muted-foreground uppercase tracking-widest">{{ __('Account') }}</div>
                                <x-dropdown-link :href="route('dashboard', ['tab' => 'settings'])" class="flex items-center">
                                    <i class="fas fa-cog mr-2 w-4 opacity-50"></i> {{ __('Ayarlar') }}
                                </x-dropdown-link>

                                <div class="h-px bg-border my-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="flex items-center text-destructive hover:bg-destructive/10">
                                        <i class="fas fa-sign-out-alt mr-2 w-4"></i> {{ __('Çıkış Yap') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </nav>

            <!-- Content + Preview Row -->
            <div style="display: grid; height: calc(100% - 56px); overflow: hidden;"
                 :style="previewOpen ? 'grid-template-columns: 1fr 340px' : 'grid-template-columns: 1fr 0px'">
                <!-- MAIN CONTENT AREA (always first column) -->
                <div style="overflow-y: auto; min-width: 0;">
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
                </div>

                <!-- RIGHT PREVIEW SIDEBAR (second column, grid-controlled) -->
                <div class="bg-muted/50 transition-all duration-300" 
                     :class="previewOpen ? 'border-l border-border overflow-y-auto' : 'overflow-hidden'"
                     style="min-width: 0;">
                    <div class="h-full flex flex-col p-5">
                        <header class="mb-4 flex items-center justify-between flex-shrink-0">
                            <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-[0.2em]">{{ __('Canlı Önizleme') }}</h3>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('public.profile', auth()->user()->username) }}" target="_blank" class="text-[10px] text-muted-foreground hover:text-foreground transition-colors">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <button @click="previewOpen = false" class="p-1 rounded-md hover:bg-accent text-muted-foreground hover:text-foreground transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </button>
                            </div>
                        </header>
                        <div class="flex-1 flex items-start justify-center overflow-hidden">
                            <div class="relative w-full max-w-[260px] aspect-[9/18.5] bg-background rounded-[2.5rem] border-[6px] border-foreground/90 shadow-2xl overflow-hidden ring-1 ring-border"
                                 x-on:links-updated.window="$refs.previewIframe.src = $refs.previewIframe.src"
                                 x-on:profile-updated.window="$refs.previewIframe.src = $refs.previewIframe.src">
                                <iframe x-ref="previewIframe" src="{{ route('public.profile', auth()->user()->username) }}" class="w-full h-full border-none"></iframe>
                            </div>
                        </div>
                        <div class="mt-3 text-center flex-shrink-0">
                            <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest opacity-50">{{ __('Anlık Senkronize') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
