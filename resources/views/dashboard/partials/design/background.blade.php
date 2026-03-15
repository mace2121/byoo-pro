<div class="space-y-8">
    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Arka Plan') }}</h3>
        <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Aynı anda yalnızca tek arka plan modu aktiftir. Mod değiştiğinde önizleme katmanları temizlenir ve yeni görünüm anında uygulanır.') }}</p>
    </div>

    <div class="grid grid-cols-5 gap-2 lg:gap-3">
        <template x-for="type in backgroundTypeOptions" :key="type.id">
            <button type="button"
                    @click="draftDesign.background.active_type = type.id"
                    :class="draftDesign.background.active_type === type.id ? 'border-primary bg-primary/5 text-primary' : 'border-input bg-background text-muted-foreground hover:text-foreground'"
                    class="group flex min-h-[106px] flex-col items-center justify-center gap-2 rounded-2xl border px-2 py-3 text-center transition-all">
                <div class="relative flex h-12 w-full items-center justify-center overflow-hidden rounded-xl border border-border/60 bg-muted/20">
                    <template x-if="type.id === 'color'">
                        <div class="h-8 w-8 rounded-full border border-border/50 shadow-sm" :style="`background:${draftDesign.background.color}`"></div>
                    </template>
                    <template x-if="type.id === 'gradient'">
                        <div class="absolute inset-0" :style="`background:${buildGradientPreview(draftDesign.background)}`"></div>
                    </template>
                    <template x-if="type.id === 'image'">
                        <i class="fas fa-image text-sm opacity-50"></i>
                    </template>
                    <template x-if="type.id === 'video'">
                        <i class="fas fa-film text-sm opacity-50"></i>
                    </template>
                    <template x-if="type.id === 'animation'">
                        <i class="fas fa-wand-magic-sparkles text-sm opacity-50"></i>
                    </template>
                </div>
                <span class="text-[11px] font-semibold" x-text="type.label"></span>
            </button>
        </template>
    </div>

    <div x-show="draftDesign.background.active_type === 'color'" x-cloak class="rounded-2xl border border-border bg-muted/10 p-5">
        <div class="space-y-4">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Düz Renk') }}</h4>
                <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Tek renk arka plan canlı önizlemeye anında uygulanır.') }}</p>
            </div>
            <div class="design-color-control">
                <label class="design-color-swatch">
                    <input type="color" x-model="draftDesign.background.color" class="design-color-input">
                </label>
            </div>
        </div>
    </div>

    <div x-show="draftDesign.background.active_type === 'gradient'" x-cloak class="rounded-2xl border border-border bg-muted/10 p-5">
        <div class="space-y-5">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Gradyan') }}</h4>
                <p class="mt-1 text-[11px] text-muted-foreground">{{ __('İki renk seçin, ardından yön ve açı ile görünümü netleştirin.') }}</p>
            </div>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-[1fr_1fr_0.9fr]">
                <div class="space-y-3">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Renk 1') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.background.gradient_color_1" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-3">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Renk 2') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.background.gradient_color_2" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="rounded-2xl border border-border/70" :style="`background:${buildGradientPreview(draftDesign.background)}`"></div>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Yön') }}</label>
                    <div class="inline-flex rounded-2xl border border-border bg-background p-1">
                        <button type="button"
                                @click="draftDesign.background.gradient_direction = 'linear'"
                                :class="draftDesign.background.gradient_direction === 'linear' ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:text-foreground'"
                                class="rounded-xl px-4 py-2 text-sm font-semibold transition-all">
                            {{ __('Doğrusal') }}
                        </button>
                        <button type="button"
                                @click="draftDesign.background.gradient_direction = 'radial'"
                                :class="draftDesign.background.gradient_direction === 'radial' ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:text-foreground'"
                                class="rounded-xl px-4 py-2 text-sm font-semibold transition-all">
                            {{ __('Radyal') }}
                        </button>
                    </div>
                </div>
                <div class="space-y-2" x-show="draftDesign.background.gradient_direction === 'linear'" x-cloak>
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-medium text-muted-foreground">{{ __('Açı') }}</label>
                        <span class="text-[11px] font-mono text-muted-foreground" x-text="draftDesign.background.gradient_angle + '°'"></span>
                    </div>
                    <input type="range" x-model.number="draftDesign.background.gradient_angle" min="0" max="360" class="h-2 w-full cursor-pointer appearance-none rounded-full bg-muted accent-primary">
                </div>
            </div>
        </div>
    </div>

    <div x-show="draftDesign.background.active_type === 'image'" x-cloak class="rounded-2xl border border-border bg-muted/10 p-5">
        <div class="space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Görsel Arka Plan') }}</h4>
                    <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Yüklediğiniz görsel arka plan olarak anında önizlemede görünür.') }}</p>
                </div>
                <button type="button" x-show="draftDesign.background.image_url" @click="clearDesignMedia('bg_image', 'background.image_url')" class="text-[11px] font-semibold text-destructive hover:underline">{{ __('Görseli Kaldır') }}</button>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex h-20 w-16 items-center justify-center overflow-hidden rounded-2xl border border-input bg-background">
                    <template x-if="draftDesign.background.image_url">
                        <img :src="draftDesign.background.image_url" class="h-full w-full object-cover">
                    </template>
                    <template x-if="!draftDesign.background.image_url">
                        <i class="fas fa-image text-muted-foreground/40"></i>
                    </template>
                </div>
                <div class="space-y-2">
                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-sm transition-all hover:bg-primary/90">
                        <i class="fas fa-upload text-[11px]"></i>
                        {{ __('Görsel Seç') }}
                        <input type="file" class="hidden" accept="image/*" @change="handleFileChange($event, 'bg_image')">
                    </label>
                    <p class="text-[11px] text-muted-foreground">{{ __('Mobil görünüm için dikey görseller daha iyi sonuç verir.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div x-show="draftDesign.background.active_type === 'video'" x-cloak class="rounded-2xl border border-primary/20 bg-primary/5 p-5">
        <div class="space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-primary">{{ __('Video Arka Plan') }}</h4>
                    <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Yüklediğiniz video önizlemede gerçek video olarak oynatılır.') }}</p>
                </div>
                <button type="button" x-show="draftDesign.background.video_url" @click="clearDesignMedia('bg_video', 'background.video_url')" class="text-[11px] font-semibold text-destructive hover:underline">{{ __('Videoyu Kaldır') }}</button>
            </div>
            <label class="inline-flex w-max cursor-pointer items-center gap-2 rounded-xl bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-sm transition-all hover:bg-primary/90">
                <i class="fas fa-video text-[11px]"></i>
                {{ __('Video Seç') }}
                <input type="file" class="hidden" accept="video/mp4,video/webm" @change="handleFileChange($event, 'bg_video')">
            </label>
            <p class="text-[11px] text-muted-foreground">{{ __('Önerilen maksimum video boyutu 8MB ve formatlar MP4/WebM.') }}</p>
        </div>
    </div>

    <div x-show="draftDesign.background.active_type === 'animation'" x-cloak class="rounded-2xl border border-border bg-muted/10 p-5">
        <div class="space-y-5">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Animasyon') }}</h4>
                <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Hazır animasyonlardan birini seçin. Renk değişiklikleri anında önizlemeye yansır.') }}</p>
            </div>

            <div class="grid grid-cols-2 gap-3 lg:grid-cols-5">
                <template x-for="anim in animationOptions" :key="anim.id">
                    <button type="button"
                            @click="draftDesign.background.animation = anim.id"
                            :class="draftDesign.background.animation === anim.id ? 'border-primary bg-primary/5' : 'border-input bg-background hover:bg-muted/40'"
                            class="rounded-2xl border p-2 transition-all">
                        <div class="relative h-20 overflow-hidden rounded-xl border border-border/60 bg-muted/20">
                            <div class="absolute inset-0 opacity-70" :class="anim.class"></div>
                        </div>
                        <span class="mt-2 block text-[11px] font-semibold text-foreground" x-text="anim.label"></span>
                    </button>
                </template>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Ana Renk') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.background.animation_colors[0]" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('İkinci Renk') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.background.animation_colors[1]" class="design-color-input">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-border bg-muted/10 p-5">
        <div class="space-y-4">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Efektler') }}</h4>
                <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Karartma ve bulanıklık değerleri görsel, video ve animasyon arka planlarında anında uygulanır.') }}</p>
            </div>
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-medium text-muted-foreground">{{ __('Karartma Yoğunluğu') }}</label>
                        <span class="text-[11px] font-mono text-muted-foreground" x-text="draftDesign.background.overlay + '%' "></span>
                    </div>
                    <input type="range" x-model.number="draftDesign.background.overlay" min="0" max="100" class="h-2 w-full cursor-pointer appearance-none rounded-full bg-muted accent-primary">
                </div>
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-[11px] font-medium text-muted-foreground">{{ __('Bulanıklık') }}</label>
                        <span class="text-[11px] font-mono text-muted-foreground" x-text="draftDesign.background.blur + 'px' "></span>
                    </div>
                    <input type="range" x-model.number="draftDesign.background.blur" min="0" max="50" class="h-2 w-full cursor-pointer appearance-none rounded-full bg-muted accent-primary">
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-anim-1 {
            --anim-color-1: #6366f1;
            --anim-color-2: #a855f7;
            background-color: var(--anim-color-1);
            background-image: linear-gradient(135deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(225deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(45deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(315deg, var(--anim-color-2) 25%, var(--anim-color-1) 25%);
            background-size: 24px 24px;
            animation: de-preview-zigzag 4s linear infinite;
        }
        .bg-anim-2 {
            --anim-color-1: #6366f1;
            --anim-color-2: #a855f7;
            background: var(--anim-color-1);
            background-image: radial-gradient(circle at 20% 30%, var(--anim-color-2) 0%, transparent 22%), radial-gradient(circle at 80% 70%, var(--anim-color-2) 0%, transparent 28%);
            background-size: 180% 180%;
            animation: de-preview-float 5s ease infinite alternate;
        }
        .bg-anim-3 {
            --anim-color-1: #6366f1;
            --anim-color-2: #a855f7;
            background: repeating-linear-gradient(45deg, var(--anim-color-1), var(--anim-color-1) 10px, var(--anim-color-2) 10px, var(--anim-color-2) 20px);
            background-size: 200% 200%;
            animation: de-preview-zigzag 6s linear infinite;
        }
        .bg-anim-4 {
            --anim-color-1: #6366f1;
            --anim-color-2: #a855f7;
            background: conic-gradient(from 180deg at 50% 50%, var(--anim-color-2), var(--anim-color-1), var(--anim-color-2));
            animation: de-preview-spin 4s linear infinite;
        }
        .bg-anim-5 {
            --anim-color-1: #6366f1;
            --anim-color-2: #a855f7;
            background-color: var(--anim-color-1);
            background-image: linear-gradient(135deg, var(--anim-color-2) 25%, transparent 25%), linear-gradient(225deg, var(--anim-color-2) 25%, transparent 25%);
            background-size: 22px 22px;
            animation: de-preview-zigzag 2s linear infinite;
        }
        @keyframes de-preview-zigzag {
            from { background-position: 0 0; }
            to { background-position: 0 24px; }
        }
        @keyframes de-preview-float {
            from { background-position: 0% 0%; }
            to { background-position: 100% 100%; }
        }
        @keyframes de-preview-spin {
            from { transform: scale(1.8) rotate(0deg); }
            to { transform: scale(1.8) rotate(360deg); }
        }
    </style>
</div>

