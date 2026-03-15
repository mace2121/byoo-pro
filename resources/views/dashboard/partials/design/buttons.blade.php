<div class="space-y-8">
    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Butonlar') }}</h3>
        <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Bu bölümde yalnızca buton biçimini yönetirsiniz. Renk ayarları ayrı olarak Renk menüsünde bulunur.') }}</p>
    </div>

    <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
        <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Görünüm Varyantı') }}</h4>
        <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">
            <template x-for="variant in buttonVariantOptions" :key="variant.id">
                <button type="button"
                        @click="draftDesign.buttons.variant = variant.id"
                        :class="draftDesign.buttons.variant === variant.id ? 'border-primary bg-primary/5 text-primary' : 'border-input bg-background text-muted-foreground hover:text-foreground'"
                        class="flex min-h-[88px] flex-col items-center justify-center gap-2 rounded-2xl border p-3 text-center transition-all">
                    <i :class="variant.icon" class="text-base"></i>
                    <span class="text-[11px] font-semibold" x-text="variant.label"></span>
                </button>
            </template>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Köşe Yuvarlaklığı') }}</h4>
                    <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Slider hareket ettikçe canlı önizleme anında güncellenir.') }}</p>
                </div>
                <span class="rounded-full bg-background px-3 py-1 text-[11px] font-mono text-muted-foreground" x-text="draftDesign.buttons.radius + 'px'"></span>
            </div>
            <input type="range" x-model.number="draftDesign.buttons.radius" min="0" max="36" class="h-2 w-full cursor-pointer appearance-none rounded-full bg-muted accent-primary">
        </div>

        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Metin Hizalama') }}</h4>
                    <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Link başlıklarının yatay hizasını belirler.') }}</p>
                </div>
                <div class="inline-flex rounded-xl border border-border bg-background p-1">
                    <button type="button" @click="draftDesign.buttons.align = 'left'" :class="draftDesign.buttons.align === 'left' ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:text-foreground'" class="rounded-lg px-3 py-2 transition-all"><i class="fas fa-align-left text-xs"></i></button>
                    <button type="button" @click="draftDesign.buttons.align = 'center'" :class="draftDesign.buttons.align === 'center' ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:text-foreground'" class="rounded-lg px-3 py-2 transition-all"><i class="fas fa-align-center text-xs"></i></button>
                    <button type="button" @click="draftDesign.buttons.align = 'right'" :class="draftDesign.buttons.align === 'right' ? 'bg-primary/10 text-primary' : 'text-muted-foreground hover:text-foreground'" class="rounded-lg px-3 py-2 transition-all"><i class="fas fa-align-right text-xs"></i></button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5" :class="draftDesign.buttons.variant === 'offset' ? 'opacity-60' : ''">
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Kenarlık Stili') }}</h4>
                <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Offset varyantında bu alan pasif kalır.') }}</p>
            </div>
            <select x-model="draftDesign.buttons.border_style" :disabled="draftDesign.buttons.variant === 'offset'" class="h-11 w-full rounded-xl border-input bg-background text-sm shadow-sm disabled:cursor-not-allowed disabled:opacity-70">
                <option value="solid">{{ __('Düz') }}</option>
                <option value="dashed">{{ __('Kesik') }}</option>
                <option value="dotted">{{ __('Noktalı') }}</option>
                <option value="double">{{ __('Çift') }}</option>
            </select>
        </div>

        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5" :class="draftDesign.buttons.variant === 'offset' ? 'opacity-60' : ''">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Kenarlık Kalınlığı') }}</h4>
                    <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Offset varyantında gölge rengi kenarlık renginden alınır.') }}</p>
                </div>
                <span class="rounded-full bg-background px-3 py-1 text-[11px] font-mono text-muted-foreground" x-text="draftDesign.buttons.border_width + 'px'"></span>
            </div>
            <input type="range" x-model.number="draftDesign.buttons.border_width" :disabled="draftDesign.buttons.variant === 'offset'" min="0" max="8" class="h-2 w-full cursor-pointer appearance-none rounded-full bg-muted accent-primary disabled:cursor-not-allowed disabled:opacity-70">
        </div>
    </div>

    <div class="flex items-center justify-between rounded-2xl border border-border bg-muted/10 p-5">
        <div>
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Gölge') }}</h4>
            <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Solid ve outline varyantlarında hafif derinlik sağlar.') }}</p>
        </div>
        <button type="button"
                @click="draftDesign.buttons.shadow = !draftDesign.buttons.shadow"
                :class="draftDesign.buttons.shadow ? 'bg-primary' : 'bg-muted-foreground/30'"
                class="relative inline-flex h-6 w-11 rounded-full border-2 border-transparent transition-colors">
            <span :class="draftDesign.buttons.shadow ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 rounded-full bg-background shadow transition-transform"></span>
        </button>
    </div>
</div>
