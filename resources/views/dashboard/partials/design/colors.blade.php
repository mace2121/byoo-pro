<div class="space-y-8">
    <div>
        <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Renk') }}</h3>
        <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Arka plan dışındaki tüm renk ayarlarını bu bölümden yönetin. Değişiklikler canlı önizlemeye anında uygulanır.') }}</p>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Metin Renkleri') }}</h4>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Ana Başlık') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.title" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Kullanıcı Adı') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.username" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Biyografi') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.bio" class="design-color-input">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Buton Renkleri') }}</h4>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="space-y-2" x-show="draftDesign.buttons.variant !== 'glass'" x-cloak>
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Buton Arka Plan') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.button_bg" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Buton Metni') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.button_text" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Buton Kenarlık') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.button_border" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Buton İkonu') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.button_icon" class="design-color-input">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-border bg-muted/10 p-5">
        <div class="space-y-4">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Hover Renkleri') }}</h4>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="space-y-2" x-show="draftDesign.buttons.variant !== 'glass'" x-cloak>
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Arka Plan Hover') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.button_bg_hover" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Metin Hover') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.button_text_hover" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('Kenarlık Hover') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.button_border_hover" class="design-color-input">
                        </label>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-medium text-muted-foreground">{{ __('İkon Hover') }}</label>
                    <div class="design-color-control">
                        <label class="design-color-swatch">
                            <input type="color" x-model="draftDesign.colors.button_icon_hover" class="design-color-input">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
