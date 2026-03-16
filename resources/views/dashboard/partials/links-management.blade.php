@php
    $catalogIcons = \App\Support\IconCatalog::popular();

    $linkIconOptions = array_merge([
        ['value' => '', 'label' => 'Otomatik sec', 'hint' => 'Link adresine gore secilir', 'keywords' => 'otomatik auto varsayilan sistem'],
    ], $catalogIcons);

    $productIconOptions = array_merge([
        ['value' => '', 'label' => 'Varsayilan urun', 'hint' => 'Standart urun simgesi', 'keywords' => 'varsayilan urun alisveris'],
    ], $catalogIcons);

    $displayModeOptions = [
        ['value' => 'link', 'label' => 'Link', 'hint' => 'Klasik tek satir buton', 'icon' => 'fas fa-link'],
        ['value' => 'card', 'label' => 'Kart', 'hint' => 'Zengin onizlemeli kart', 'icon' => 'fas fa-id-card'],
    ];

    $buttonTypeOptions = [
        ['value' => 'external_link', 'label' => 'Dis baglanti', 'hint' => 'Sayfaya yonlendirir', 'icon' => 'fas fa-arrow-up-right-from-square'],
        ['value' => 'whatsapp', 'label' => 'WhatsApp', 'hint' => 'Mesaj ile iletisim kurar', 'icon' => 'fab fa-whatsapp'],
    ];
@endphp

<div x-data="blocksManager({ initialPanel: @js($blocks->isEmpty() ? 'create' : 'list') })" class="space-y-6">
    <x-section-header :title="__('Bloklar')" :subtitle="__('Link, kart ve urun bloklarinizi tek bir yerden yonetin.')" />

    @if (session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="rounded-2xl border border-destructive/20 bg-destructive/5 px-4 py-3 text-sm text-destructive">{{ session('error') }}</div>
    @endif

    @unless($blocks_ready)
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-800">
            <p class="font-semibold">V2 block sistemi migration bekliyor.</p>
            <p class="mt-1 opacity-80"><code>php artisan migrate</code> calistirin.</p>
        </div>
    @else
        <div class="overflow-hidden rounded-[28px] border border-border bg-card shadow-sm">
            <div class="border-b border-border px-4 py-3 md:px-6">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="inline-flex rounded-2xl border border-border bg-muted/30 p-1">
                        <button type="button" @click="showPanel('create')" :class="activePanel === 'create' ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'" class="inline-flex items-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold transition-all">
                            <i class="fas fa-plus text-xs"></i> Yeni Blok
                        </button>
                        <button type="button" @click="showPanel('list')" :class="activePanel === 'list' ? 'bg-background text-foreground shadow-sm' : 'text-muted-foreground hover:text-foreground'" class="inline-flex items-center gap-2 rounded-xl px-4 py-3 text-sm font-semibold transition-all">
                            <i class="fas fa-layer-group text-xs"></i> Blok Listesi
                        </button>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="rounded-full border border-border bg-muted/30 px-3 py-1 text-xs font-semibold text-muted-foreground">{{ $blocks->count() }} blok</div>
                        <form method="post" action="{{ route('blocks.previews.refresh') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-border bg-background px-3 py-2 text-xs font-semibold text-foreground transition-colors hover:bg-muted">
                                <i class="fas fa-rotate text-[10px]"></i> Previewleri Yenile
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-6">
                <div x-show="activePanel === 'create'" x-cloak>
                    <form method="post" action="{{ route('blocks.store') }}" enctype="multipart/form-data" class="space-y-6" x-data="{ createType: 'link', buttonType: 'external_link', active: true }" @picker-button-type-updated="buttonType = $event.detail.value">
                        @csrf
                        <input type="hidden" name="type" :value="createType">
                        <input type="hidden" name="is_active" :value="active ? 1 : 0">

                        <div class="rounded-[28px] border border-border bg-background p-6 shadow-sm">
                            <div class="border-b border-border pb-5">
                                <h3 class="text-2xl font-bold tracking-tight">Yeni Blok</h3>
                                <p class="mt-1 text-sm text-muted-foreground">Link, kart veya urun bloklarinizi buradan olusturun.</p>
                            </div>

                            <div class="space-y-5 pt-5">
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="button" @click="createType = 'link'" :class="createType === 'link' ? 'border-primary bg-primary/5 text-primary' : 'border-border text-muted-foreground'" class="rounded-2xl border px-4 py-3 text-sm font-semibold transition-colors">
                                        <i class="fas fa-link mr-2 text-xs"></i> Baglanti
                                    </button>
                                    <button type="button" @click="createType = 'product'" :class="createType === 'product' ? 'border-primary bg-primary/5 text-primary' : 'border-border text-muted-foreground'" class="rounded-2xl border px-4 py-3 text-sm font-semibold transition-colors">
                                        <i class="fas fa-bag-shopping mr-2 text-xs"></i> Urun
                                    </button>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Baslik</label>
                                    <input type="text" name="title" required class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="Orn: Portfolyom">
                                </div>

                                <template x-if="createType === 'link'">
                                    <div class="space-y-5">
                                        <div class="space-y-2">
                                            <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">URL</label>
                                            <input type="url" name="url" class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="https://example.com">
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <x-ui.picker name="display_mode" label="Blok yapisi" :options="$displayModeOptions" value="link" placeholder="Blok gorunumu sec" />
                                            <x-ui.icon-picker name="icon" label="Ikon" :options="$linkIconOptions" value="" placeholder="Populer ikonlardan sec" />
                                        </div>
                                    </div>
                                </template>

                                <template x-if="createType === 'product'">
                                    <div class="space-y-5">
                                        <div class="space-y-2">
                                            <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Aciklama</label>
                                            <textarea name="description" rows="3" class="w-full resize-none rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="Urununuz icin kisa bir aciklama yazin."></textarea>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Gorsel Yukle</label>
                                                <input type="file" name="image_file" accept="image/png,image/jpeg,image/webp" class="block w-full rounded-2xl border border-input bg-background px-3 py-2 text-sm shadow-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Dis Gorsel URL</label>
                                                <input type="url" name="image_url" class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="https://...">
                                            </div>
                                            <div class="space-y-2 md:col-span-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Fiyat</label>
                                                <input type="text" name="price" class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="999 TL">
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <x-ui.icon-picker name="icon" label="Ikon" :options="$productIconOptions" value="" placeholder="Urun ikonunu sec" />
                                            <x-ui.picker name="button_type" label="Buton tipi" :options="$buttonTypeOptions" value="external_link" placeholder="Yonlendirme sec" change-event="picker-button-type-updated" />
                                        </div>

                                        <div class="space-y-2">
                                            <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground" x-text="buttonType === 'whatsapp' ? 'Telefon / WhatsApp linki' : 'Buton baglantisi'"></label>
                                            <input type="text" name="button_link" class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" :placeholder="buttonType === 'whatsapp' ? '905xxxxxxxxx veya https://wa.me/...' : 'https://example.com/urun'">
                                        </div>

                                        <template x-if="buttonType === 'whatsapp'">
                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Mesaj sablonu</label>
                                                <textarea name="whatsapp_message" rows="3" class="w-full resize-none rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="Merhaba, bu urun hakkinda bilgi almak istiyorum."></textarea>
                                            </div>
                                        </template>
                                    </div>
                                </template>

                                <label class="flex items-center justify-between rounded-2xl border border-border bg-muted/20 px-4 py-3 text-sm">
                                    <span class="font-medium">Bu blok aktif olsun</span>
                                    <button type="button" @click="active = !active" :class="active ? 'bg-primary' : 'bg-muted-foreground/30'" class="relative inline-flex h-6 w-11 rounded-full border-2 border-transparent transition-colors">
                                        <span :class="active ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 rounded-full bg-background shadow transition-transform"></span>
                                    </button>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-primary px-4 py-4 text-sm font-bold text-primary-foreground shadow-sm transition-opacity hover:opacity-90">
                            <i class="fas fa-plus text-xs"></i>
                            <span x-text="createType === 'link' ? 'Baglanti blokunu ekle' : 'Urun blokunu ekle'"></span>
                        </button>
                    </form>
                </div>

                <div x-show="activePanel === 'list'" x-cloak>
                    <div class="space-y-4" x-ref="sortableList">
                        @forelse($blocks as $block)
                            @php
                                $blockData = is_array($block->data) ? $block->data : [];
                                $iconValue = \App\Support\IconCatalog::normalizeClass($blockData['icon'] ?? ($block->sourceLink?->icon ?? '')) ?? '';
                                $summaryIcon = \App\Support\IconCatalog::normalizeClass($iconValue ?: ($block->type === 'product' ? 'fas fa-bag-shopping' : ($block->sourceLink?->icon_class ?? 'fas fa-link')));
                                $displayMode = $blockData['display_mode'] ?? ($block->type === 'link' ? 'link' : 'card');
                                $buttonType = $block->button_type ?? 'external_link';
                                $price = $blockData['price'] ?? '';
                                $message = $blockData['whatsapp_message'] ?? '';
                                $linkPreview = $block->sourceLink?->preview;
                                $previewDomain = $linkPreview ? parse_url($linkPreview->url, PHP_URL_HOST) : null;
                                $productImagePreview = $block->type === 'product' ? $block->image_url : null;
                                $remoteImageValue = ($block->image && filter_var($block->image, FILTER_VALIDATE_URL)) ? $block->image : '';
                                $showLinkFavicon = $block->type === 'link' && blank($iconValue) && filled($linkPreview?->favicon);
                                $summaryText = $block->type === 'product' ? ($block->description ?: ($price ?: 'Urun blogu')) : ($linkPreview?->description ?: ($previewDomain ?: ($block->url ?: 'Baglanti blogu')));
                            @endphp

                            <div data-id="{{ $block->id }}" class="block-item rounded-[28px] border border-border bg-background p-4 shadow-sm transition-all hover:border-ring/40" x-data="{ editing: false, blockType: '{{ $block->type }}', buttonType: '{{ $buttonType }}', active: {{ $block->is_active ? 'true' : 'false' }} }" @picker-button-type-updated="buttonType = $event.detail.value">
                                <div x-show="!editing" class="flex flex-col gap-4 md:flex-row md:items-center">
                                    <div class="flex items-center gap-4 md:min-w-0 md:flex-1">
                                        <div class="cursor-grab sort-handle rounded-2xl border border-border bg-muted/30 px-3 py-4 text-muted-foreground hover:text-foreground"><i class="fas fa-grip-vertical text-xs"></i></div>
                                        <div class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border border-border bg-muted/30 text-lg text-foreground">
                                            @if($productImagePreview)
                                                <img src="{{ $productImagePreview }}" alt="" class="h-full w-full object-cover" loading="lazy">
                                            @elseif($showLinkFavicon)
                                                <img src="{{ $linkPreview->favicon }}" alt="" class="h-7 w-7 object-contain" loading="lazy">
                                            @else
                                                <i class="{{ $summaryIcon }}"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <h4 class="truncate text-base font-semibold" :class="active ? '' : 'opacity-50 line-through'">{{ $block->title }}</h4>
                                                <span class="rounded-full border border-border bg-muted/40 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-muted-foreground">{{ $block->type === 'product' ? 'Urun' : 'Baglanti' }}</span>
                                                @if($block->type === 'link')
                                                    <span class="rounded-full border border-border bg-background px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-muted-foreground">{{ $displayMode === 'card' ? 'Kart' : 'Link' }}</span>
                                                @endif
                                                <span x-show="!active" x-cloak class="rounded-full border border-amber-200 bg-amber-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-amber-700">Pasif</span>
                                            </div>
                                            <p class="mt-1 truncate text-sm text-muted-foreground">{{ $summaryText }}</p>
                                        </div>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-2">
                                        <button @click="toggleBlock({{ $block->id }}, (nextState) => { active = nextState; })" type="button" :class="active ? 'bg-primary' : 'bg-muted'" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                                            <span :class="active ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                                        </button>
                                        <button @click="editing = true" type="button" class="rounded-xl border border-border px-4 py-2 text-sm font-semibold text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">Duzenle</button>
                                        <form method="post" action="{{ route('blocks.destroy', $block) }}" onsubmit="return confirm('Bu blogu silmek istediginize emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl border border-destructive/20 px-4 py-2 text-sm font-semibold text-destructive transition-colors hover:bg-destructive/5">Sil</button>
                                        </form>
                                    </div>
                                </div>

                                <form x-show="editing" x-cloak method="post" action="{{ route('blocks.update', $block) }}" enctype="multipart/form-data" class="space-y-5">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="type" :value="blockType">
                                    <input type="hidden" name="is_active" :value="active ? 1 : 0">

                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Baslik</label>
                                            <input type="text" name="title" value="{{ $block->title }}" required class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                        </div>
                                        <div class="space-y-3">
                                            <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Blok tipi</label>
                                            <div class="grid grid-cols-2 gap-3">
                                                <button type="button" @click="blockType = 'link'" :class="blockType === 'link' ? 'border-primary bg-primary/5 text-primary' : 'border-border text-muted-foreground'" class="rounded-2xl border px-4 py-3 text-sm font-semibold transition-colors"><i class="fas fa-link mr-2 text-xs"></i> Baglanti</button>
                                                <button type="button" @click="blockType = 'product'" :class="blockType === 'product' ? 'border-primary bg-primary/5 text-primary' : 'border-border text-muted-foreground'" class="rounded-2xl border px-4 py-3 text-sm font-semibold transition-colors"><i class="fas fa-bag-shopping mr-2 text-xs"></i> Urun</button>
                                            </div>
                                        </div>
                                        <label class="flex items-center justify-between rounded-2xl border border-border bg-muted/20 px-4 py-3 text-sm">
                                            <span class="font-medium">Bu blok aktif</span>
                                            <button type="button" @click="active = !active" :class="active ? 'bg-primary' : 'bg-muted-foreground/30'" class="relative inline-flex h-6 w-11 rounded-full border-2 border-transparent transition-colors">
                                                <span :class="active ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 rounded-full bg-background shadow transition-transform"></span>
                                            </button>
                                        </label>
                                    </div>

                                    <template x-if="blockType === 'link'">
                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div class="space-y-2 md:col-span-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">URL</label>
                                                <input type="url" name="url" value="{{ $block->url }}" class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            </div>
                                            <x-ui.picker name="display_mode" label="Blok yapisi" :options="$displayModeOptions" :value="$displayMode" placeholder="Blok gorunumu sec" />
                                            <x-ui.icon-picker name="icon" label="Ikon" :options="$linkIconOptions" :value="$iconValue" placeholder="Populer ikonlardan sec" />
                                        </div>
                                    </template>

                                    <template x-if="blockType === 'product'">
                                        <div class="space-y-4">
                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Aciklama</label>
                                                <textarea name="description" rows="3" class="w-full resize-none rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">{{ $block->description }}</textarea>
                                            </div>

                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Gorsel Yukle</label>
                                                    <input type="file" name="image_file" accept="image/png,image/jpeg,image/webp" class="block w-full rounded-2xl border border-input bg-background px-3 py-2 text-sm shadow-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary">
                                                </div>
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Dis Gorsel URL</label>
                                                    <input type="url" name="image_url" value="{{ $remoteImageValue }}" class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="https://...">
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Fiyat</label>
                                                    <input type="text" name="price" value="{{ $price }}" class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                                </div>
                                                @if($productImagePreview)
                                                    <label class="flex items-center justify-between rounded-2xl border border-border bg-muted/20 px-4 py-3 text-sm">
                                                        <span class="font-medium">Gorseli kaldir</span>
                                                        <input type="checkbox" name="remove_image" value="1" class="rounded border-border text-primary focus:ring-primary">
                                                    </label>
                                                @endif
                                            </div>

                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                <x-ui.icon-picker name="icon" label="Ikon" :options="$productIconOptions" :value="$iconValue" placeholder="Urun ikonunu sec" />
                                                <x-ui.picker name="button_type" label="Buton tipi" :options="$buttonTypeOptions" :value="$buttonType" placeholder="Yonlendirme sec" change-event="picker-button-type-updated" />
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground" x-text="buttonType === 'whatsapp' ? 'Telefon / WhatsApp linki' : 'Buton baglantisi'"></label>
                                                <input type="text" name="button_link" value="{{ $block->button_link }}" class="w-full rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            </div>

                                            <template x-if="buttonType === 'whatsapp'">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Mesaj sablonu</label>
                                                    <textarea name="whatsapp_message" rows="3" class="w-full resize-none rounded-2xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">{{ $message }}</textarea>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <div class="flex items-center justify-end gap-3 border-t border-border pt-4">
                                        <button type="button" @click="editing = false" class="rounded-2xl border border-border px-4 py-2 text-sm font-semibold text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">Vazgec</button>
                                        <button type="submit" class="rounded-2xl bg-primary px-4 py-2 text-sm font-bold text-primary-foreground transition-opacity hover:opacity-90">Kaydet</button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <div class="rounded-[28px] border border-dashed border-border bg-muted/10 p-12 text-center">
                                <i class="fas fa-layer-group mb-4 text-3xl text-muted-foreground/30"></i>
                                <h3 class="text-sm font-semibold">Henuz blok yok</h3>
                                <p class="mt-1 text-xs text-muted-foreground">Yeni Blok sekmesinden ilk blokunuzu olusturun.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endunless
</div>

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                if (!Alpine.data('pickerField')) {
                    Alpine.data('pickerField', (config = {}) => ({
                        open: false,
                        search: '',
                        value: String(config.value ?? ''),
                        options: Array.isArray(config.options) ? config.options : [],
                        placeholder: config.placeholder ?? 'Secim yapin',
                        hint: config.hint ?? '',
                        searchable: Boolean(config.searchable),
                        changeEvent: config.changeEvent ?? null,
                        selectedOption() {
                            return this.options.find((option) => String(option.value ?? '') === this.value) ?? this.options[0] ?? null;
                        },
                        filteredOptions() {
                            const term = this.search.trim().toLowerCase();
                            if (!term) return this.options;
                            return this.options.filter((option) => [option.label, option.hint, option.value].filter(Boolean).some((field) => String(field).toLowerCase().includes(term)));
                        },
                        select(nextValue) {
                            this.value = String(nextValue ?? '');
                            this.close();
                            if (this.changeEvent) {
                                this.$dispatch(this.changeEvent, { value: this.value, option: this.selectedOption() });
                            }
                        },
                        close() {
                            this.open = false;
                            this.search = '';
                        },
                    }));
                }

                if (!Alpine.data('blocksManager')) {
                    Alpine.data('blocksManager', (config = {}) => ({
                        activePanel: config.initialPanel ?? 'create',
                        sortable: null,
                        init() {
                            this.$nextTick(() => this.ensureSortable());
                        },
                        showPanel(panel) {
                            this.activePanel = panel;
                            this.$nextTick(() => this.ensureSortable());
                        },
                        ensureSortable() {
                            const el = this.$refs.sortableList;
                            if (!el || typeof Sortable === 'undefined' || this.sortable) return;
                            this.sortable = Sortable.create(el, {
                                handle: '.sort-handle',
                                animation: 180,
                                ghostClass: 'opacity-40',
                                onEnd: () => this.reorderBlocks(el),
                            });
                        },
                        async reorderBlocks(el) {
                            const orderedIds = Array.from(el.querySelectorAll('.block-item')).map((item) => item.dataset.id).filter(Boolean);
                            await fetch('{{ route('blocks.reorder') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({ ordered_ids: orderedIds }),
                            });
                            window.dispatchEvent(new CustomEvent('blocks-updated'));
                        },
                        async toggleBlock(id, onSuccess) {
                            const response = await fetch(`/blocks/${id}/toggle`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            });
                            const data = await response.json();
                            if (data?.success) {
                                if (typeof onSuccess === 'function') onSuccess(data.is_active);
                                window.dispatchEvent(new CustomEvent('blocks-updated'));
                            }
                        },
                    }));
                }
            });
        </script>
    @endpush
@endonce
