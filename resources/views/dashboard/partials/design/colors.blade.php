<div class="space-y-8 relative">
    <!-- Block overlay if preset theme is active -->
    <div x-show="!draftDesign.theme.custom_theme" x-transition class="absolute inset-0 z-10 bg-background/50 backdrop-blur-[1px] flex flex-col items-center justify-center rounded-lg border border-border">
        <i class="fas fa-lock text-xl text-muted-foreground mb-2"></i>
        <h4 class="text-sm font-medium">{{ __('Özel Tasarım Kapalı') }}</h4>
        <p class="text-[10px] text-muted-foreground text-center max-w-[200px] mt-1">{{ __('Renk ayarlarını değiştirmek için Tema sekmesinden Özel Tasarım moduna geçmelisiniz.') }}</p>
        <button type="button" @click="tab = 'theme'; draftDesign.theme.custom_theme = true;" class="mt-4 px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md shadow-sm hover:bg-primary/90 transition-colors">
            {{ __('Kilidi Aç') }}
        </button>
    </div>

    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Genel Renkler') }}</h3>
        <p class="text-[10px] text-muted-foreground mt-1">{{ __('Sayfanızdaki varsayılan metin rengi ve diğer palet ayarları.') }}</p>
    </div>

    <div class="space-y-6" :class="{ 'opacity-50 pointer-events-none': !draftDesign.theme.custom_theme }">
        
        <div class="space-y-4">
            <div class="space-y-2">
                <label class="text-[10px] font-semibold uppercase tracking-wider text-muted-foreground w-full block">Metin Rengi</label>
                <p class="text-[9px] text-muted-foreground -mt-1 mb-2">Başlıklar, bio yazısı gibi temel metinlerin rengi.</p>
                <div class="flex items-center gap-2">
                    <input type="color" x-model="draftDesign.colors.text" class="h-8 w-10 rounded cursor-pointer border-0 p-0">
                    <input type="text" x-model="draftDesign.colors.text" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono" placeholder="#111827">
                </div>
            </div>
            
            <hr class="border-border">

            <div class="space-y-2 opacity-50 relative">
                <div class="absolute inset-0 z-10" title="Yakında Eklenecek"></div>
                <label class="text-[10px] font-semibold uppercase tracking-wider text-muted-foreground w-full flex justify-between">
                    <span>Vurgu Rengi (Accent)</span>
                    <span class="text-[9px] bg-muted px-1.5 py-0.5 rounded">Pek Yakında</span>
                </label>
                <p class="text-[9px] text-muted-foreground -mt-1 mb-2">Sosyal medya ikonları veya bazı küçük vurgularda kullanılacak renk.</p>
                <div class="flex items-center gap-2">
                    <input type="color" value="#6366f1" disabled class="h-8 w-10 rounded cursor-pointer border-0 p-0 opacity-50">
                    <input type="text" disabled value="#6366f1" class="flex-1 w-full text-xs rounded-md border-input bg-muted font-mono opacity-50">
                </div>
            </div>
        </div>

    </div>
</div>
