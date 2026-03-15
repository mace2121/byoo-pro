<div class="space-y-8">
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-[1.5fr_1fr]">
        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Font Ailesi') }}</h4>
                <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Seçtiğiniz yazı tipi profil adı, kullanıcı adı, biyografi ve buton metinlerinde birlikte kullanılır.') }}</p>
            </div>

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-3">
                <template x-for="font in fontOptions" :key="font.id">
                    <button type="button"
                            @click="draftDesign.typography.font_family = font.id"
                            :class="draftDesign.typography.font_family === font.id ? 'border-primary bg-primary/5 shadow-sm' : 'border-input bg-background hover:bg-muted/40'"
                            class="rounded-2xl border p-4 text-left transition-all">
                        <span class="block text-sm font-semibold text-foreground" :style="`font-family: '${font.family}', sans-serif`" x-text="font.label"></span>
                    </button>
                </template>
            </div>
        </div>

        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Yazı Boyutu') }}</h4>
                <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Genel tipografi ölçeğini tek noktadan ayarlayın.') }}</p>
            </div>

            <div class="space-y-3">
                <template x-for="size in fontSizeOptions" :key="size.id">
                    <button type="button"
                            @click="draftDesign.typography.font_size_preset = size.id"
                            :class="draftDesign.typography.font_size_preset === size.id ? 'border-primary bg-primary/5 shadow-sm text-foreground' : 'border-input bg-background text-muted-foreground hover:text-foreground'"
                            class="flex w-full items-center justify-between rounded-2xl border px-4 py-3 text-left transition-all">
                        <span class="text-sm font-semibold" x-text="size.label"></span>
                        <span class="text-[11px] uppercase tracking-wider opacity-70" x-text="size.preview"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>
