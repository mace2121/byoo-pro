<div class="space-y-8 relative">
    <!-- Block overlay if preset theme is active -->
    <div x-show="!draftDesign.theme.custom_theme" x-transition class="absolute inset-0 z-10 bg-background/50 backdrop-blur-[1px] flex flex-col items-center justify-center rounded-lg border border-border">
        <i class="fas fa-lock text-xl text-muted-foreground mb-2"></i>
        <h4 class="text-sm font-medium">{{ __('Özel Tasarım Kapalı') }}</h4>
        <p class="text-[10px] text-muted-foreground text-center max-w-[200px] mt-1">{{ __('Arka plan ayarlarını değiştirmek için Tema sekmesinden Özel Tasarım moduna geçmelisiniz.') }}</p>
        <button type="button" @click="designTab = 'theme'; draftDesign.theme.custom_theme = true;" class="mt-4 px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md shadow-sm hover:bg-primary/90 transition-colors">
            {{ __('Kilidi Aç') }}
        </button>
    </div>

    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Arka Plan Düzeni') }}</h3>
        <p class="text-[10px] text-muted-foreground mt-1">{{ __('Sayfanızın genel arkaplan stilini belirleyin.') }}</p>
    </div>

    <div class="space-y-6" :class="{ 'opacity-50 pointer-events-none': !draftDesign.theme.custom_theme }">
        <!-- Background Type Mapping -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.background.type" value="color" class="sr-only peer">
                <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <div class="w-6 h-6 rounded-full border border-border/50 shadow-sm z-10" :style="`background-color: ${draftDesign.background.color || '#f9fafb'}`"></div>
                </div>
                <span class="text-[9px] font-medium text-center block mt-1 text-muted-foreground group-hover:text-foreground">Renk</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.background.type" value="gradient" class="sr-only peer">
                <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <div class="absolute inset-0" :style="`background: ${draftDesign.background.gradient || 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'}`"></div>
                </div>
                <span class="text-[9px] font-medium text-center block mt-1 text-muted-foreground group-hover:text-foreground">Gradyan</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.background.type" value="image" class="sr-only peer">
                <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <i class="fas fa-image text-muted-foreground opacity-40"></i>
                </div>
                <span class="text-[9px] font-medium text-center block mt-1 text-muted-foreground group-hover:text-foreground">Görsel</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.background.type" value="video" class="sr-only peer">
                <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <i class="fas fa-play-circle text-muted-foreground opacity-40"></i>
                </div>
                <span class="text-[9px] font-medium text-center block mt-1 text-muted-foreground group-hover:text-foreground">Video</span>
            </label>
        </div>

        <hr class="border-border">

        <!-- Solid Color Settings -->
        <div x-show="draftDesign.background.type === 'color'" x-cloak x-transition class="space-y-4">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Renk Seçimi') }}</h4>
            <div class="flex items-center gap-4">
                <input type="color" x-model="draftDesign.background.color" class="h-10 w-14 rounded cursor-pointer border-0 p-0 shadow-sm">
                <input type="text" x-model="draftDesign.background.color" class="flex-1 text-sm rounded-md border-input bg-background font-mono" placeholder="#f9fafb">
            </div>
        </div>

        <!-- Gradient Settings -->
        <div x-show="draftDesign.background.type === 'gradient'" x-cloak x-transition class="space-y-4">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Gradyan Ayarı') }}</h4>
            <div class="space-y-2">
                <label class="text-[10px] text-muted-foreground">CSS Gradient Kodu</label>
                <input type="text" x-model="draftDesign.background.gradient" class="w-full text-xs rounded-md border-input bg-background font-mono" placeholder="linear-gradient(135deg, #667eea 0%, #764ba2 100%)">
            </div>
            
            <div class="grid grid-cols-5 gap-2 pt-1">
                <template x-for="g in [
                    'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                    'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                    'linear-gradient(135deg, #0c3547 0%, #204060 100%)',
                    'linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%)',
                    'linear-gradient(135deg, #ff9a9e 0%, #fad0c4 99%, #fad0c4 100%)'
                ]">
                    <button type="button" @click="draftDesign.background.gradient = g" class="h-6 rounded border border-border/50 shadow-sm transition-transform hover:scale-105" :style="`background: ${g}`" :title="g"></button>
                </template>
            </div>
        </div>

        <!-- Image Settings -->
        <div x-show="draftDesign.background.type === 'image'" x-cloak x-transition class="space-y-4 bg-muted/5 p-4 rounded-lg border border-border/50">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Özel Arka Plan Görseli') }}</h4>
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-lg bg-background border border-input overflow-hidden flex-shrink-0">
                    <template x-if="draftDesign.background.image_url">
                        <img :src="draftDesign.background.image_url" class="w-full h-full object-cover">
                    </template>
                    <div x-show="!draftDesign.background.image_url" class="w-full h-full flex items-center justify-center opacity-20"><i class="fas fa-image"></i></div>
                </div>
                <div class="flex-1">
                    <label class="inline-flex items-center px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md hover:bg-primary/90 cursor-pointer shadow-sm transition-colors">
                        <i class="fas fa-upload mr-2"></i>
                        {{ __('Görsel Yükle') }}
                        <input type="file" class="hidden" accept="image/*" @change="handleFileChange($event, 'bg_image')">
                    </label>
                    <p class="text-[9px] text-muted-foreground mt-2">Dikey görseller (9:16) mobil için daha iyi sonuç verir.</p>
                </div>
            </div>
        </div>

        <!-- Video Settings -->
        <div x-show="draftDesign.background.type === 'video'" x-cloak x-transition class="space-y-4 bg-primary/5 p-4 rounded-lg border border-primary/20">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-primary">{{ __('Arka Plan Videosu') }}</h4>
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-lg bg-background border border-input overflow-hidden flex-shrink-0 flex items-center justify-center">
                    <i class="fas fa-film text-primary/40"></i>
                </div>
                <div class="flex-1">
                    <label class="inline-flex items-center px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md hover:bg-primary/90 cursor-pointer shadow-sm transition-colors">
                        <i class="fas fa-video mr-2"></i>
                        {{ __('Video Yükle') }}
                        <input type="file" class="hidden" accept="video/mp4,video/webm" @change="handleFileChange($event, 'bg_video')">
                    </label>
                    <p class="text-[9px] text-muted-foreground mt-2">Maksimum 5MB. En iyi deneyim için kısa (5-10sn) loop videolar tercih edin.</p>
                </div>
            </div>
        </div>

        <hr class="border-border">

        <!-- Animation Patterns (NEW) -->
        <div class="space-y-4">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Dinamik Animasyonlar') }}</h4>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-2">
                <template x-for="anim in [
                    {id:'none', label:'Yok'},
                    {id:'floating', label:'Yüzen'},
                    {id:'pulse', label:'Nabız'},
                    {id:'zigzag', label:'Zigzag'},
                    {id:'dots', label:'Nokta'},
                    {id:'waves', label:'Dalga'}
                ]">
                    <button type="button" 
                            @click="draftDesign.background.animation = anim.id"
                            :class="draftDesign.background.animation === anim.id ? 'bg-primary text-primary-foreground border-primary' : 'bg-muted/20 text-muted-foreground border-border hover:bg-muted/40'"
                            class="py-2 px-1 rounded border text-[9px] font-medium transition-all">
                        <span x-text="anim.label"></span>
                    </button>
                </template>
            </div>
        </div>

        <hr class="border-border opacity-50">

        <!-- Overlay & Blur -->
        <div class="space-y-5">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Efektler & Okunabilirlik') }}</h4>
            <div class="space-y-4">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-medium">Karartma Yoğunluğu</label>
                        <span class="text-[10px] text-muted-foreground font-mono" x-text="draftDesign.background.overlay + '%'"></span>
                    </div>
                    <input type="range" x-model="draftDesign.background.overlay" min="0" max="100" class="w-full h-1.5 bg-muted rounded-lg appearance-none cursor-pointer accent-primary">
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-medium">Bulanıklık (Blur)</label>
                        <span class="text-[10px] text-muted-foreground font-mono" x-text="draftDesign.background.blur + 'px'"></span>
                    </div>
                    <input type="range" x-model="draftDesign.background.blur" min="0" max="50" class="w-full h-1.5 bg-muted rounded-lg appearance-none cursor-pointer accent-primary">
                </div>
            </div>
        </div>
        
    </div>
</div>
