@props([
    'name',
    'label',
    'options' => [],
    'value' => '',
    'placeholder' => 'Secim yapin',
    'hint' => null,
    'searchable' => false,
    'changeEvent' => null,
])

<div class="space-y-2" x-data="pickerField({
    value: @js((string) $value),
    options: @js($options),
    placeholder: @js($placeholder),
    hint: @js($hint),
    searchable: @js((bool) $searchable),
    changeEvent: @js($changeEvent),
})">
    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">{{ $label }}</label>
    <input type="hidden" name="{{ $name }}" :value="value">

    <div class="relative">
        <button type="button"
                @click="open = !open"
                :class="open ? 'border-primary ring-2 ring-primary/15' : 'border-input hover:border-primary/40'"
                class="flex w-full items-center justify-between gap-3 rounded-2xl border bg-background px-4 py-3 text-left shadow-sm transition-all">
            <div class="flex min-w-0 items-center gap-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl border border-border bg-muted/30 text-sm text-foreground">
                    <template x-if="selectedOption()?.icon">
                        <i :class="selectedOption().icon"></i>
                    </template>
                    <template x-if="!selectedOption()?.icon">
                        <i class="fas fa-chevron-down text-xs text-muted-foreground"></i>
                    </template>
                </div>
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-foreground" x-text="selectedOption()?.label || placeholder"></p>
                    <p class="truncate text-xs text-muted-foreground" x-text="selectedOption()?.hint || hint || ''"></p>
                </div>
            </div>

            <i class="fas fa-chevron-down text-xs text-muted-foreground transition-transform" :class="open ? 'rotate-180' : ''"></i>
        </button>

        <div x-show="open"
             x-cloak
             @click.outside="close()"
             class="absolute left-0 right-0 top-[calc(100%+0.5rem)] z-40 overflow-hidden rounded-2xl border border-border bg-popover shadow-2xl">
            <div x-show="searchable" x-cloak class="border-b border-border p-3">
                <div class="relative">
                    <i class="fas fa-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-muted-foreground"></i>
                    <input type="text"
                           x-model="search"
                           placeholder="Ara..."
                           class="h-10 w-full rounded-xl border border-input bg-background pl-9 pr-3 text-sm shadow-sm focus:border-primary focus:ring-primary">
                </div>
            </div>

            <div class="max-h-72 overflow-y-auto p-2">
                <template x-for="option in filteredOptions()" :key="option.value || '__empty-option'">
                    <button type="button"
                            @click="select(option.value)"
                            :class="value === String(option.value ?? '') ? 'bg-primary/8 text-primary border-primary/30' : 'border-transparent text-foreground hover:bg-muted/60'"
                            class="flex w-full items-center gap-3 rounded-xl border px-3 py-2.5 text-left transition-all">
                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-border bg-background text-sm">
                            <template x-if="option.icon">
                                <i :class="option.icon"></i>
                            </template>
                            <template x-if="!option.icon">
                                <i class="fas fa-circle text-[8px] text-muted-foreground"></i>
                            </template>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold" x-text="option.label"></p>
                            <p class="truncate text-xs text-muted-foreground" x-text="option.hint || ''"></p>
                        </div>
                        <i x-show="value === String(option.value ?? '')" x-cloak class="fas fa-check text-xs text-primary"></i>
                    </button>
                </template>

                <div x-show="filteredOptions().length === 0" x-cloak class="px-3 py-6 text-center text-sm text-muted-foreground">
                    Sonuc bulunamadi.
                </div>
            </div>
        </div>
    </div>
</div>
