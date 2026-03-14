<div class="space-y-8 relative">
    <!-- Block overlay if preset theme is active -->
    <div x-show="!draftDesign.theme.custom_theme" x-transition class="absolute inset-0 z-10 bg-background/50 backdrop-blur-[1px] flex flex-col items-center justify-center rounded-lg border border-border">
        <i class="fas fa-lock text-xl text-muted-foreground mb-2"></i>
        <h4 class="text-sm font-medium">{{ __('Özel Tasarım Kapalı') }}</h4>
        <p class="text-[10px] text-muted-foreground text-center max-w-[200px] mt-1">{{ __('Buton ayarlarını değiştirmek için Tema sekmesinden Özel Tasarım moduna geçmelisiniz.') }}</p>
        <button type="button" @click="designTab = 'theme'; draftDesign.theme.custom_theme = true;" class="mt-4 px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md shadow-sm hover:bg-primary/90 transition-colors">
            {{ __('Kilidi Aç') }}
        </button>
    </div>

    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Buton Stili') }}</h3>
        <p class="text-[10px] text-muted-foreground mt-1">{{ __('Profilinizdeki link kartlarının görünümünü ayarlayın.') }}</p>
    </div>

    <div class="space-y-6" :class="{ 'opacity-50 pointer-events-none': !draftDesign.theme.custom_theme }">
        
        <!-- Button Variants (NEW) -->
        <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Görünüm Varyantı') }}</h4>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <template x-for="v in [
                {id:'solid', label:'Solid', icon:'fas fa-square'},
                {id:'outline', label:'Outline', icon:'far fa-square'},
                {id:'glass', label:'Glass', icon:'fas fa-square-full opacity-30'},
                {id:'offset', label:'Offset', icon:'fas fa-folder'}
            ]">
                <label class="cursor-pointer group">
                    <input type="radio" x-model="draftDesign.buttons.variant" :value="v.id" class="sr-only peer">
                    <div class="h-14 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-1 bg-muted/20 hover:bg-muted/50 p-2 transition-all">
                        <i :class="v.icon" class="text-[10px] text-muted-foreground group-hover:text-primary"></i>
                        <span class="text-[9px] font-medium" x-text="v.label"></span>
                    </div>
                </label>
            </template>
        </div>

        <hr class="border-border">

        <!-- Button Shape Mapping -->
        <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Köşe Yuvarlaklığı') }}</h4>
        <div class="grid grid-cols-3 gap-3">
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.buttons.style" value="square" class="sr-only peer">
                <div class="h-14 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex items-center justify-center bg-muted/20 hover:bg-muted/50 p-2">
                    <div class="w-full h-6 bg-foreground/10 rounded-none relative"></div>
                </div>
                <span class="text-[9px] text-center block mt-1 text-muted-foreground">Kare</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.buttons.style" value="soft" class="sr-only peer">
                <div class="h-14 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex items-center justify-center bg-muted/20 hover:bg-muted/50 p-2">
                    <div class="w-full h-6 bg-foreground/10 rounded-md relative"></div>
                </div>
                <span class="text-[9px] text-center block mt-1 text-muted-foreground">Yumuşak</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.buttons.style" value="pill" class="sr-only peer">
                <div class="h-14 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex items-center justify-center bg-muted/20 hover:bg-muted/50 p-2">
                    <div class="w-full h-6 bg-foreground/10 rounded-full relative"></div>
                </div>
                <span class="text-[9px] text-center block mt-1 text-muted-foreground">Hap</span>
            </label>
        </div>

        <hr class="border-border">

        <!-- Text Alignment (NEW) -->
        <div class="flex items-center justify-between">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Metin Hizalama') }}</h4>
            <div class="flex bg-muted/30 p-1 rounded-md border border-border">
                <button @click="draftDesign.buttons.align = 'left'" :class="draftDesign.buttons.align === 'left' ? 'bg-background shadow-sm text-primary' : 'text-muted-foreground hover:text-foreground'" class="p-1.5 rounded transition-all">
                    <i class="fas fa-align-left text-xs"></i>
                </button>
                <button @click="draftDesign.buttons.align = 'center'" :class="draftDesign.buttons.align === 'center' ? 'bg-background shadow-sm text-primary' : 'text-muted-foreground hover:text-foreground'" class="p-1.5 rounded transition-all">
                    <i class="fas fa-align-center text-xs"></i>
                </button>
                <button @click="draftDesign.buttons.align = 'right'" :class="draftDesign.buttons.align === 'right' ? 'bg-background shadow-sm text-primary' : 'text-muted-foreground hover:text-foreground'" class="p-1.5 rounded transition-all">
                    <i class="fas fa-align-right text-xs"></i>
                </button>
            </div>
        </div>

        <hr class="border-border">

        <!-- Button Colors -->
        <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Buton Renkleri') }}</h4>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-[10px] text-muted-foreground block">Arka Plan Rengi</label>
                <div class="flex items-center gap-2">
                    <input type="color" x-model="draftDesign.buttons.bg_color" class="h-8 w-10 rounded cursor-pointer border-0 p-0">
                    <input type="text" x-model="draftDesign.buttons.bg_color" class="flex-1 w-full text-xs rounded-md border-input bg-background font-mono" placeholder="#ffffff">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="text-[10px] text-muted-foreground block">Metin Rengi</label>
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
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Gölge Efekti') }}</h4>
                <p class="text-[9px] text-muted-foreground mt-1">Butonların çevresinde hafif bir kaldırılma efekti oluşturur.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" x-model="draftDesign.buttons.shadow" class="sr-only peer">
                <div class="w-9 h-5 bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
            </label>
        </div>

    </div>
</div>
