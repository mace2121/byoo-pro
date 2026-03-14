<div class="space-y-8 relative">
    <!-- Block overlay if preset theme is active -->
    <div x-show="!draftDesign.theme.custom_theme" x-transition class="absolute inset-0 z-10 bg-background/50 backdrop-blur-[1px] flex flex-col items-center justify-center rounded-lg border border-border">
        <i class="fas fa-lock text-xl text-muted-foreground mb-2"></i>
        <h4 class="text-sm font-medium">{{ __('Özel Tasarım Kapalı') }}</h4>
        <p class="text-[10px] text-muted-foreground text-center max-w-[200px] mt-1">{{ __('Arka plan ayarlarını değiştirmek için Tema sekmesinden Özel Tasarım moduna geçmelisiniz.') }}</p>
        <button type="button" @click="tab = 'theme'; draftDesign.theme.custom_theme = true;" class="mt-4 px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md shadow-sm hover:bg-primary/90 transition-colors">
            {{ __('Kilidi Aç') }}
        </button>
    </div>

    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Arka Plan Düzeni') }}</h3>
        <p class="text-[10px] text-muted-foreground mt-1">{{ __('Sayfanızın genel arkaplan stilini belirleyin.') }}</p>
    </div>

    <div class="space-y-6" :class="{ 'opacity-50 pointer-events-none': !draftDesign.theme.custom_theme }">
        <!-- Background Type Mapping -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.background.type" value="color" class="sr-only peer">
                <div class="h-24 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <div class="absolute inset-x-0 bottom-0 top-1/2 bg-gradient-to-t from-background/80 to-transparent"></div>
                    <div class="w-8 h-8 rounded-full border border-border/50 shadow-sm z-10" :style="`background-color: ${draftDesign.background.color || '#f9fafb'}`"></div>
                </div>
                <span class="text-[10px] font-medium text-center block mt-1.5 text-muted-foreground group-hover:text-foreground">Düz Renk</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.background.type" value="gradient" class="sr-only peer">
                <div class="h-24 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <div class="absolute inset-0" :style="`background: ${draftDesign.background.gradient || 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'}`"></div>
                    <div class="absolute inset-x-0 bottom-0 top-1/2 bg-gradient-to-t from-background/80 to-transparent"></div>
                </div>
                <span class="text-[10px] font-medium text-center block mt-1.5 text-muted-foreground group-hover:text-foreground">Gradyan (Geçişli)</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.background.type" value="image" class="sr-only peer">
                <div class="h-24 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-40 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9ImN1cnJlbnRDb2xvciIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiIGNsYXNzPSJsdWNpZGUgbHVjaWRlLWltYWdlIj48cmVjdCB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHg9IjMiIHk9IjMiIHJ4PSIyIiByeT0iMiIvPjxjaXJjbGUgY3g9IjkiIGN5PSI5IiByPSIyIi8+PHBhdGggZD0ibTIxIDE1LTMuMDgtMy4wOGExLjMzIDEuMzMgMCAwIDAtMS44OCAwTDUgMTgiLz48L3N2Zz4=')] bg-center bg-no-repeat bg-[length:24px_24px]"></div>
                </div>
                <span class="text-[10px] font-medium text-center block mt-1.5 text-muted-foreground group-hover:text-foreground">Özel Görsel</span>
            </label>
        </div>

        <hr class="border-border">

        <!-- Solid Color Settings -->
        <div x-show="draftDesign.background.type === 'color'" x-cloak x-transition class="space-y-4">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Renk Seçimi') }}</h4>
            <div class="flex items-center gap-4">
                <input type="color" x-model="draftDesign.background.color" class="h-10 w-14 rounded cursor-pointer border-0 p-0">
                <input type="text" x-model="draftDesign.background.color" class="flex-1 text-sm rounded-md border-input bg-background font-mono" placeholder="#f9fafb">
            </div>
        </div>

        <!-- Gradient Settings -->
        <div x-show="draftDesign.background.type === 'gradient'" x-cloak x-transition class="space-y-4">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Gradyan Ayarı') }}</h4>
            <div class="space-y-2">
                <label class="text-[10px] text-muted-foreground">CSS Linear/Radial Gradient Kodu</label>
                <input type="text" x-model="draftDesign.background.gradient" class="w-full text-sm rounded-md border-input bg-background font-mono text-xs" placeholder="linear-gradient(135deg, #667eea 0%, #764ba2 100%)">
            </div>
            
            <div class="grid grid-cols-4 gap-2 pt-2">
                <button type="button" @click="draftDesign.background.gradient = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'" class="h-8 rounded-md border border-border shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></button>
                <button type="button" @click="draftDesign.background.gradient = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'" class="h-8 rounded-md border border-border shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);"></button>
                <button type="button" @click="draftDesign.background.gradient = 'linear-gradient(135deg, #0c3547 0%, #204060 100%)'" class="h-8 rounded-md border border-border shadow-sm" style="background: linear-gradient(135deg, #0c3547 0%, #204060 100%);"></button>
                <button type="button" @click="draftDesign.background.gradient = 'linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%)'" class="h-8 rounded-md border border-border shadow-sm" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"></button>
            </div>
        </div>

        <!-- Image Settings -->
        <div x-show="draftDesign.background.type === 'image'" x-cloak x-transition class="space-y-4">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Özel Görsel') }}</h4>
            <div class="space-y-2">
                <label class="text-[10px] text-muted-foreground">Görsel URL (Şimdilik URL ile ekleme desteklenir)</label>
                <div class="flex gap-2">
                    <input type="text" x-model="draftDesign.background.image_url" class="flex-1 text-sm rounded-md border-input bg-background" placeholder="https://example.com/image.jpg">
                </div>
            </div>
            <p class="text-[10px] text-muted-foreground">Arka planda repeat yapılmayıp <code>cover</code> ile tam ekran doldurulacaktır.</p>
        </div>

        <hr class="border-border opacity-50">

        <!-- Overlay Settings (Always visible or contextual) -->
        <div class="space-y-6">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Katman (Overlay) Filtreleri') }}</h4>
            <p class="text-[10px] text-muted-foreground -mt-3">Görsel veya seçilen rengin üstüne siyah bir katman ve bulanıklık uygulayarak linklerin daha okunaklı olmasını sağlayabilirsiniz.</p>

            <div class="space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-medium">Karartma Yoğunluğu</label>
                        <span class="text-xs text-muted-foreground" x-text="draftDesign.background.overlay + '%'"></span>
                    </div>
                    <input type="range" x-model="draftDesign.background.overlay" min="0" max="100" class="w-full accent-primary">
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-medium">Bulanıklık (Blur)</label>
                        <span class="text-xs text-muted-foreground" x-text="draftDesign.background.blur + 'px'"></span>
                    </div>
                    <input type="range" x-model="draftDesign.background.blur" min="0" max="50" class="w-full accent-primary">
                </div>
            </div>
        </div>
        
    </div>
</div>
