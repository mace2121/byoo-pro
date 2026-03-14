<x-app-layout>
    @php 
        $initialSettings = auth()->user()->profile?->design_settings ?? []; 
    @endphp
    <div class="h-full flex" x-data="dashboardManager('{{ request()->query('tab', 'links') }}', {{ json_encode($initialSettings) }})">
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
                                    <button @click="saveDesign" class="inline-flex items-center gap-2 bg-primary text-primary-foreground px-4 py-2 rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-all">
                                        <i class="fas fa-save text-xs"></i>
                                        {{ __('Kaydet') }}
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
                                        @load="updatePreview(draftDesign)"
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
                designTab: 'header',
                activeDesignSection: 'header',
                sidebarOpen: window.innerWidth >= 768,
                previewOpen: window.innerWidth >= 1280,
                
                // Track files for upload
                files: {
                    hero_image: null,
                    bg_image: null,
                    bg_video: null
                },

                // Design Draft State
                draftDesign: {
                    profile: {
                        name: {!! json_encode(auth()->user()->name) !!},
                        bio: {!! json_encode(auth()->user()->profile->bio ?? '') !!},
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
                    // Watch for changes to update preview immediately
                    this.$watch('draftDesign', value => {
                        this.updatePreview(value);
                    }, { deep: true });
                },

                scrollToSection(id) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth' });
                        this.activeDesignSection = id.replace('design-', '');
                    }
                },

                handleDesignScroll() {
                    const sections = ['header', 'theme', 'background', 'buttons', 'colors'];
                    const area = this.$refs.designScrollArea;
                    for (const section of sections) {
                        const el = document.getElementById('design-' + section);
                        if (el) {
                            const rect = el.getBoundingClientRect();
                            const areaRect = area.getBoundingClientRect();
                            if (rect.top >= areaRect.top && rect.top <= areaRect.top + 100) {
                                this.activeDesignSection = section;
                                break;
                            }
                        }
                    }
                },

                handleFileChange(event, type) {
                    const file = event.target.files[0];
                    if (file) {
                        this.files[type] = file;
                        
                        // Local preview for the iframe
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            if (type === 'hero_image') this.draftDesign.header.hero_image_url = e.target.result;
                            if (type === 'bg_image') this.draftDesign.background.image_url = e.target.result;
                            if (type === 'bg_video') this.draftDesign.background.video_url = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                updatePreview(settings) {
                    // Optimized update via postMessage
                    const iframe = this.$refs.previewIframe;
                    if (iframe && iframe.contentWindow) {
                        iframe.contentWindow.postMessage({
                            type: 'DESIGN_UPDATE',
                            payload: JSON.parse(JSON.stringify(settings)) // Ensure clean object
                        }, '*');
                    }
                },

                saveDesign() {
                    const formData = new FormData();
                    formData.append('_method', 'PATCH');
                    formData.append('design_settings', JSON.stringify(this.draftDesign));
                    
                    if (this.files.hero_image) formData.append('hero_image', this.files.hero_image);
                    if (this.files.bg_image) formData.append('bg_image', this.files.bg_image);
                    if (this.files.bg_video) formData.append('bg_video', this.files.bg_video);

                    fetch("{{ route('profile.design.update') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.design_settings) {
                                this.draftDesign = data.design_settings;
                                this.files = { hero_image: null, bg_image: null, bg_video: null };
                            }
                            window.dispatchEvent(new CustomEvent('notify', { detail: 'Tasarım kaydedildi!' }));
                        }
                    })
                    .catch(error => {
                        console.error('Save error:', error);
                        window.dispatchEvent(new CustomEvent('notify', { detail: 'Kaydedilirken hata oluştu!', type: 'error' }));
                    });
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
