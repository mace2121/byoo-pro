<div class="space-y-8">
    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Hazır Tema') }}</h3>
        <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Bir tema seçtiğinizde arka plan, renkler ve buton tokenları anında güncellenir. Sonrasında tüm alanları ayrı ayrı özelleştirebilirsiniz.') }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-5">
        <template x-for="preset in themePresetOptions" :key="preset.id">
            <button type="button"
                    @click.prevent="selectThemePreset(preset.id)"
                    :class="draftDesign.theme.preset === preset.id ? 'border-primary ring-2 ring-primary/20' : 'border-input hover:-translate-y-0.5 hover:border-primary/40'"
                    class="group flex flex-col gap-2 rounded-2xl border bg-background p-3 text-left transition-all">
                <div class="relative aspect-[3/4] overflow-hidden rounded-xl border border-border/60">
                    <div class="absolute inset-0" :style="preset.previewStyle"></div>
                    <div class="absolute inset-x-3 top-4 flex flex-col items-center gap-2">
                        <div class="h-10 w-10 rounded-full border" :style="`background:${preset.card}; border-color:${preset.border};`"></div>
                        <div class="h-2 w-14 rounded-full" :style="`background:${preset.text};`"></div>
                        <div class="h-1.5 w-10 rounded-full" :style="`background:${preset.muted};`"></div>
                    </div>
                    <div class="absolute inset-x-3 bottom-4 space-y-2">
                        <div class="h-4 rounded-xl border" :style="`background:${preset.card}; border-color:${preset.border};`"></div>
                        <div class="h-4 rounded-xl border" :style="`background:${preset.card}; border-color:${preset.border};`"></div>
                    </div>
                </div>
                <div>
                    <span class="block text-xs font-semibold text-foreground" x-text="preset.label"></span>
                    <span class="mt-1 block text-[11px] text-muted-foreground">{{ __('Önizleme anında güncellenir') }}</span>
                </div>
            </button>
        </template>
    </div>
</div>
