<x-app-layout>
    @php
        $initialSettings = \App\Support\DesignEditor::resolve(auth()->user()->profile, [
            'profile' => [
                'name' => auth()->user()->name,
                'username' => auth()->user()->username,
                'bio' => auth()->user()->profile?->bio ?? '',
            ],
        ]);
    @endphp
    <div class="h-full flex" x-data="dashboardManager(@js(request()->query('tab', 'links')), @js($initialSettings))">
        <!-- LEFT SIDEBAR (Navigation) -->
        <aside id="tour-sidebar" class="border-r border-border bg-background flex-shrink-0 transition-all duration-300 z-30 flex flex-col" 
               :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden'">
            <div class="h-full flex flex-col w-64">
                <!-- Sidebar Header: Logo + Toggle -->
                <div class="h-14 flex items-center justify-between px-4 border-b border-border">
                    <a href="{{ route('dashboard') }}">
                        <x-brand-mark icon-class="h-5 w-5 text-foreground" text-class="font-bold text-sm tracking-tight italic" dot-class="text-muted-foreground" />
                    </a>
                    <button id="tour-sidebar-close" @click="sidebarOpen = false" class="p-1 rounded-md hover:bg-accent text-muted-foreground hover:text-foreground transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                </div>

                <!-- Menu -->
                <div class="flex-1 py-4 overflow-y-auto">
                    <div class="px-4 mb-2">
                        <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest">{{ __('Menu') }}</p>
                    </div>
                    <nav class="space-y-1 px-2">
                        <button id="tour-links-tab" @click="tab = 'links'; if(window.innerWidth < 768) sidebarOpen = false" 
                                :class="tab === 'links' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-layer-group w-4 text-center"></i>
                            {{ __('Bloklar') }}
                        </button>
                        <button @click="tab = 'stats'; if(window.innerWidth < 768) sidebarOpen = false" 
                                :class="tab === 'stats' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-chart-pie w-4 text-center"></i>
                            {{ __('Analizler') }}
                        </button>
                        <button id="tour-design-tab" @click="tab = 'design'; if(window.innerWidth < 768) sidebarOpen = false" 
                                :class="tab === 'design' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-paint-brush w-4 text-center"></i>
                            {{ __('Tasarım') }}
                        </button>
                        <button @click="tab = 'marketplace'; if(window.innerWidth < 768) sidebarOpen = false" 
                                :class="tab === 'marketplace' ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground'"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-store w-4 text-center"></i>
                            {{ __('Tema Pazarı') }}
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

                <!-- Öğrenme Turu Butonu -->
                <div class="px-3 pb-2">
                    <button onclick="window.startByooTour()" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg border border-dashed border-amber-300 bg-amber-50/50 text-amber-700 hover:bg-amber-100 transition-colors text-xs font-semibold dark:border-amber-500/30 dark:bg-amber-500/5 dark:text-amber-400 dark:hover:bg-amber-500/10">
                        <i class="fas fa-graduation-cap text-sm"></i>
                        <span>Öğrenme Turu</span>
                        <i class="fas fa-play ml-auto text-[10px] opacity-60"></i>
                    </button>
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
                <button id="tour-sidebar-toggle" x-show="!sidebarOpen" x-cloak @click="sidebarOpen = true" class="p-2 rounded-md hover:bg-accent transition-colors mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
                </button>

                <div class="flex flex-1 items-center justify-end space-x-3">
                    <!-- Preview Toggle Button -->
                    <button id="tour-preview-toggle" @click="previewOpen = !previewOpen" 
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
            <div :style="'display: grid; height: calc(100% - 56px); overflow: hidden; grid-template-columns: ' + (previewOpen ? '1fr 340px' : '1fr 0px')">
                <!-- MAIN CONTENT AREA (always first column) -->
                <div style="overflow-y: auto; min-width: 0;">
                    <div class="max-w-4xl mx-auto p-6 md:p-10 space-y-10">
                        @if(!auth()->user()->isPro())
                            <div class="rounded-[28px] border border-amber-200 bg-gradient-to-br from-amber-50 to-orange-50 p-6 sm:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-sm">
                                <div>
                                    <h3 class="flex items-center gap-2 text-xl font-extrabold text-amber-900">
                                        <i class="fas fa-crown text-amber-500"></i> byoo Pro'ya Geç
                                    </h3>
                                    <p class="mt-2 text-sm font-medium text-amber-800">Sınırsız bağlantı, ürün ekleme, onaylanmış rozet, animasyonlu arka planlar ve tamamen özel temalar.</p>
                                    <ul class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-xs font-semibold text-amber-900/80">
                                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-amber-500"></i> Sınırsız Blok</li>
                                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-amber-500"></i> Ürün & Fiyat</li>
                                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-amber-500"></i> Doğrulanmış Rozeti</li>
                                        <li class="flex items-center gap-1.5"><i class="fas fa-check text-amber-500"></i> Gelişmiş Tasarım</li>
                                    </ul>
                                </div>
                                <a href="{{ auth()->user()->getUpgradeUrl() }}" target="_blank" class="shrink-0 inline-flex items-center gap-2 rounded-2xl bg-amber-500 px-6 py-4 text-sm font-bold text-white shadow-lg transition-all hover:-translate-y-1 hover:bg-amber-600 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-amber-500/20">
                                    <i class="fab fa-whatsapp text-xl"></i>
                                    Hemen Yükselt
                                </a>
                            </div>
                        @endif
                        <div x-show="tab === 'links'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                            @include('dashboard.partials.links-management')
                        </div>
                        
                        <div x-show="tab === 'stats'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                            <div class="grid grid-cols-1 gap-6">
                                @include('dashboard.partials.stats-cards')
                            </div>
                        </div>

                        <div x-show="tab === 'design'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" class="h-full">
                            <div class="bg-card border border-border rounded-lg shadow-sm overflow-hidden flex flex-col h-[calc(100vh-8rem)]">
                                <!-- New Sticky Sub Navigation (Scroll Spy Style) -->
                                <div class="sticky top-0 z-20 border-b border-border bg-background/95 backdrop-blur px-4 flex items-center justify-between overflow-x-auto no-scrollbar py-2">
                                    <div class="flex gap-1">
                                        <button @click="scrollToSection('design-header')" 
                                                class="flex flex-col items-center justify-center p-2 rounded-lg transition-all min-w-[70px] hover:bg-muted"
                                                :class="activeDesignSection === 'header' ? 'bg-primary/10 text-primary' : 'text-muted-foreground'">
                                            <i class="fas fa-id-card text-xs mb-1"></i>
                                            <span class="text-[10px] font-semibold">{{ __('Header') }}</span>
                                        </button>
                                        <button @click="scrollToSection('design-font')" 
                                                class="flex flex-col items-center justify-center p-2 rounded-lg transition-all min-w-[70px] hover:bg-muted"
                                                :class="activeDesignSection === 'font' ? 'bg-primary/10 text-primary' : 'text-muted-foreground'">
                                            <i class="fas fa-font text-xs mb-1"></i>
                                            <span class="text-[10px] font-semibold">{{ __('Font') }}</span>
                                        </button>
                                        <button @click="scrollToSection('design-theme')" 
                                                class="flex flex-col items-center justify-center p-2 rounded-lg transition-all min-w-[70px] hover:bg-muted"
                                                :class="activeDesignSection === 'theme' ? 'bg-primary/10 text-primary' : 'text-muted-foreground'">
                                            <i class="fas fa-layer-group text-xs mb-1"></i>
                                            <span class="text-[10px] font-semibold">{{ __('Tema') }}</span>
                                        </button>
                                        <button @click="scrollToSection('design-background')" 
                                                class="flex flex-col items-center justify-center p-2 rounded-lg transition-all min-w-[70px] hover:bg-muted"
                                                :class="activeDesignSection === 'background' ? 'bg-primary/10 text-primary' : 'text-muted-foreground'">
                                            <i class="fas fa-bahai text-xs mb-1"></i>
                                            <span class="text-[10px] font-semibold">{{ __('Arka Plan') }}</span>
                                        </button>
                                        <button @click="scrollToSection('design-colors')" 
                                                class="flex flex-col items-center justify-center p-2 rounded-lg transition-all min-w-[70px] hover:bg-muted"
                                                :class="activeDesignSection === 'colors' ? 'bg-primary/10 text-primary' : 'text-muted-foreground'">
                                            <i class="fas fa-palette text-xs mb-1"></i>
                                            <span class="text-[10px] font-semibold">{{ __('Renk') }}</span>
                                        </button>
                                        <button @click="scrollToSection('design-buttons')" 
                                                class="flex flex-col items-center justify-center p-2 rounded-lg transition-all min-w-[70px] hover:bg-muted"
                                                :class="activeDesignSection === 'buttons' ? 'bg-primary/10 text-primary' : 'text-muted-foreground'">
                                            <i class="fas fa-hand-pointer text-xs mb-1"></i>
                                            <span class="text-[10px] font-semibold">{{ __('Butonlar') }}</span>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-2 pl-3">
                                        <div class="hidden md:flex items-center gap-2 rounded-full border border-border bg-muted/30 px-3 py-1.5 text-[11px] font-medium text-muted-foreground">
                                            <span class="inline-flex h-2 w-2 rounded-full" :class="isSaving ? 'bg-amber-500 animate-pulse' : (isDirty ? 'bg-orange-500' : 'bg-emerald-500')"></span>
                                            <span x-text="isSaving ? '{{ __('Yayınlanıyor') }}' : (isDirty ? '{{ __('Yayınlanmamış değişiklikler') }}' : '{{ __('Tüm değişiklikler yayınlandı') }}')"></span>
                                        </div>
                                        <button x-show="isDirty && !isSaving" x-cloak @click="restoreLastSaved" class="inline-flex items-center gap-2 rounded-lg border border-border bg-background px-3 py-2 text-xs font-semibold text-foreground transition-colors hover:bg-muted">
                                            <i class="fas fa-rotate-left text-[10px]"></i>
                                            <span>{{ __('Geri Al') }}</span>
                                        </button>
                                        <button @click="saveDesign" :disabled="isSaving" :class="isSaving ? 'opacity-60 cursor-not-allowed' : 'hover:opacity-90'" class="inline-flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg text-sm font-bold shadow-lg transition-all">
                                            <i class="fas fa-save text-xs"></i>
                                            <span x-text="isSaving ? '{{ __('Yayınlanıyor...') }}' : '{{ __('Yayınla') }}'"></span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Content Area: Single Page Scrolling -->
                                <div class="flex-1 overflow-y-auto scroll-smooth no-scrollbar p-6" x-ref="designScrollArea" @scroll="handleDesignScroll">
                                    <div id="design-header" class="mb-12 scroll-mt-20 relative z-40">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-id-card"></i> Header
                                        </h3>
                                        @include('dashboard.partials.design.header')
                                    </div>

                                    <div class="relative">
                                        @if(!auth()->user()->canCustomizeTheme())
                                            <div class="absolute inset-0 z-30 flex flex-col items-center justify-start pt-32 bg-background/70 backdrop-blur-[3px] rounded-3xl border border-border/50">
                                                <div class="p-6 text-center max-w-sm rounded-[28px] border border-border bg-card shadow-2xl sticky top-40">
                                                    <div class="w-14 h-14 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                                        <i class="fas fa-lock text-xl text-amber-500"></i>
                                                    </div>
                                                    <h3 class="text-base font-bold">{{ __('Pro Plan Özelliği') }}</h3>
                                                    <p class="mt-2 text-sm text-muted-foreground mb-5">{{ __('Gelişmiş tema ayarları, arka planlar, renk ve font özelleştirmeleri için Pro plan gereklidir.') }}</p>
                                                    
                                                    <a href="{{ auth()->user()->getUpgradeUrl() }}" target="_blank" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-3 text-sm font-bold text-white shadow-sm transition-all hover:bg-amber-600">
                                                        <i class="fab fa-whatsapp text-lg"></i>
                                                        {{ __('Hemen Pro\'ya Geç') }}
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        <hr class="border-border/50 my-10">
                                        <div id="design-font" class="mb-12 scroll-mt-20">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-font"></i> Font
                                        </h3>
                                        @include('dashboard.partials.design.font')
                                    </div>
                                    <hr class="border-border/50 my-10">
                                    <div id="design-theme" class="mb-12 scroll-mt-20">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-layer-group"></i> Tema
                                        </h3>
                                        @include('dashboard.partials.design.theme')
                                    </div>
                                    <hr class="border-border/50 my-10">
                                    <div id="design-background" class="mb-12 scroll-mt-20">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-bahai"></i> Arka Plan
                                        </h3>
                                        @include('dashboard.partials.design.background')
                                    </div>
                                    <hr class="border-border/50 my-10">
                                    <div id="design-colors" class="mb-12 scroll-mt-20">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-palette"></i> Renk
                                        </h3>
                                        @include('dashboard.partials.design.colors')
                                    </div>
                                    <hr class="border-border/50 my-10">
                                    <div id="design-buttons" class="mb-12 scroll-mt-20">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-hand-pointer"></i> Butonlar
                                        </h3>
                                        @include('dashboard.partials.design.buttons')
                                        <div id="design-custom-css" class="mb-12 scroll-mt-20">
                                            <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                                <i class="fab fa-css3-alt"></i> Custom CSS
                                            </h3>
                                            <div class="rounded-2xl border border-input bg-muted/40 p-5 opacity-70 cursor-not-allowed" title="Bu özellik Pro plan ile aktif edilir">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="text-sm font-semibold flex items-center gap-2">
                                                        {{ __('Özel CSS Kodu') }}
                                                        <i class="fas fa-lock text-xs text-amber-500"></i>
                                                    </h4>
                                                </div>
                                                <p class="text-xs text-muted-foreground mb-4">{{ __('Kendi CSS kodlarınızı yazarak profilinizi tamamen özelleştirin. Sadece Pro plan kullanıcıları içindir.') }}</p>
                                                <textarea disabled rows="4" class="w-full resize-none rounded-xl border-input bg-background/50 text-xs font-mono text-muted-foreground shadow-sm cursor-not-allowed mb-3" placeholder="/* Custom CSS buraya yazilir... */"></textarea>
                                                <a href="{{ auth()->user()->getUpgradeUrl() }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-500 transition-colors hover:text-amber-600">
                                                    <i class="fab fa-whatsapp text-sm"></i> {{ __('Pro\'ya Geçerek Aktifleştir') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <!-- Action Bar (Hidden in single page as it is now in the nav bar) -->
                                <div class="border-t border-border bg-muted/10 px-4 py-3 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                                    <div class="flex items-center gap-2 text-[11px] text-muted-foreground">
                                        <i class="fas fa-bolt text-[10px]"></i>
                                        <span>{{ __('Tasarım ayarlarınız canlı önizleme ile senkronize edilir') }}</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-[10px] font-medium">
                                        <span class="text-muted-foreground">{{ __('Kısayol:') }} <kbd class="rounded border border-border bg-background px-1.5 py-0.5 font-mono">Ctrl/Cmd + S</kbd></span>
                                        <span x-show="saveFeedback.message" x-cloak :class="saveFeedback.type === 'error' ? 'text-destructive' : 'text-emerald-600 dark:text-emerald-400'" x-text="saveFeedback.message"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'marketplace'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                            <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h1 class="text-3xl font-extrabold tracking-tight text-foreground">{{ __('Tema Pazarı') }}</h1>
                                    <p class="mt-2 text-muted-foreground">{{ __('Topluluk tarafından oluşturulan en iyi temaları keşfet.') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                                @forelse($marketplace_themes as $theme)
                                    <div class="group relative flex flex-col overflow-hidden rounded-[2.5rem] border border-border bg-card shadow-sm transition-all hover:shadow-xl hover:-translate-y-1">
                                        <div class="aspect-[9/16] w-full overflow-hidden bg-muted relative">
                                            @if($theme->preview_image)
                                                <img src="{{ $theme->preview_image }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-primary/10 to-primary/20">
                                                    <div class="p-8 text-center">
                                                        <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-background shadow-sm">
                                                            <i class="fas fa-palette text-2xl text-primary"></i>
                                                        </div>
                                                        <p class="text-sm font-bold uppercase tracking-widest text-primary/60">{{ $theme->name }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($theme->is_premium)
                                                <div class="absolute top-4 right-4 z-10">
                                                    <span class="inline-flex items-center rounded-full bg-primary/95 px-2.5 py-1 text-[10px] font-bold uppercase tracking-widest text-primary-foreground backdrop-blur-md shadow-sm">
                                                        PRO
                                                    </span>
                                                </div>
                                            @endif

                                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center p-6 backdrop-blur-sm">
                                                <form action="{{ route('themes.apply', $theme) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="w-full rounded-2xl bg-white px-8 py-3 text-sm font-bold text-black transition-all hover:scale-105 active:scale-95 shadow-lg">
                                                        {{ __('Temayı Uygula') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="flex flex-1 flex-col p-6">
                                            <div class="flex items-start justify-between">
                                                <div class="min-w-0">
                                                    <h3 class="text-lg font-bold truncate">{{ $theme->name }}</h3>
                                                    <p class="text-[10px] font-bold uppercase tracking-widest text-muted-foreground mt-1">
                                                        {{ __('Tarafından') }} {{ $theme->creator->name ?? 'System' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full py-24 text-center">
                                        <div class="mb-6 inline-flex h-20 w-20 items-center justify-center rounded-[2rem] bg-muted/50 border border-border">
                                            <i class="fas fa-store-slash text-2xl text-muted-foreground"></i>
                                        </div>
                                        <h3 class="text-xl font-bold">{{ __('Henüz tema yok') }}</h3>
                                        <p class="mt-2 text-muted-foreground">{{ __('Marketplace açıldığında burada topluluk temalarını göreceksiniz.') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div x-show="tab === 'settings'"
 x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
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
                <div id="tour-preview" class="bg-muted/50 transition-all duration-300" 
                     :class="previewOpen ? 'border-l border-border overflow-y-auto' : 'overflow-hidden'"
                     style="min-width: 0;">
                    <div class="h-full flex flex-col p-5">
                        <header class="mb-4 flex items-center justify-between flex-shrink-0 border-b border-border/50 pb-2">
                            <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-[0.2em]">{{ __('Canlı Önizleme') }}</h3>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('public.profile', auth()->user()->username) }}" target="_blank" class="text-[10px] text-muted-foreground hover:text-foreground transition-colors p-1 rounded-md hover:bg-accent">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <button id="tour-preview-close" @click="previewOpen = false" class="p-1 rounded-md hover:bg-accent text-muted-foreground hover:text-foreground transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </button>
                            </div>
                        </header>
                        <div class="flex-1 flex flex-col min-h-0 bg-background rounded-xl border border-border shadow-2xl overflow-hidden relative group">
                            <!-- Minimal status bar -->
                            <div class="h-6 flex items-center justify-between px-4 bg-muted/20 border-b border-border/10 flex-shrink-0">
                                <div class="flex gap-1">
                                    <div class="w-1.5 h-1.5 rounded-full bg-destructive/40"></div>
                                    <div class="w-1.5 h-1.5 rounded-full bg-yellow-500/40"></div>
                                    <div class="w-1.5 h-1.5 rounded-full bg-green-500/40"></div>
                                </div>
                                <span class="text-[8px] font-mono opacity-30">{{ $user->username }}.byoo.pro</span>
                            </div>
                            
                            <div class="flex-1 relative overflow-hidden">
                                <iframe x-ref="previewIframe" 
                                        @load="handlePreviewLoad"
                                        src="{{ route('public.profile', auth()->user()->username) }}" 
                                        class="w-full h-full border-none"></iframe>
                            </div>
                        </div>
                        <div class="mt-3 text-center flex-shrink-0">
                            <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest opacity-40">{{ __('Taslak görünüm anlık olarak güncellenir') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Onboarding Tour — Sifir bagimlılık, saf JS/CSS --}}
    <style>
        #byoo-tour-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.45);
            z-index: 9998; display: none;
        }
        #byoo-tour-box {
            position: fixed; z-index: 9999;
            background: #fff; border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            border: 1px solid #e5e7eb;
            padding: 1.5rem; max-width: 320px; width: 90%;
            font-family: inherit;
        }
        #byoo-tour-box .tour-title {
            font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;
        }
        #byoo-tour-box .tour-text {
            font-size: 0.875rem; color: #4b5563; line-height: 1.6; margin-bottom: 1.25rem;
        }
        #byoo-tour-box .tour-footer {
            display: flex; justify-content: space-between; align-items: center; gap: 0.5rem;
        }
        #byoo-tour-box .tour-dots {
            display: flex; gap: 5px;
        }
        #byoo-tour-box .tour-dot {
            width: 6px; height: 6px; border-radius: 50%; background: #d1d5db; transition: background .2s;
        }
        #byoo-tour-box .tour-dot.active { background: #f59e0b; }
        #byoo-tour-box .tour-btn-skip {
            background: none; border: 1px solid #e5e7eb; border-radius: 9999px;
            font-size: 0.75rem; font-weight: 600; padding: 0.4rem 0.9rem;
            cursor: pointer; color: #6b7280; transition: all .15s;
        }
        #byoo-tour-box .tour-btn-skip:hover { background: #f3f4f6; }
        #byoo-tour-box .tour-btn-next {
            background: #f59e0b; color: #fff; border: none; border-radius: 9999px;
            font-size: 0.75rem; font-weight: 700; padding: 0.4rem 1rem;
            cursor: pointer; transition: all .15s;
        }
        #byoo-tour-box .tour-btn-next:hover { background: #d97706; }
        #byoo-tour-highlight {
            position: fixed; z-index: 9997;
            border-radius: 0.5rem;
            box-shadow: 0 0 0 4000px rgba(0,0,0,0.45), 0 0 0 3px #f59e0b;
            pointer-events: none; transition: all .25s ease;
        }
    </style>

    <div id="byoo-tour-overlay"></div>
    <div id="byoo-tour-highlight" style="display:none"></div>
    <div id="byoo-tour-box" style="display:none">
        <div class="tour-title" id="byoo-tour-title"></div>
        <div class="tour-text" id="byoo-tour-text"></div>
        <div class="tour-footer">
            <div class="tour-dots" id="byoo-tour-dots"></div>
            <div style="display:flex;gap:0.5rem">
                <button class="tour-btn-skip" id="byoo-tour-skip">Kapat</button>
                <button class="tour-btn-next" id="byoo-tour-next">İleri →</button>
            </div>
        </div>
    </div>

    <script>
    (function() {
        const steps = [
            {
                title: '👋 byoo\'ya Hoş Geldin!',
                text: 'Sana kısa bir tur hazırladık. Her adımda platformun nasıl kullanıldığını göstereceğiz.',
                target: null
            },
            {
                title: '📋 Sol Menü',
                text: 'Buradan Bloklar, Tasarım, Analizler ve Ayarlar bölümlerine geçiş yapabilirsin.',
                target: '#tour-sidebar'
            },
            {
                title: '◀ Menüyü Daralt (1)',
                text: 'Bu ok butonuna basarak sol menüyü kapatabilirsin. Bu sayede çalışma alanın genişler ve içeriklerine daha rahat odaklanabilirsin.',
                target: '#tour-sidebar-close',
                position: 'right'
            },
            {
                title: '🔗 Bloklar',
                text: 'Profil sayfana link, sosyal medya ve ürün blokları ekleyebilirsin.',
                target: '#tour-links-tab'
            },
            {
                title: '🎨 Tasarım',
                text: 'Renk, font, arka plan ve buton stilini buradan özelleştirebilirsin.',
                target: '#tour-design-tab'
            },
            {
                title: '▶ Önizlemeyi Kapat (2)',
                text: 'Sağ paneldeki bu ok butonuna basarak canlı önizlemeyi kapatabilirsin. Böylece daha geniş bir çalışma alanı elde edebilirsin.',
                target: '#tour-preview-close',
                position: 'left'
            },
            {
                title: '📱 Önizlemeyi Aç (3)',
                text: 'Üst menüdeki "Önizleme" butonuna her zaman basarak canlı önizlemeyi tekrar açabilirsin. Değişikliklerini anında görebilirsin!',
                target: '#tour-preview-toggle',
                position: 'bottom'
            },
            {
                title: '🚀 Hazırsın!',
                text: 'Artık byoo\'yu verimli kullanmak için her şeyi biliyorsun. Başarılar! 🎉',
                target: null,
                last: true
            }
        ];

        let current = 0;
        const overlay   = document.getElementById('byoo-tour-overlay');
        const box       = document.getElementById('byoo-tour-box');
        const highlight = document.getElementById('byoo-tour-highlight');
        const titleEl   = document.getElementById('byoo-tour-title');
        const textEl    = document.getElementById('byoo-tour-text');
        const dotsEl    = document.getElementById('byoo-tour-dots');
        const skipBtn   = document.getElementById('byoo-tour-skip');
        const nextBtn   = document.getElementById('byoo-tour-next');

        function markDone() {
            fetch('{{ route('profile.onboarding.complete') }}', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            }).catch(() => {});
        }

        function closeTour() {
            overlay.style.display = 'none';
            box.style.display = 'none';
            highlight.style.display = 'none';
        }

        function renderDots() {
            dotsEl.innerHTML = steps.map((_, i) =>
                `<span class="tour-dot ${i === current ? 'active' : ''}"></span>`
            ).join('');
        }

        function positionBox(targetEl) {
            box.style.display = 'block';
            if (!targetEl) {
                // Ortada göster
                box.style.top = '50%';
                box.style.left = '50%';
                box.style.transform = 'translate(-50%, -50%)';
                return;
            }
            const r = targetEl.getBoundingClientRect();
            const bw = box.offsetWidth || 320;
            const bh = box.offsetHeight || 200;
            const margin = 16;
            let top, left;
            box.style.transform = '';

            // Sağ tarafa sığıyor mu?
            if (r.right + bw + margin < window.innerWidth) {
                left = r.right + margin;
                top  = Math.min(r.top, window.innerHeight - bh - margin);
            } else {
                // Sol tarafa düş
                left = Math.max(margin, r.left - bw - margin);
                top  = Math.min(r.top, window.innerHeight - bh - margin);
            }

            box.style.top  = Math.max(margin, top) + 'px';
            box.style.left = Math.max(margin, left) + 'px';
        }

        function showStep(index) {
            const step = steps[index];
            titleEl.textContent = step.title;
            textEl.textContent  = step.text;
            nextBtn.textContent = step.last ? '✅ Turu Bitir' : 'İleri →';
            renderDots();

            const targetEl = step.target ? document.querySelector(step.target) : null;

            if (targetEl) {
                const r = targetEl.getBoundingClientRect();
                highlight.style.display = 'block';
                highlight.style.top     = r.top + window.scrollY - 4 + 'px';
                highlight.style.left    = r.left + window.scrollX - 4 + 'px';
                highlight.style.width   = r.width + 8 + 'px';
                highlight.style.height  = r.height + 8 + 'px';
            } else {
                highlight.style.display = 'none';
            }

            // Box konumunu targetEl'e göre ayarla
            setTimeout(() => positionBox(targetEl), 10);
        }

        window.startByooTour = function() {
            current = 0;
            overlay.style.display = 'block';
            box.style.display = 'block';
            showStep(0);
        };

        skipBtn.addEventListener('click', function() {
            closeTour();
            markDone();
        });

        nextBtn.addEventListener('click', function() {
            if (current < steps.length - 1) {
                current++;
                showStep(current);
            } else {
                closeTour();
                markDone();
            }
        });

        overlay.addEventListener('click', function() {
            closeTour();
        });
    })();
    </script>


    <style>
        .design-color-control {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .design-color-swatch {
            position: relative;
            display: inline-flex;
            width: 3rem;
            height: 3rem;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 9999px;
            border: 1px solid hsl(var(--border));
            background: hsl(var(--background));
            box-shadow: 0 8px 24px -18px rgba(15, 23, 42, 0.7);
        }

        .design-color-input {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 100%;
            border: 0;
            padding: 0;
            background: transparent;
            cursor: pointer;
        }

        .design-color-input::-webkit-color-swatch-wrapper {
            padding: 0;
        }

        .design-color-input::-webkit-color-swatch {
            border: 0;
            border-radius: 9999px;
        }

        .design-color-input::-moz-color-swatch {
            border: 0;
            border-radius: 9999px;
        }
    </style>

    @push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('dashboardManager', (initialTab, initialSettings) => {
            const shared = window.DesignEditorShared;
            const runtimeDefaults = {
                profile: {
                    name: {!! json_encode(auth()->user()->name) !!},
                    username: {!! json_encode(auth()->user()->username) !!},
                    bio: {!! json_encode(auth()->user()->profile?->bio ?? '') !!},
                },
            };

            const fontSizeLabels = {
                sm: 'Küçük',
                md: 'Orta',
                lg: 'Büyük',
                xl: 'Çok Büyük',
            };

            const themePresetOptions = Object.values(shared.themePresets).map((preset) => {
                const previewStyle = preset.background?.active_type === 'gradient'
                    ? `background:${shared.buildGradient(preset.background)}`
                    : `background:${preset.background?.color || '#f8fafc'}`;

                return {
                    id: preset.id,
                    label: preset.label,
                    previewStyle,
                    card: preset.buttons?.variant === 'glass'
                        ? 'rgba(255,255,255,0.12)'
                        : (preset.colors?.button_bg || '#ffffff'),
                    border: preset.colors?.button_border || '#d1d5db',
                    text: preset.colors?.title || '#111827',
                    muted: preset.colors?.username || '#6b7280',
                };
            });

            return {
                runtimeDefaults,
                tab: initialTab,
                activeDesignSection: 'header',
                sidebarOpen: window.innerWidth >= 768,
                previewOpen: window.innerWidth >= 1280,
                previewReady: false,
                previewSyncTimer: null,
                pendingPreviewPayload: null,
                previewSnapshot: '',
                beforeUnloadHandler: null,
                shortcutHandler: null,
                previewEventHandler: null,
                previewEventTarget: null,
                blocksEventHandler: null,
                feedbackTimer: null,
                isSaving: false,
                isDirty: false,
                lastSavedSnapshot: '',
                saveFeedback: {
                    message: '',
                    type: 'success',
                },
                themePresetOptions,
                fontOptions: shared.fontOptions.map((font) => ({
                    id: font.id,
                    label: font.label,
                    family: font.family,
                })),
                fontSizeOptions: Object.keys(shared.fontSizePresets).map((sizeId) => ({
                    id: sizeId,
                    label: fontSizeLabels[sizeId] || sizeId,
                    preview: sizeId.toUpperCase(),
                })),
                backgroundTypeOptions: [
                    { id: 'color', label: 'Renk' },
                    { id: 'gradient', label: 'Gradyan' },
                    { id: 'image', label: 'Görsel' },
                    { id: 'video', label: 'Video' },
                    { id: 'animation', label: 'Animasyon' },
                ],
                buttonVariantOptions: [
                    { id: 'solid', label: 'Dolu', icon: 'fas fa-square' },
                    { id: 'outline', label: 'Çizgili', icon: 'far fa-square' },
                    { id: 'glass', label: 'Cam', icon: 'fas fa-layer-group' },
                    { id: 'offset', label: 'Ofset', icon: 'fas fa-clone' },
                ],
                avatarSizeOptions: [
                    { id: 'sm', label: 'Küçük' },
                    { id: 'md', label: 'Orta' },
                    { id: 'lg', label: 'Büyük' },
                    { id: 'xl', label: 'Dev' },
                ],
                headerToggleOptions: [
                    { key: 'show_name', label: 'Profil ismini göster' },
                    { key: 'show_username', label: '@kullaniciadini göster' },
                    { key: 'show_bio', label: 'Biyografiyi göster' },
                ],
                animationOptions: [
                    { id: 'anim-1', label: 'Zigzag', class: 'bg-anim-1' },
                    { id: 'anim-2', label: 'Daireler', class: 'bg-anim-2' },
                    { id: 'anim-3', label: 'Çizgiler', class: 'bg-anim-3' },
                    { id: 'anim-4', label: 'Mesh', class: 'bg-anim-4' },
                    { id: 'anim-5', label: 'Oklar', class: 'bg-anim-5' },
                ],
                files: {
                    hero_image: null,
                    bg_image: null,
                    bg_video: null,
                },
                objectUrls: {
                    hero_image: null,
                    bg_image: null,
                    bg_video: null,
                },
                draftDesign: shared.normalizeDesign(initialSettings, runtimeDefaults),

                init() {
                    this.draftDesign = this.normalizeDesignSettings(initialSettings);
                    this.lastSavedSnapshot = this.serializeDesign(this.draftDesign);
                    this.previewSnapshot = this.lastSavedSnapshot;
                    this.isDirty = false;
                    this.loadTypographyFont();
                    this.shortcutHandler = (event) => {
                        const isSaveCombo = (event.ctrlKey || event.metaKey) && event.key.toLowerCase() === 's';
                        if (!isSaveCombo || this.tab !== 'design') return;
                        event.preventDefault();
                        this.saveDesign();
                    };

                    this.beforeUnloadHandler = (event) => {
                        if (!this.isDirty) return;
                        event.preventDefault();
                        event.returnValue = '';
                    };

                    window.addEventListener('beforeunload', this.beforeUnloadHandler);
                    window.addEventListener('keydown', this.shortcutHandler);
                    this.blocksEventHandler = () => {
                        const iframe = this.$refs.previewIframe;
                        if (!iframe) return;

                        this.previewReady = false;
                        iframe.src = `{{ route('public.profile', auth()->user()->username) }}?preview=${Date.now()}`;
                    };

                    window.addEventListener('blocks-updated', this.blocksEventHandler);
                    window.addEventListener('links-updated', this.blocksEventHandler);

                    this.$watch('draftDesign.typography.font_family', () => {
                        this.loadTypographyFont();
                    });

                    this.$watch('draftDesign', () => {
                        this.syncPreviewState(false);
                    });

                    this.$watch('tab', (nextTab) => {
                        if (nextTab === 'design') {
                            this.pushPreview(true);
                        }
                    });

                    this.$nextTick(() => {
                        this.previewEventTarget = this.$refs.designScrollArea || this.$root;
                        this.previewEventHandler = () => {
                            window.requestAnimationFrame(() => {
                                this.syncPreviewState(false);
                            });
                        };

                        if (this.previewEventTarget && this.previewEventHandler) {
                            this.previewEventTarget.addEventListener('input', this.previewEventHandler);
                            this.previewEventTarget.addEventListener('change', this.previewEventHandler);
                            this.previewEventTarget.addEventListener('click', this.previewEventHandler);
                        }

                        this.syncPreviewState(true, this.draftDesign);
                    });
                },

                destroy() {
                    clearTimeout(this.previewSyncTimer);
                    clearTimeout(this.feedbackTimer);
                    if (this.beforeUnloadHandler) {
                        window.removeEventListener('beforeunload', this.beforeUnloadHandler);
                    }
                    if (this.shortcutHandler) {
                        window.removeEventListener('keydown', this.shortcutHandler);
                    }
                    if (this.blocksEventHandler) {
                        window.removeEventListener('blocks-updated', this.blocksEventHandler);
                        window.removeEventListener('links-updated', this.blocksEventHandler);
                    }
                    if (this.previewEventTarget && this.previewEventHandler) {
                        this.previewEventTarget.removeEventListener('input', this.previewEventHandler);
                        this.previewEventTarget.removeEventListener('change', this.previewEventHandler);
                        this.previewEventTarget.removeEventListener('click', this.previewEventHandler);
                    }
                    this.clearAllObjectUrls();
                },

                handlePreviewLoad() {
                    this.previewReady = true;
                    this.flushPreviewPayload(true);
                },

                loadTypographyFont() {
                    shared.loadGoogleFont(this.draftDesign?.typography?.font_family);
                },

                selectThemePreset(presetId) {
                    this.draftDesign = shared.applyThemePreset(this.draftDesign, presetId, this.runtimeDefaults);
                    this.loadTypographyFont();
                    this.pushPreview(true);
                },

                handleHeaderLayoutChange(layout) {
                    this.draftDesign.header.layout = layout;
                    if (layout === 'hero-cover') {
                        this.draftDesign.header.avatar_size = 'md';
                    }
                },

                buildGradientPreview(background) {
                    return shared.buildGradient(background);
                },

                flashSaveFeedback(message, type = 'success') {
                    clearTimeout(this.feedbackTimer);
                    this.saveFeedback = { message, type };
                    this.feedbackTimer = setTimeout(() => {
                        this.saveFeedback = { message: '', type: 'success' };
                    }, 3200);
                },

                pushPreview(force = false, settings = null) {
                    clearTimeout(this.previewSyncTimer);
                    const payload = this.preparePayload(settings || this.draftDesign);
                    this.pendingPreviewPayload = payload;

                    if (!this.previewReady) {
                        return;
                    }

                    this.previewSyncTimer = setTimeout(() => {
                        this.flushPreviewPayload(force);
                    }, force ? 0 : 90);
                },

                flushPreviewPayload(force = false) {
                    clearTimeout(this.previewSyncTimer);

                    const iframe = this.$refs.previewIframe;
                    if (!iframe || !iframe.contentWindow || !this.pendingPreviewPayload) return;

                    // Serialize to plain object to avoid DataCloneError with Proxy/Alpine objects
                    let safePayload;
                    try {
                        safePayload = JSON.parse(JSON.stringify(this.pendingPreviewPayload));
                    } catch(e) {
                        console.warn('Preview payload serialization failed:', e);
                        return;
                    }

                    try {
                        if (typeof iframe.contentWindow.applyByooDesignPreview === 'function') {
                            iframe.contentWindow.applyByooDesignPreview(safePayload);
                        }
                    } catch (error) {
                        console.warn('Direct preview sync failed:', error);
                    }

                    try {
                        iframe.contentWindow.postMessage({
                            type: 'DESIGN_UPDATE',
                            payload: safePayload,
                        }, '*');
                    } catch(e) {
                        console.warn('postMessage failed:', e);
                    }

                    if (force) {
                        this.previewSyncTimer = null;
                    }
                },

                serializeDesign(settings) {
                    return JSON.stringify(this.preparePayload(settings));
                },

                normalizeDesignSettings(settings) {
                    return shared.normalizeDesign(settings, this.runtimeDefaults);
                },

                scrollToSection(id) {
                    const area = this.$refs.designScrollArea;
                    const el = document.getElementById(id);
                    if (!area || !el) return;

                    area.scrollTo({
                        top: Math.max(0, el.offsetTop - 24),
                        behavior: 'smooth',
                    });
                    this.activeDesignSection = id.replace('design-', '');
                },

                handleDesignScroll() {
                    const area = this.$refs.designScrollArea;
                    if (!area) return;

                    const sections = ['header', 'font', 'theme', 'background', 'colors', 'buttons'];
                    let closestSection = 'header';
                    let closestDistance = Number.POSITIVE_INFINITY;

                    sections.forEach((section) => {
                        const el = document.getElementById('design-' + section);
                        if (!el) return;

                        const distance = Math.abs((el.offsetTop - area.scrollTop) - 24);
                        if (distance < closestDistance) {
                            closestDistance = distance;
                            closestSection = section;
                        }
                    });

                    this.activeDesignSection = closestSection;
                },

                restoreLastSaved() {
                    if (!this.lastSavedSnapshot) return;

                    this.draftDesign = JSON.parse(this.lastSavedSnapshot);
                    this.isDirty = false;
                    this.resetTransientFiles();
                    this.pushPreview(true, this.draftDesign);
                    this.flashSaveFeedback('{{ __('Son yayınlanan sürüm geri yüklendi.') }}');
                },

                clearAllObjectUrls() {
                    Object.keys(this.objectUrls).forEach((key) => {
                        if (this.objectUrls[key]) {
                            URL.revokeObjectURL(this.objectUrls[key]);
                            this.objectUrls[key] = null;
                        }
                    });
                },

                setDraftValue(path, value) {
                    const keys = String(path).split('.');
                    let current = this.draftDesign;

                    for (let i = 0; i < keys.length - 1; i += 1) {
                        const key = keys[i];
                        if (!current[key] || typeof current[key] !== 'object') {
                            current[key] = {};
                        }
                        current = current[key];
                    }

                    current[keys[keys.length - 1]] = value;
                },

                clearDesignMedia(type, targetPath) {
                    if (this.objectUrls[type]) {
                        URL.revokeObjectURL(this.objectUrls[type]);
                        this.objectUrls[type] = null;
                    }

                    this.files[type] = null;
                    this.setDraftValue(targetPath, '');
                    this.pushPreview(true);
                },

                handleFileChange(event, type) {
                    const file = event?.target?.files?.[0];
                    if (!file) return;

                    if (type === 'bg_video' && file.size > (8 * 1024 * 1024)) {
                        this.flashSaveFeedback('{{ __('Video dosyası 8MB limitini aşıyor.') }}', 'error');
                        if (event?.target) {
                            event.target.value = '';
                        }
                        return;
                    }

                    this.files[type] = file;

                    if (this.objectUrls[type]) {
                        URL.revokeObjectURL(this.objectUrls[type]);
                        this.objectUrls[type] = null;
                    }

                    const previewUrl = URL.createObjectURL(file);
                    this.objectUrls[type] = previewUrl;

                    if (type === 'hero_image') {
                        this.draftDesign.header.hero_image_url = previewUrl;
                    }

                    if (type === 'bg_image') {
                        this.draftDesign.background.image_url = previewUrl;
                        this.draftDesign.background.active_type = 'image';
                    }

                    if (type === 'bg_video') {
                        this.draftDesign.background.video_url = previewUrl;
                        this.draftDesign.background.active_type = 'video';
                    }

                    if (event?.target) {
                        event.target.value = '';
                    }
                },

                preparePayload(settings) {
                    return JSON.parse(JSON.stringify(shared.normalizeDesign(
                        settings || this.draftDesign,
                        this.runtimeDefaults,
                    )));
                },

                updatePreview(settings) {
                    this.pushPreview(true, settings);
                },

                syncPreviewState(force = false, settings = null) {
                    const snapshot = this.serializeDesign(settings || this.draftDesign);
                    this.isDirty = snapshot !== this.lastSavedSnapshot;

                    if (!force && snapshot === this.previewSnapshot) {
                        return;
                    }

                    this.previewSnapshot = snapshot;
                    this.pushPreview(force, JSON.parse(snapshot));
                },

                getMediaTargetPath(type) {
                    return {
                        hero_image: 'header.hero_image_url',
                        bg_image: 'background.image_url',
                        bg_video: 'background.video_url',
                    }[type] || '';
                },

                setNestedValue(target, path, value) {
                    const keys = String(path).split('.');
                    let current = target;

                    for (let i = 0; i < keys.length - 1; i += 1) {
                        const key = keys[i];
                        if (!current[key] || typeof current[key] !== 'object') {
                            current[key] = {};
                        }
                        current = current[key];
                    }

                    current[keys[keys.length - 1]] = value;
                },

                applyUploadedMedia(payload, type, url) {
                    const nextPayload = JSON.parse(JSON.stringify(payload));
                    const targetPath = this.getMediaTargetPath(type);

                    if (!targetPath) {
                        return nextPayload;
                    }

                    this.setNestedValue(nextPayload, targetPath, url);

                    if (type === 'bg_image') {
                        nextPayload.background.active_type = 'image';
                    }

                    if (type === 'bg_video') {
                        nextPayload.background.active_type = 'video';
                    }

                    return nextPayload;
                },

                async parseApiResponse(response, tooLargeMessage) {
                    const contentType = response.headers.get('content-type') || '';
                    const rawText = await response.text();
                    let data = {};

                    if (response.status === 413) {
                        throw new Error(tooLargeMessage);
                    }

                    if (rawText && contentType.includes('application/json')) {
                        try {
                            data = JSON.parse(rawText);
                        } catch (parseError) {
                            if (!response.ok) {
                                throw new Error(`HTTP ${response.status}`);
                            }

                            throw new Error('{{ __('Sunucu geçersiz bir cevap döndürdü.') }}');
                        }
                    }

                    if (!response.ok || data.success === false) {
                        if (response.status === 422) {
                            throw new Error(data.message || '{{ __('Gönderilen tasarım verileri doğrulanamadı.') }}');
                        }

                        throw new Error(data.message || `HTTP ${response.status}`);
                    }

                    return data;
                },

                async uploadDesignMedia(type, file, baseHeaders) {
                    if (type === 'bg_video') {
                        return this.uploadVideoInChunks(file, baseHeaders);
                    }

                    const formData = new FormData();
                    formData.append('media_type', type);
                    formData.append('file', file);

                    const response = await fetch("{{ route('profile.design.media.upload') }}", {
                        method: 'POST',
                        headers: baseHeaders,
                        body: formData,
                        credentials: 'same-origin',
                    });

                    return this.parseApiResponse(
                        response,
                        '{{ __('Medya yükleme isteği sunucu limitini aşıyor. Sunucuda post_max_size veya upload_max_filesize değeri düşük olabilir.') }}',
                    );
                },

                buildUploadId() {
                    if (window.crypto?.randomUUID) {
                        return window.crypto.randomUUID();
                    }

                    return ['upload', Date.now(), Math.random().toString(36).slice(2)].join('-');
                },

                async uploadVideoChunk(uploadId, chunkIndex, totalChunks, chunk, fileName, baseHeaders) {
                    const formData = new FormData();
                    formData.append('media_type', 'bg_video');
                    formData.append('upload_id', uploadId);
                    formData.append('chunk_index', String(chunkIndex));
                    formData.append('total_chunks', String(totalChunks));
                    formData.append('original_name', fileName);
                    formData.append('chunk', chunk, `${fileName}.part${chunkIndex}`);

                    const response = await fetch("{{ route('profile.design.media.chunk') }}", {
                        method: 'POST',
                        headers: baseHeaders,
                        body: formData,
                        credentials: 'same-origin',
                    });

                    return this.parseApiResponse(
                        response,
                        '{{ __('Video parcasi sunucu limitini aşıyor. Sunucu proxy ayarlarını tekrar kontrol edin.') }}',
                    );
                },

                async finalizeVideoUpload(uploadId, totalChunks, fileName, baseHeaders) {
                    const response = await fetch("{{ route('profile.design.media.finalize') }}", {
                        method: 'POST',
                        headers: {
                            ...baseHeaders,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            media_type: 'bg_video',
                            upload_id: uploadId,
                            total_chunks: totalChunks,
                            original_name: fileName,
                        }),
                        credentials: 'same-origin',
                    });

                    return this.parseApiResponse(
                        response,
                        '{{ __('Video birlestirme istegi sunucu limitini aşıyor.') }}',
                    );
                },

                async uploadVideoInChunks(file, baseHeaders) {
                    const chunkSize = 512 * 1024;
                    const totalChunks = Math.max(1, Math.ceil(file.size / chunkSize));
                    const uploadId = this.buildUploadId();

                    for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex += 1) {
                        const start = chunkIndex * chunkSize;
                        const end = Math.min(file.size, start + chunkSize);
                        const chunk = file.slice(start, end, file.type || 'video/mp4');

                        await this.uploadVideoChunk(
                            uploadId,
                            chunkIndex,
                            totalChunks,
                            chunk,
                            file.name || 'background.mp4',
                            baseHeaders,
                        );
                    }

                    return this.finalizeVideoUpload(
                        uploadId,
                        totalChunks,
                        file.name || 'background.mp4',
                        baseHeaders,
                    );
                },

                async publishDesignPayload(payload, baseHeaders) {
                    const response = await fetch("{{ route('profile.design.update') }}", {
                        method: 'PATCH',
                        headers: {
                            ...baseHeaders,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ design_settings: payload }),
                        credentials: 'same-origin',
                    });

                    return this.parseApiResponse(
                        response,
                        '{{ __('Yayınlama isteği sunucu limitini aşıyor. Çok sayıda medya seçtiysen önce tek tek yükleyin.') }}',
                    );
                },

                async saveDesign() {
                    if (this.isSaving) return;

                    this.isSaving = true;
                    let payload = this.preparePayload(this.draftDesign);
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    const baseHeaders = {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    };

                    if (csrfToken) {
                        baseHeaders['X-CSRF-TOKEN'] = csrfToken;
                    }

                    try {
                        const pendingFiles = Object.entries(this.files).filter(([, file]) => file instanceof File);

                        for (const [type, file] of pendingFiles) {
                            const uploadResult = await this.uploadDesignMedia(type, file, baseHeaders);
                            payload = this.applyUploadedMedia(payload, type, uploadResult.url);
                        }

                        const data = await this.publishDesignPayload(payload, baseHeaders);
                        const savedDesign = this.normalizeDesignSettings(data.design_settings || payload);
                        this.draftDesign = savedDesign;
                        this.lastSavedSnapshot = this.serializeDesign(savedDesign);
                        this.isDirty = false;
                        this.resetTransientFiles();
                        this.pushPreview(true, savedDesign);

                        this.flashSaveFeedback('{{ __('Tasarım yayınlandı.') }}');
                    } catch (error) {
                        console.error('Design save error:', error);
                        this.flashSaveFeedback(error?.message || '{{ __('Yayınlama sırasında bir hata oluştu.') }}', 'error');
                    } finally {
                        this.isSaving = false;
                    }
                },

                resetTransientFiles() {
                    this.clearAllObjectUrls();
                    this.files = { hero_image: null, bg_image: null, bg_video: null };
                },
            };
        });
    });
</script>
@endpush
</x-app-layout>




