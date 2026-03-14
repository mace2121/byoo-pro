<div class="space-y-8 relative">
    <!-- Block overlay if preset theme is active -->
    <div x-show="!draftDesign.theme.custom_theme" x-transition class="absolute inset-0 z-10 bg-background/50 backdrop-blur-[1px] flex flex-col items-center justify-center rounded-lg border border-border">
        <i class="fas fa-lock text-xl text-muted-foreground mb-2"></i>
        <h4 class="text-sm font-medium">{{ __('Özel Tasarım Kapalı') }}</h4>
        <p class="text-[10px] text-muted-foreground text-center max-w-[200px] mt-1">{{ __('Renk ayarlarını değiştirmek için Tema sekmesinden Özel Tasarım moduna geçmelisiniz.') }}</p>
        <button type="button" @click="designTab = 'theme'; draftDesign.theme.custom_theme = true;" class="mt-4 px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md shadow-sm hover:bg-primary/90 transition-colors">
            {{ __('Kilidi Aç') }}
        </button>
    </div>

    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Gelişmiş Renkler') }}</h3>
        <p class="text-[10px] text-muted-foreground mt-1">{{ __('Sayfanızdaki her öğe için detaylı renk ayarları.') }}</p>
    </div>

    <div class="space-y-6" :class="{ 'opacity-50 pointer-events-none': !draftDesign.theme.custom_theme }">
        
        <div class="space-y-6">
            <!-- Profil Bilgileri Renkleri -->
            <div class="space-y-3">
                <h4 class="text-[10px] font-bold uppercase tracking-widest text-primary/70">{{ __('Profil Metinleri') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-medium text-muted-foreground">{{ __('Ana Başlık (İsim)') }}</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="draftDesign.colors.title" class="h-8 w-10 rounded cursor-pointer border-0 p-0 shadow-sm">
                            <input type="text" x-model="draftDesign.colors.title" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono" placeholder="#111827">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-medium text-muted-foreground">{{ __('Sayfa Metni (Biyografi)') }}</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="draftDesign.colors.page_text" class="h-8 w-10 rounded cursor-pointer border-0 p-0 shadow-sm">
                            <input type="text" x-model="draftDesign.colors.page_text" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono" placeholder="#111827">
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-border">

            <!-- Buton Renkleri (Gelişmiş) -->
            <div class="space-y-3">
                <h4 class="text-[10px] font-bold uppercase tracking-widest text-primary/70">{{ __('Buton Özelleştirme') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-medium text-muted-foreground">{{ __('Buton Arka Planı') }}</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="draftDesign.buttons.bg_color" class="h-8 w-10 rounded cursor-pointer border-0 p-0 shadow-sm">
                            <input type="text" x-model="draftDesign.buttons.bg_color" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono" placeholder="#ffffff">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-medium text-muted-foreground">{{ __('Buton Metni') }}</label>
                        <div class="flex items-center gap-2">
                            <input type="color" x-model="draftDesign.buttons.text_color" class="h-8 w-10 rounded cursor-pointer border-0 p-0 shadow-sm">
                            <input type="text" x-model="draftDesign.buttons.text_color" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono" placeholder="#111827">
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-border opacity-50">

            <!-- Diğer Renkler -->
            <div class="space-y-2 opacity-50 relative">
                <div class="absolute inset-0 z-10" title="Yakında Eklenecek"></div>
                <label class="text-[10px] font-semibold uppercase tracking-wider text-muted-foreground w-full flex justify-between">
                    <span>Vurgu Rengi (Accent)</span>
                    <span class="text-[9px] bg-muted px-1.5 py-0.5 rounded">Pek Yakında</span>
                </label>
                <div class="flex items-center gap-2">
                    <input type="color" value="#6366f1" disabled class="h-8 w-10 rounded cursor-pointer border-0 p-0 opacity-50">
                    <input type="text" disabled value="#6366f1" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono opacity-50">
                </div>
            </div>
        </div>

    </div>
</div>
