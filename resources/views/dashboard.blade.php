<x-app-layout>
    @php 
        $initialSettings = auth()->user()->profile?->design_settings ?? []; 
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
                                        <button @click="scrollToSection('design-buttons')" 
                                                class="flex flex-col items-center justify-center p-2 rounded-lg transition-all min-w-[70px] hover:bg-muted"
                                                :class="activeDesignSection === 'buttons' ? 'bg-primary/10 text-primary' : 'text-muted-foreground'">
                                            <i class="fas fa-hand-pointer text-xs mb-1"></i>
                                            <span class="text-[10px] font-semibold">{{ __('Butonlar') }}</span>
                                        </button>
                                        <button @click="scrollToSection('design-colors')" 
                                                class="flex flex-col items-center justify-center p-2 rounded-lg transition-all min-w-[70px] hover:bg-muted"
                                                :class="activeDesignSection === 'colors' ? 'bg-primary/10 text-primary' : 'text-muted-foreground'">
                                            <i class="fas fa-palette text-xs mb-1"></i>
                                            <span class="text-[10px] font-semibold">{{ __('Renkler') }}</span>
                                        </button>
                                    </div>
                                    <button @click="saveDesign" :disabled="isSaving" :class="isSaving ? 'opacity-60 cursor-not-allowed' : 'hover:opacity-90'" class="inline-flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg text-sm font-bold shadow-lg transition-all">
                                        <i class="fas fa-save text-xs"></i>
                                        <span x-text="isSaving ? '{{ __('Kaydediliyor...') }}' : '{{ __('Kaydet') }}'"></span>
                                    </button>
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
                                    <div id="design-buttons" class="mb-12 scroll-mt-20">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-hand-pointer"></i> Butonlar
                                        </h3>
                                        @include('dashboard.partials.design.buttons')
                                    </div>
                                    <hr class="border-border/50 my-10">
                                    <div id="design-colors" class="mb-12 scroll-mt-20">
                                        <h3 class="text-xs font-bold text-muted-foreground uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <i class="fas fa-palette"></i> Renkler
                                        </h3>
                                        @include('dashboard.partials.design.colors')
                                    </div>
                                </div>

                                <!-- Action Bar (Hidden in single page as it is now in the nav bar) -->
                                <div class="border-t border-border bg-muted/10 p-2 flex items-center justify-center">
                                    <p class="text-[9px] text-muted-foreground uppercase tracking-wider opacity-60">{{ __('Tasarım ayarlarınız canlı önizleme ile senkronize edilir') }}</p>
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
                            <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest opacity-40">{{ __('Görünüm anlık olarak güncellenir') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardManager', (initialTab, initialSettings) => ({
                tab: initialTab,
                activeDesignSection: 'header',
                sidebarOpen: window.innerWidth >= 768,
                previewOpen: window.innerWidth >= 1280,
                previewSyncTimer: null,
                beforeUnloadHandler: null,
                isSaving: false,
                isDirty: false,
                lastSavedSnapshot: '',
                
                // Track files for upload
                files: {
                    hero_image: null,
                    bg_image: null,
                    bg_video: null
                },
                objectUrls: {
                    hero_image: null,
                    bg_image: null,
                    bg_video: null,
                },

                // Design Draft State
                draftDesign: {
                    profile: {
                        name: {!! json_encode(auth()->user()->name) !!},
                        username: {!! json_encode(auth()->user()->username) !!},
                        bio: {!! json_encode(auth()->user()->profile?->bio ?? '') !!},
                    },
                    header: {
                        layout: initialSettings?.header?.layout || 'centered-classic',
                        hero_image_url: initialSettings?.header?.hero_image_url || '',
                        avatar_size: initialSettings?.header?.avatar_size || 'md',
                        avatar_frame: initialSettings?.header?.avatar_frame || 'circle',
                        show_name: initialSettings?.header?.show_name ?? true,
                        show_username: initialSettings?.header?.show_username ?? true,
                        show_bio: initialSettings?.header?.show_bio ?? true,
                    },
                    theme: {
                        preset: initialSettings?.theme?.preset || 'minimal',
                        custom_theme: initialSettings?.theme?.custom_theme || false,
                        font_family: initialSettings?.theme?.font_family || 'inter',
                    },
                    background: {
                        type: initialSettings?.background?.type || 'color',
                        color: initialSettings?.background?.color || '#f9fafb',
                        gradient: initialSettings?.background?.gradient || 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                        image_url: initialSettings?.background?.image_url || '',
                        video_url: initialSettings?.background?.video_url || '',
                        animation: initialSettings?.background?.animation || 'none',
                        animation_speed: initialSettings?.background?.animation_speed || 10,
                        animation_colors: initialSettings?.background?.animation_colors || ['#6366f1', '#a855f7'],
                        overlay: initialSettings?.background?.overlay || 0,
                        blur: initialSettings?.background?.blur || 0,
                    },
                    buttons: {
                        style: initialSettings?.buttons?.style || 'pill',
                        variant: initialSettings?.buttons?.variant || 'solid', 
                        align: initialSettings?.buttons?.align || 'center',
                        shadow: initialSettings?.buttons?.shadow ?? true,
                        bg_color: initialSettings?.buttons?.bg_color || '#ffffff',
                        text_color: initialSettings?.buttons?.text_color || '#111827',
                    },
                    colors: {
                        text: initialSettings?.colors?.text || '#111827',
                        title: initialSettings?.colors?.title || '#111827',
                        page_text: initialSettings?.colors?.page_text || '#111827',
                        btn_bg: initialSettings?.colors?.btn_bg || '#ffffff',
                        btn_text: initialSettings?.colors?.btn_text || '#111827',
                    }
                },
                
                init() {
                    this.draftDesign = this.normalizeDesignSettings(initialSettings);
                    this.lastSavedSnapshot = this.serializeDesign(this.draftDesign);
                    this.isDirty = false;

                    this.beforeUnloadHandler = (event) => {
                        if (!this.isDirty) return;
                        event.preventDefault();
                        event.returnValue = '';
                    };
                    window.addEventListener('beforeunload', this.beforeUnloadHandler);

                    this.$watch('draftDesign', () => {
                        this.isDirty = this.serializeDesign(this.draftDesign) !== this.lastSavedSnapshot;
                        this.pushPreview(false);
                    }, { deep: true });

                    this.$watch('tab', (nextTab) => {
                        if (nextTab === 'design') {
                            this.pushPreview(true);
                        }
                    });

                    this.$nextTick(() => {
                        this.pushPreview(true);
                    });
                },

                destroy() {
                    clearTimeout(this.previewSyncTimer);
                    if (this.beforeUnloadHandler) {
                        window.removeEventListener('beforeunload', this.beforeUnloadHandler);
                    }
                    this.clearAllObjectUrls();
                },

                handlePreviewLoad() {
                    this.pushPreview(true);
                },

                pushPreview(force = false, settings = null) {
                    clearTimeout(this.previewSyncTimer);
                    const payload = this.preparePayload(settings || this.draftDesign);
                    this.previewSyncTimer = setTimeout(() => {
                        const iframe = this.$refs.previewIframe;
                        if (!iframe || !iframe.contentWindow) return;

                        iframe.contentWindow.postMessage({
                            type: 'DESIGN_UPDATE',
                            payload,
                        }, '*');
                    }, force ? 0 : 90);
                },

                serializeDesign(settings) {
                    return JSON.stringify(this.preparePayload(settings));
                },

                normalizeDesignSettings(settings) {
                    const defaults = {
                        profile: {
                            name: {!! json_encode(auth()->user()->name) !!},
                            username: {!! json_encode(auth()->user()->username) !!},
                            bio: {!! json_encode(auth()->user()->profile?->bio ?? '') !!},
                        },
                        header: {
                            layout: 'centered-classic',
                            hero_image_url: '',
                            avatar_size: 'md',
                            avatar_frame: 'circle',
                            show_name: true,
                            show_username: true,
                            show_bio: true,
                        },
                        theme: {
                            preset: 'minimal',
                            custom_theme: false,
                            font_family: 'inter',
                        },
                        background: {
                            type: 'color',
                            color: '#f9fafb',
                            gradient: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            image_url: '',
                            video_url: '',
                            animation: 'none',
                            animation_speed: 10,
                            animation_colors: ['#6366f1', '#a855f7'],
                            overlay: 0,
                            blur: 0,
                        },
                        buttons: {
                            style: 'pill',
                            variant: 'solid',
                            align: 'center',
                            shadow: true,
                            bg_color: '#ffffff',
                            text_color: '#111827',
                        },
                        colors: {
                            text: '#111827',
                            title: '#111827',
                            page_text: '#111827',
                            btn_bg: '#ffffff',
                            btn_text: '#111827',
                        },
                    };

                    const safe = settings && typeof settings === 'object' ? settings : {};
                    const normalized = {
                        ...defaults,
                        ...safe,
                        profile: { ...defaults.profile, ...(safe.profile || {}) },
                        header: { ...defaults.header, ...(safe.header || {}) },
                        theme: { ...defaults.theme, ...(safe.theme || {}) },
                        background: { ...defaults.background, ...(safe.background || {}) },
                        buttons: { ...defaults.buttons, ...(safe.buttons || {}) },
                        colors: { ...defaults.colors, ...(safe.colors || {}) },
                    };

                    if (!Array.isArray(normalized.background.animation_colors) || normalized.background.animation_colors.length < 2) {
                        normalized.background.animation_colors = [...defaults.background.animation_colors];
                    }

                    const allowedLayouts = ['centered-classic', 'left-aligned', 'hero-cover'];
                    const allowedPresets = ['minimal', 'dark', 'neon', 'glass', 'midnight', 'sunset', 'aurora', 'forest', 'cyber', 'obsidian'];
                    const allowedFonts = ['inter', 'outfit', 'roboto', 'montserrat', 'playfair', 'mono'];
                    const allowedBgTypes = ['color', 'gradient', 'image', 'video', 'animation'];
                    const allowedAnimations = ['anim-1', 'anim-2', 'anim-3', 'anim-4', 'anim-5'];
                    const allowedButtonStyles = ['pill', 'soft', 'square'];
                    const allowedButtonVariants = ['solid', 'outline', 'glass', 'offset'];
                    const allowedButtonAligns = ['left', 'center', 'right'];

                    if (!allowedLayouts.includes(normalized.header.layout)) normalized.header.layout = defaults.header.layout;
                    if (!allowedPresets.includes(normalized.theme.preset)) normalized.theme.preset = defaults.theme.preset;
                    if (!allowedFonts.includes(normalized.theme.font_family)) normalized.theme.font_family = defaults.theme.font_family;
                    if (!allowedBgTypes.includes(normalized.background.type)) normalized.background.type = defaults.background.type;
                    if (!allowedAnimations.includes(normalized.background.animation)) normalized.background.animation = 'anim-1';
                    if (!allowedButtonStyles.includes(normalized.buttons.style)) normalized.buttons.style = defaults.buttons.style;
                    if (!allowedButtonVariants.includes(normalized.buttons.variant)) normalized.buttons.variant = defaults.buttons.variant;
                    if (!allowedButtonAligns.includes(normalized.buttons.align)) normalized.buttons.align = defaults.buttons.align;

                    normalized.profile.username = defaults.profile.username;
                    normalized.theme.custom_theme = !!normalized.theme.custom_theme;
                    normalized.header.show_name = !!normalized.header.show_name;
                    normalized.header.show_username = !!normalized.header.show_username;
                    normalized.header.show_bio = !!normalized.header.show_bio;
                    normalized.buttons.shadow = !!normalized.buttons.shadow;

                    normalized.profile.name = String(normalized.profile.name ?? defaults.profile.name);
                    normalized.profile.bio = String(normalized.profile.bio ?? defaults.profile.bio);
                    normalized.background.gradient = String(normalized.background.gradient || defaults.background.gradient);
                    normalized.background.image_url = String(normalized.background.image_url || '');
                    normalized.background.video_url = String(normalized.background.video_url || '');
                    normalized.header.hero_image_url = String(normalized.header.hero_image_url || '');

                    const overlay = Number(normalized.background.overlay);
                    const blur = Number(normalized.background.blur);
                    normalized.background.overlay = Number.isFinite(overlay) ? Math.max(0, Math.min(100, overlay)) : defaults.background.overlay;
                    normalized.background.blur = Number.isFinite(blur) ? Math.max(0, Math.min(50, blur)) : defaults.background.blur;

                    normalized.background.color = this.sanitizeHexColor(normalized.background.color, defaults.background.color);
                    normalized.buttons.bg_color = this.sanitizeHexColor(normalized.buttons.bg_color ?? normalized.colors.btn_bg, defaults.buttons.bg_color);
                    normalized.buttons.text_color = this.sanitizeHexColor(normalized.buttons.text_color ?? normalized.colors.btn_text, defaults.buttons.text_color);
                    normalized.colors.text = this.sanitizeHexColor(normalized.colors.text, defaults.colors.text);
                    normalized.colors.title = this.sanitizeHexColor(normalized.colors.title, defaults.colors.title);
                    normalized.colors.page_text = this.sanitizeHexColor(normalized.colors.page_text, defaults.colors.page_text);
                    normalized.colors.btn_bg = normalized.buttons.bg_color;
                    normalized.colors.btn_text = normalized.buttons.text_color;
                    normalized.background.animation_colors = normalized.background.animation_colors.slice(0, 2).map((color, index) => {
                        return this.sanitizeHexColor(color, defaults.background.animation_colors[index] || defaults.background.animation_colors[0]);
                    });

                    return normalized;
                },

                scrollToSection(id) {
                    const el = document.getElementById(id);
                    if (!el) return;

                    el.scrollIntoView({ behavior: 'smooth' });
                    this.activeDesignSection = id.replace('design-', '');
                },

                handleDesignScroll() {
                    const area = this.$refs.designScrollArea;
                    if (!area) return;

                    const sections = ['header', 'theme', 'background', 'buttons', 'colors'];
                    for (const section of sections) {
                        const el = document.getElementById('design-' + section);
                        if (!el) continue;

                        const rect = el.getBoundingClientRect();
                        const areaRect = area.getBoundingClientRect();
                        if (rect.top >= areaRect.top && rect.top <= areaRect.top + 100) {
                            this.activeDesignSection = section;
                            break;
                        }
                    }
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
                        this.draftDesign.background.type = 'image';
                    }
                    if (type === 'bg_video') {
                        this.draftDesign.background.video_url = previewUrl;
                        this.draftDesign.background.type = 'video';
                    }

                    if (event?.target) {
                        event.target.value = '';
                    }
                },

                sanitizeHexColor(value, fallback) {
                    if (typeof value !== 'string') return fallback;
                    const raw = value.trim();

                    if (/^#[0-9a-fA-F]{6}$/.test(raw)) return raw;
                    if (/^#[0-9a-fA-F]{3}$/.test(raw)) {
                        return '#' + raw.slice(1).split('').map((part) => part + part).join('');
                    }

                    return fallback;
                },

                sanitizeAllColors(design) {
                    design.background.color = this.sanitizeHexColor(design.background.color, '#f9fafb');
                    design.buttons.bg_color = this.sanitizeHexColor(design.buttons.bg_color, '#ffffff');
                    design.buttons.text_color = this.sanitizeHexColor(design.buttons.text_color, '#111827');
                    design.colors.text = this.sanitizeHexColor(design.colors.text, '#111827');
                    design.colors.title = this.sanitizeHexColor(design.colors.title, '#111827');
                    design.colors.page_text = this.sanitizeHexColor(design.colors.page_text, '#111827');
                    design.colors.btn_bg = design.buttons.bg_color;
                    design.colors.btn_text = design.buttons.text_color;
                    design.background.animation_colors = design.background.animation_colors.map((color, index) => {
                        const fallback = index === 0 ? '#6366f1' : '#a855f7';
                        return this.sanitizeHexColor(color, fallback);
                    });
                },

                preparePayload(settings) {
                    const payload = this.normalizeDesignSettings(settings || this.draftDesign);
                    this.sanitizeAllColors(payload);
                    return JSON.parse(JSON.stringify(payload));
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
                        'Accept': 'application/json',
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

                        const rawText = await response.text();
                        let data = {};

                        if (rawText) {
                            try {
                                data = JSON.parse(rawText);
                            } catch (parseError) {
                                throw new Error('Sunucu geçersiz bir cevap döndürdü.');
                            }
                        }

                        if (!response.ok || data.success === false) {
                            throw new Error(data.message || `HTTP ${response.status}`);
                        }

                        const savedDesign = this.normalizeDesignSettings(data.design_settings || payload);
                        this.draftDesign = savedDesign;
                        this.lastSavedSnapshot = this.serializeDesign(savedDesign);
                        this.isDirty = false;
                        this.resetTransientFiles();
                        this.pushPreview(true, savedDesign);

                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: 'Tasarım kaydedildi!',
                        }));
                    } catch (error) {
                        console.error('Design save error:', error);
                        window.dispatchEvent(new CustomEvent('notify', {
                            detail: error?.message || 'Kaydetme sırasında bir hata oluştu!',
                            type: 'error',
                        }));
                    } finally {
                        this.isSaving = false;
                    }
                },

                resetTransientFiles() {
                    this.clearAllObjectUrls();
                    this.files = { hero_image: null, bg_image: null, bg_video: null };
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
