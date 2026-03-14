<div class="space-y-8 relative">
    <!-- Block overlay if preset theme is active -->
    <div x-show="!draftDesign.theme.custom_theme" x-transition class="absolute inset-0 z-10 bg-background/50 backdrop-blur-[1px] flex flex-col items-center justify-center rounded-lg border border-border">
        <i class="fas fa-lock text-xl text-muted-foreground mb-2"></i>
        <h4 class="text-sm font-medium">{{ __('Özel Tasarım Kapalı') }}</h4>
        <p class="text-[10px] text-muted-foreground text-center max-w-[200px] mt-1">{{ __('Buton ayarlarını değiştirmek için Tema sekmesinden Özel Tasarım moduna geçmelisiniz.') }}</p>
        <button type="button" @click="tab = 'theme'; draftDesign.theme.custom_theme = true;" class="mt-4 px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md shadow-sm hover:bg-primary/90 transition-colors">
            {{ __('Kilidi Aç') }}
        </button>
    </div>

    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Buton Stili') }}</h3>
        <p class="text-[10px] text-muted-foreground mt-1">{{ __('Profilinizdeki link kartlarının görünümünü ayarlayın.') }}</p>
    </div>

    <div class="space-y-6" :class="{ 'opacity-50 pointer-events-none': !draftDesign.theme.custom_theme }">
        
        <!-- Button Shape Mapping -->
        <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Köşe Yuvarlaklığı') }}</h4>
        <div class="grid grid-cols-3 gap-3">
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.buttons.style" value="square" class="sr-only peer">
                <div class="h-16 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex items-center justify-center bg-muted/20 hover:bg-muted/50 p-2">
                    <div class="w-full h-8 bg-foreground/20 rounded-none relative">
                        <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold opacity-30">Kare</div>
                    </div>
                </div>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.buttons.style" value="soft" class="sr-only peer">
                <div class="h-16 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex items-center justify-center bg-muted/20 hover:bg-muted/50 p-2">
                    <div class="w-full h-8 bg-foreground/20 rounded-lg relative">
                        <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold opacity-30">Yumuşak</div>
                    </div>
                </div>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.buttons.style" value="pill" class="sr-only peer">
                <div class="h-16 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex items-center justify-center bg-muted/20 hover:bg-muted/50 p-2">
                    <div class="w-full h-8 bg-foreground/20 rounded-full relative">
                        <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold opacity-30">Hap</div>
                    </div>
                </div>
            </label>
        </div>

        <hr class="border-border">

        <!-- Button Colors -->
        <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Buton Renkleri') }}</h4>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-[10px] text-muted-foreground w-full block">Arka Plan Rengi</label>
                <div class="flex items-center gap-2">
                    <input type="color" x-model="draftDesign.buttons.bg_color" class="h-8 w-10 rounded cursor-pointer border-0 p-0">
                    <input type="text" x-model="draftDesign.buttons.bg_color" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono" placeholder="#ffffff">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="text-[10px] text-muted-foreground w-full block">Metin Rengi</label>
                <div class="flex items-center gap-2">
                    <input type="color" x-model="draftDesign.buttons.text_color" class="h-8 w-10 rounded cursor-pointer border-0 p-0">
                    <input type="text" x-model="draftDesign.buttons.text_color" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono" placeholder="#111827">
                </div>
            </div>
        </div>

        <hr class="border-border">

        <!-- Button Shadow -->
        <div class="flex items-center justify-between">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Buton Gölgesi') }}</h4>
                <p class="text-[10px] text-muted-foreground mt-1">Butonların çevresinde hafif bir kaldırılma efekti (shadow) oluşturur.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" x-model="draftDesign.buttons.shadow" class="sr-only peer">
                <div class="w-9 h-5 bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
            </label>
        </div>

    </div>
</div>
