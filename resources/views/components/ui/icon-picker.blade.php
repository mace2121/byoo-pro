@props([
    'name',
    'label',
    'options' => [],
    'value' => '',
    'placeholder' => 'Ikon sec',
])

<div class="space-y-2"
     x-data="iconPickerField({
        value: @js((string) $value),
        options: @js($options),
        placeholder: @js($placeholder),
     })"
     x-effect="if (open) { $nextTick(() => $refs.searchInput && $refs.searchInput.focus()) }">
    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">{{ $label }}</label>
    <input type="hidden" name="{{ $name }}" :value="value">

    <button type="button"
            @click="open = true"
            class="flex w-full items-center justify-between gap-3 rounded-2xl border border-input bg-background px-4 py-3 text-left shadow-sm transition-all hover:border-primary/40">
        <div class="flex min-w-0 items-center gap-3">
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl border border-border bg-muted/30 text-base text-foreground">
                <template x-if="selectedOption()?.value">
                    <i :class="selectedOption().value"></i>
                </template>
                <template x-if="!selectedOption()?.value">
                    <i class="fas fa-icons text-sm"></i>
                </template>
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-foreground" x-text="selectedOption()?.label || placeholder"></p>
                <p class="truncate text-xs text-muted-foreground" x-text="selectedOption()?.hint || 'Populer ikon kutuphanesinden secin'"></p>
            </div>
        </div>

        <span class="inline-flex items-center gap-2 rounded-full border border-border bg-muted/40 px-3 py-1 text-[11px] font-semibold text-muted-foreground">
            <i class="fas fa-expand text-[10px]"></i>
            Popup
        </span>
    </button>

    <div x-show="open" x-cloak class="fixed inset-0 z-[90] flex items-center justify-center p-4 sm:p-6">
        <div class="absolute inset-0 bg-black/55 backdrop-blur-sm" @click="close()"></div>

        <div class="relative z-10 w-full max-w-4xl overflow-hidden rounded-[32px] border border-border bg-background shadow-2xl">
            <div class="flex items-start justify-between gap-4 border-b border-border px-5 py-4 sm:px-6">
                <div>
                    <h3 class="text-xl font-semibold">Ikon Sec</h3>
                    <p class="mt-1 text-sm text-muted-foreground">En populer ikonlar arasindan secim yapin. Turkce arama desteklenir.</p>
                </div>
                <button type="button" @click="close()" class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-border bg-muted/30 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <div class="border-b border-border px-5 py-4 sm:px-6">
                <div class="relative">
                    <i class="fas fa-search pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-muted-foreground"></i>
                    <input type="text"
                           x-model="search"
                           x-ref="searchInput"
                           placeholder="Ikon veya kategori ara..."
                           class="h-12 w-full rounded-2xl border border-input bg-background pl-11 pr-4 text-sm shadow-sm focus:border-primary focus:ring-primary">
                </div>
            </div>

            <div class="max-h-[65vh] overflow-y-auto px-5 py-5 sm:px-6">
                <div class="grid grid-cols-4 gap-3 sm:grid-cols-5 lg:grid-cols-6">
                    <template x-for="option in filteredOptions()" :key="option.value || '__icon-empty'">
                        <button type="button"
                                @click="select(option.value)"
                                :title="option.label"
                                :class="value === String(option.value ?? '') ? 'border-primary bg-primary/8 text-primary shadow-sm' : 'border-border bg-muted/20 text-foreground hover:border-primary/40 hover:bg-muted/40'"
                                class="group flex aspect-square flex-col items-center justify-center rounded-2xl border p-2 text-center transition-all">
                            <i :class="option.value || 'fas fa-wand-magic-sparkles'" class="text-xl"></i>
                            <span class="mt-2 line-clamp-2 text-[11px] font-semibold leading-4" x-text="option.label"></span>
                        </button>
                    </template>
                </div>

                <div x-show="filteredOptions().length === 0" x-cloak class="py-12 text-center text-sm text-muted-foreground">
                    Aradiginiz ikon bulunamadi.
                </div>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                if (!Alpine.data('iconPickerField')) {
                    Alpine.data('iconPickerField', (config = {}) => ({
                        open: false,
                        search: '',
                        value: String(config.value ?? ''),
                        options: Array.isArray(config.options) ? config.options : [],
                        placeholder: config.placeholder ?? 'Ikon sec',

                        init() {
                            this.value = this.normalizeValue(this.value);
                            this.options = this.options.map((option) => ({
                                ...option,
                                value: this.normalizeValue(option.value ?? ''),
                            }));
                        },

                        normalizeValue(value) {
                            const raw = String(value ?? '').trim();
                            if (raw === 'fab fa-x-twitter' || raw === 'fa-brands fa-x-twitter') {
                                return 'fab fa-twitter';
                            }

                            return raw;
                        },

                        normalizeSearch(value) {
                            return String(value ?? '')
                                .toLowerCase()
                                .replace(/\u0131/g, 'i')
                                .normalize('NFD')
                                .replace(/[\u0300-\u036f]/g, '')
                                .replace(/[^\w\s/-]/g, ' ');
                        },

                        selectedOption() {
                            return this.options.find((option) => String(option.value ?? '') === this.value) ?? this.options[0] ?? null;
                        },

                        filteredOptions() {
                            const term = this.normalizeSearch(this.search).trim();
                            if (!term) {
                                return this.options;
                            }

                            return this.options.filter((option) => {
                                const haystack = this.normalizeSearch([
                                    option.label,
                                    option.hint,
                                    option.keywords,
                                    option.value,
                                ].filter(Boolean).join(' '));

                                return haystack.includes(term);
                            });
                        },

                        select(nextValue) {
                            this.value = this.normalizeValue(nextValue ?? '');
                            this.close();
                        },

                        close() {
                            this.open = false;
                            this.search = '';
                        },
                    }));
                }
            });
        </script>
    @endpush
@endonce
