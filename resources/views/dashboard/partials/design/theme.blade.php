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

    <!-- SAVE AS COMMUNITY THEME SECTION -->
    <div class="mt-12 rounded-[2.5rem] border border-dashed border-primary/20 bg-primary/5 p-8 text-center transition-all hover:bg-primary/[0.08]">
        <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-3xl bg-background shadow-sm">
            <i class="fas fa-magic text-2xl text-primary"></i>
        </div>
        <h3 class="text-sm font-bold tracking-tight text-foreground">{{ __('Tasarımını Toplulukla Paylaş') }}</h3>
        <p class="mx-auto mt-2 max-w-sm text-[11px] leading-relaxed text-muted-foreground">{{ __('Bu tasarımı dilediğin zaman kendi teman olarak kaydedebilir ve admin onayı sonrası tüm dünyayla paylaşabilirsin.') }}</p>

        <form action="{{ route('themes.store') }}" method="POST" class="mt-8 flex flex-col items-center gap-4">
            @csrf
            <div class="w-full max-w-xs space-y-2">
                <input type="text" name="name" placeholder="{{ __('Temail Adı') }}" required 
                       class="w-full rounded-2xl border-border bg-background px-4 py-3 text-sm focus:ring-primary shadow-sm">
            </div>
            
            <label class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox" name="is_premium" value="1" class="rounded text-primary focus:ring-primary border-border">
                <span class="text-xs font-medium text-muted-foreground group-hover:text-foreground transition-colors">{{ __('Sadece PRO kullanıcılar kullanabilsin') }}</span>
            </label>

            <button type="submit" 
                    class="mt-2 inline-flex items-center gap-2 rounded-2xl bg-primary px-8 py-3 text-xs font-bold text-primary-foreground shadow-lg transition-all hover:scale-105 active:scale-95">
                <i class="fas fa-cloud-upload-alt text-[10px]"></i>
                {{ __('Tema Olarak Kaydet & Paylaş') }}
            </button>
        </form>
    </div>
</div>
