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
            <div :style="'display: grid; height: calc(100% - 56px); overflow: hidden; grid-template-columns: ' + (previewOpen ? '1fr 340px' : '1fr 0px')">
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
                                    <div id="design-header" class="mb-12 scroll-mt-20">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-id-card"></i> Header
                                        </h3>
                                        @include('dashboard.partials.design.header')
                                    </div>
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
                        <header class="mb-4 flex items-center justify-between flex-shrink-0 border-b border-border/50 pb-2">
                            <h3 class="text-[10px] font-bold text-muted-foreground uppercase tracking-[0.2em]">{{ __('Canlı Önizleme') }}</h3>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('public.profile', auth()->user()->username) }}" target="_blank" class="text-[10px] text-muted-foreground hover:text-foreground transition-colors p-1 rounded-md hover:bg-accent">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                                <button @click="previewOpen = false" class="p-1 rounded-md hover:bg-accent text-muted-foreground hover:text-foreground transition-colors">
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

                    this.$watch('draftDesign.typography.font_family', () => {
                        this.loadTypographyFont();
                    });

                    this.$watch('tab', (nextTab) => {
                        if (nextTab === 'design') {
                            this.pushPreview(true);
                        }
                    });

                    Alpine.effect(() => {
                        const snapshot = this.serializeDesign(this.draftDesign);
                        this.isDirty = snapshot !== this.lastSavedSnapshot;

                        if (snapshot === this.previewSnapshot) {
                            return;
                        }

                        this.previewSnapshot = snapshot;
                        this.pushPreview(false, JSON.parse(snapshot));
                    });

                    this.$nextTick(() => {
                        this.pushPreview(true, this.draftDesign);
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

                    iframe.contentWindow.postMessage({
                        type: 'DESIGN_UPDATE',
                        payload: this.pendingPreviewPayload,
                    }, '*');

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

                async saveDesign() {
                    if (this.isSaving) return;

                    this.isSaving = true;
                    const payload = this.preparePayload(this.draftDesign);
                    const hasFileUpload = Object.values(this.files).some((file) => file instanceof File);
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    const baseHeaders = {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    };

                    if (csrfToken) {
                        baseHeaders['X-CSRF-TOKEN'] = csrfToken;
                    }

                    try {
                        let response;

                        if (hasFileUpload) {
                            const formData = new FormData();
                            formData.append('_method', 'PATCH');
                            formData.append('design_settings', JSON.stringify(payload));

                            if (this.files.hero_image) formData.append('hero_image', this.files.hero_image);
                            if (this.files.bg_image) formData.append('bg_image', this.files.bg_image);
                            if (this.files.bg_video) formData.append('bg_video', this.files.bg_video);

                            response = await fetch("{{ route('profile.design.update') }}", {
                                method: 'POST',
                                headers: baseHeaders,
                                body: formData,
                                credentials: 'same-origin',
                            });
                        } else {
                            response = await fetch("{{ route('profile.design.update') }}", {
                                method: 'PATCH',
                                headers: {
                                    ...baseHeaders,
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify({ design_settings: payload }),
                                credentials: 'same-origin',
                            });
                        }

                        const contentType = response.headers.get('content-type') || '';
                        const rawText = await response.text();
                        let data = {};

                        if (response.status === 413) {
                            throw new Error('{{ __('Video dosyası 8MB limitini aşıyor veya sunucu yükleme limiti düşük.') }}');
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




