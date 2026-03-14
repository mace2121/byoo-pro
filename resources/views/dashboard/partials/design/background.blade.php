<div class="space-y-8 relative">
    <!-- Block overlay - REMOVED so settings stay open as requested -->
    <div x-show="false" class="hidden"></div>

    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Arka Plan Düzeni') }}</h3>
        <p class="text-[10px] text-muted-foreground mt-1">{{ __('Sayfanızın genel arkaplan stilini belirleyin.') }}</p>
    </div>

    <div class="space-y-6">
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
                <div class="h-20 rounded-md border border-input peer-only-child:border-primary peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <i class="fas fa-play-circle text-muted-foreground opacity-40"></i>
                </div>
                <span class="text-[9px] font-medium text-center block mt-1 text-muted-foreground group-hover:text-foreground">Video</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.background.type" value="animation" class="sr-only peer">
                <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2 relative overflow-hidden">
                    <i class="fas fa-magic text-muted-foreground opacity-40"></i>
                </div>
                <span class="text-[9px] font-medium text-center block mt-1 text-muted-foreground group-hover:text-foreground">Animasyon</span>
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
                    <div class="flex gap-2">
                        <label class="inline-flex items-center px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md hover:bg-primary/90 cursor-pointer shadow-sm transition-colors">
                            <i class="fas fa-upload mr-2"></i>
                            {{ __('Görsel Yükle') }}
                            <input type="file" class="hidden" accept="image/*" @change="handleFileChange($event, 'bg_image')">
                        </label>
                        <button type="button" x-show="draftDesign.background.image_url" @click="draftDesign.background.image_url = ''" class="inline-flex items-center px-3 py-1.5 bg-destructive/10 text-destructive text-xs font-semibold rounded-md hover:bg-destructive/20 transition-colors">
                            <i class="fas fa-trash-alt mr-2"></i>
                            {{ __('Kaldır') }}
                        </button>
                    </div>
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
                    <div class="flex gap-2">
                        <label class="inline-flex items-center px-4 py-1.5 bg-primary text-primary-foreground text-xs font-semibold rounded-md hover:bg-primary/90 cursor-pointer shadow-sm transition-colors">
                            <i class="fas fa-video mr-2"></i>
                            {{ __('Video Yükle') }}
                            <input type="file" class="hidden" accept="video/mp4,video/webm" @change="handleFileChange($event, 'bg_video')">
                        </label>
                        <button type="button" x-show="draftDesign.background.video_url" @click="draftDesign.background.video_url = ''" class="inline-flex items-center px-3 py-1.5 bg-destructive/10 text-destructive text-xs font-semibold rounded-md hover:bg-destructive/20 transition-colors">
                            <i class="fas fa-trash-alt mr-2"></i>
                            {{ __('Kaldır') }}
                        </button>
                    </div>
                    <p class="text-[9px] text-muted-foreground mt-2">Maksimum 5MB. En iyi deneyim için kısa (5-10sn) loop videolar tercih edin.</p>
                </div>
            </div>
        </div>

        <hr class="border-border">

        <!-- Animation Category (NEW) -->
        <div x-show="draftDesign.background.type === 'animation'" x-cloak x-transition class="space-y-6">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Animasyon Türü') }}</h4>
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-3">
                <template x-for="anim in [
                    {id:'anim-1', label:'Zigzag', class:'bg-anim-1'},
                    {id:'anim-2', label:'Daireler', class:'bg-anim-2'},
                    {id:'anim-3', label:'Çizgiler', class:'bg-anim-3'},
                    {id:'anim-4', label:'Mesh', class:'bg-anim-4'},
                    {id:'anim-5', label:'Oklar', class:'bg-anim-5'}
                ]">
                    <label class="cursor-pointer group">
                        <input type="radio" x-model="draftDesign.background.animation" :value="anim.id" class="sr-only peer">
                        <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/20 bg-muted/20 hover:bg-muted/50 p-1 flex flex-col gap-1 overflow-hidden transition-all">
                            <div class="flex-1 rounded bg-background border border-border/50 relative overflow-hidden">
                                <div class="absolute inset-0 opacity-60 pointer-events-none" :class="anim.class"></div>
                            </div>
                            <span class="text-[8px] text-center font-medium" x-text="anim.label"></span>
                        </div>
                    </label>
                </template>
            </div>
            
            <style>
                .bg-anim-1 {
                    --anim-color-1: #6366f1; --anim-color-2: #a855f7;
                    background-color: var(--anim-color-1);
                    background-image:  linear-gradient(135deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(225deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(45deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(315deg, var(--anim-color-2) 25%, var(--anim-color-1) 25%);
                    background-position:  10px 0, 10px 0, 0 0, 0 0; background-size: 20px 20px;
                    animation: bg-move-mini 5s linear infinite;
                }
                .bg-anim-2 {
                    --anim-color-1: #6366f1; --anim-color-2: #a855f7;
                    background: var(--anim-color-1);
                    background-image: radial-gradient(circle at 20% 30%, var(--anim-color-2) 0%, transparent 20%), radial-gradient(circle at 80% 70%, var(--anim-color-2) 0%, transparent 25%);
                    background-size: 200% 200%;
                    animation: bg-move-mini-alt 5s ease infinite alternate;
                }
                .bg-anim-3 {
                    --anim-color-1: #6366f1; --anim-color-2: #a855f7;
                    background: repeating-linear-gradient(45deg, var(--anim-color-1), var(--anim-color-1) 10px, var(--anim-color-2) 10px, var(--anim-color-2) 20px);
                    background-size: 200% 200%;
                    animation: bg-move-mini 10s linear infinite;
                }
                .bg-anim-4 {
                    --anim-color-1: #6366f1; --anim-color-2: #a855f7;
                    background: var(--anim-color-1);
                    background-image: conic-gradient(from 180deg at 50% 50%, var(--anim-color-2), var(--anim-color-1), var(--anim-color-2));
                    animation: bg-rotate-mini 5s linear infinite;
                }
                .bg-anim-5 {
                    --anim-color-1: #6366f1; --anim-color-2: #a855f7;
                    background-color: var(--anim-color-1);
                    background-image: linear-gradient(135deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(225deg, var(--anim-color-2) 25%, transparent 25%);
                    background-position: 0 0; background-size: 20px 20px;
                    animation: bg-move-mini 2s linear infinite;
                }
                @keyframes bg-move-mini { from { background-position: 0 0; } to { background-position: 0 20px; } }
                @keyframes bg-move-mini-alt { from { background-position: 0% 0%; } to { background-position: 100% 100%; } }
                @keyframes bg-rotate-mini { from { transform: scale(3) rotate(0deg); } to { transform: scale(3) rotate(360deg); } }
            </style>

            <!-- Animation Colors -->
            <div class="space-y-4 pt-2">
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Animasyon Renkleri') }}</h4>
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-2">
                        <template x-for="(color, index) in draftDesign.background.animation_colors">
                            <div class="relative group">
                                <input type="color" x-model="draftDesign.background.animation_colors[index]" 
                                       class="h-10 w-10 rounded-full border-2 border-background cursor-pointer p-0 shadow-sm transition-transform hover:scale-110">
                            </div>
                        </template>
                    </div>
                    <div class="flex-1 flex gap-2">
                        <template x-for="(color, index) in draftDesign.background.animation_colors">
                            <input type="text" x-model="draftDesign.background.animation_colors[index]" 
                                   class="w-full text-xs rounded-md border-input bg-background font-mono px-2 py-1.5" placeholder="#ffffff">
                        </template>
                    </div>
                    <button type="button" @click="draftDesign.background.animation_colors.reverse()" class="p-2 rounded-md hover:bg-accent text-muted-foreground transition-colors" title="Renkleri Değiştir">
                        <i class="fas fa-sync-alt text-xs"></i>
                    </button>
                </div>
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
