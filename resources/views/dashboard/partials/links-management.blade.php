<div x-data="blocksManager()">
    <x-section-header
        :title="__('Bloklar')"
        :subtitle="__('Link ve urun bloklarinizi tek bir yerden yonetin, siralayin ve yayinlayin.')"
    />

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-lg border border-destructive/20 bg-destructive/5 px-4 py-3 text-sm text-destructive">
            {{ session('error') }}
        </div>
    @endif

    @unless($blocks_ready)
        <div class="rounded-lg border border-amber-200 bg-amber-50 p-5 text-sm text-amber-800">
            <p class="font-semibold">V2 block sistemi hazir ama veritabani migration bekliyor.</p>
            <p class="mt-1 opacity-80">Devam etmeden once <code>php artisan migrate</code> calistirin.</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 xl:grid-cols-[360px_minmax(0,1fr)]">
            <div class="space-y-6">
                <form method="post" action="{{ route('blocks.store') }}" enctype="multipart/form-data" class="rounded-lg border border-border bg-card shadow-sm" x-data="{ createType: 'link', buttonType: 'external_link', active: true }">
                    @csrf
                    <div class="border-b border-border p-6">
                        <h3 class="text-lg font-semibold">Yeni Blok</h3>
                        <p class="mt-1 text-sm text-muted-foreground">Yeni bir baglanti ya da urun bloku ekleyin.</p>
                    </div>

                    <div class="space-y-5 p-6">
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" @click="createType = 'link'" :class="createType === 'link' ? 'border-primary bg-primary/5 text-primary' : 'border-border text-muted-foreground'" class="rounded-xl border px-4 py-3 text-sm font-semibold transition-colors">
                                <i class="fas fa-link mr-2 text-xs"></i> Baglanti
                            </button>
                            <button type="button" @click="createType = 'product'" :class="createType === 'product' ? 'border-primary bg-primary/5 text-primary' : 'border-border text-muted-foreground'" class="rounded-xl border px-4 py-3 text-sm font-semibold transition-colors">
                                <i class="fas fa-bag-shopping mr-2 text-xs"></i> Urun
                            </button>
                        </div>

                        <input type="hidden" name="type" :value="createType">
                        <input type="hidden" name="is_active" :value="active ? 1 : 0">

                        <div class="space-y-2">
                            <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Baslik</label>
                            <input type="text" name="title" required class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="Orn: Portfolyom">
                        </div>

                        <template x-if="createType === 'link'">
                            <div class="space-y-5">
                                <div class="space-y-2">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">URL</label>
                                    <input type="url" name="url" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="https://example.com">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Ikon</label>
                                    <select name="icon" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                        <option value="">Otomatik sec</option>
                                        <option value="fab fa-instagram">Instagram</option>
                                        <option value="fab fa-twitter">X / Twitter</option>
                                        <option value="fab fa-youtube">YouTube</option>
                                        <option value="fab fa-whatsapp">WhatsApp</option>
                                        <option value="fab fa-github">GitHub</option>
                                        <option value="fab fa-linkedin">LinkedIn</option>
                                        <option value="fab fa-tiktok">TikTok</option>
                                        <option value="fas fa-link">Standart Link</option>
                                        <option value="fas fa-envelope">E-posta</option>
                                        <option value="fas fa-phone">Telefon</option>
                                    </select>
                                </div>
                            </div>
                        </template>

                        <template x-if="createType === 'product'">
                            <div class="space-y-5">
                                <div class="space-y-2">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Aciklama</label>
                                    <textarea name="description" rows="3" class="w-full resize-none rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="Urununuz icin kisa bir aciklama yazin."></textarea>
                                </div>

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Gorsel Yukle</label>
                                        <input type="file" name="image_file" accept="image/png,image/jpeg,image/webp" class="block w-full rounded-xl border border-input bg-background px-3 py-2 text-sm shadow-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Dis Gorsel URL</label>
                                        <input type="url" name="image_url" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="https://...">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Fiyat</label>
                                        <input type="text" name="price" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="999 TL">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Ikon</label>
                                        <select name="icon" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            <option value="">Varsayilan urun ikonu</option>
                                            <option value="fas fa-bag-shopping">Alisveris</option>
                                            <option value="fas fa-shirt">Moda</option>
                                            <option value="fas fa-mobile-screen">Teknoloji</option>
                                            <option value="fas fa-gem">Premium</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Buton tipi</label>
                                        <select name="button_type" x-model="buttonType" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            <option value="external_link">Dis baglanti</option>
                                            <option value="whatsapp">WhatsApp</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground" x-text="buttonType === 'whatsapp' ? 'Telefon / WhatsApp linki' : 'Buton baglantisi'"></label>
                                    <input type="text" name="button_link" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" :placeholder="buttonType === 'whatsapp' ? '905xxxxxxxxx veya https://wa.me/...' : 'https://example.com/urun'">
                                </div>

                                <template x-if="buttonType === 'whatsapp'">
                                    <div class="space-y-2">
                                        <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Mesaj sablonu</label>
                                        <textarea name="whatsapp_message" rows="3" class="w-full resize-none rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="Merhaba, bu urun hakkinda bilgi almak istiyorum."></textarea>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <label class="flex items-center justify-between rounded-xl border border-border bg-muted/20 px-4 py-3 text-sm">
                            <span class="font-medium">Bu blok aktif olsun</span>
                            <input type="checkbox" x-model="active" class="rounded border-border text-primary focus:ring-primary">
                        </label>
                    </div>

                    <div class="border-t border-border px-6 py-4">
                        <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-primary px-4 py-3 text-sm font-bold text-primary-foreground shadow-sm transition-opacity hover:opacity-90">
                            <i class="fas fa-plus text-xs"></i>
                            <span x-text="createType === 'link' ? 'Baglanti bloku ekle' : 'Urun bloku ekle'"></span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="rounded-lg border border-border bg-card shadow-sm">
                <div class="flex items-center justify-between border-b border-border p-6">
                    <div>
                        <h3 class="text-lg font-semibold">Blok Listesi</h3>
                        <p class="mt-1 text-sm text-muted-foreground">Bloklari surukleyip birakarak siralayabilirsiniz.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <form method="post" action="{{ route('blocks.previews.refresh') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-full border border-border bg-background px-3 py-2 text-xs font-semibold text-foreground transition-colors hover:bg-muted">
                                <i class="fas fa-rotate text-[10px]"></i>
                                Previewleri Yenile
                            </button>
                        </form>
                        <div class="rounded-full border border-border bg-muted/30 px-3 py-1 text-xs font-semibold text-muted-foreground">
                            {{ $blocks->count() }} blok
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div x-ref="sortableList" class="space-y-4">
                        @forelse($blocks as $block)
                            @php
                                $blockData = is_array($block->data) ? $block->data : [];
                                $iconValue = $blockData['icon'] ?? ($block->sourceLink?->icon ?? '');
                                $summaryIcon = $iconValue ?: ($block->type === 'product' ? 'fas fa-bag-shopping' : ($block->sourceLink?->icon_class ?? 'fas fa-link'));
                                $buttonType = $block->button_type ?? 'external_link';
                                $price = $blockData['price'] ?? '';
                                $message = $blockData['whatsapp_message'] ?? '';
                                $linkPreview = $block->sourceLink?->preview;
                                $previewDomain = $linkPreview ? parse_url($linkPreview->url, PHP_URL_HOST) : null;
                                $productImagePreview = $block->type === 'product' ? $block->image_url : null;
                                $remoteImageValue = ($block->image && filter_var($block->image, FILTER_VALIDATE_URL)) ? $block->image : '';
                                $summaryText = $block->type === 'product'
                                    ? ($block->description ?: ($price ?: 'Urun blogu'))
                                    : ($linkPreview?->description ?: ($previewDomain ?: ($block->url ?: 'Baglanti blogu')));
                            @endphp

                            <div data-id="{{ $block->id }}" class="block-item rounded-2xl border border-border bg-background/80 p-4 shadow-sm transition-all hover:border-ring/40" x-data="{ editing: false, blockType: '{{ $block->type }}', buttonType: '{{ $buttonType }}', active: {{ $block->is_active ? 'true' : 'false' }} }">
                                <div x-show="!editing" class="flex items-start gap-4">
                                    <div class="cursor-grab sort-handle rounded-xl border border-border bg-muted/30 px-3 py-3 text-muted-foreground hover:text-foreground">
                                        <i class="fas fa-grip-vertical text-xs"></i>
                                    </div>

                                    <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-2xl border border-border bg-muted/30 text-lg text-foreground">
                                        @if($productImagePreview)
                                            <img src="{{ $productImagePreview }}" alt="" class="h-full w-full object-cover" loading="lazy">
                                        @elseif($block->type === 'link' && $linkPreview?->favicon)
                                            <img src="{{ $linkPreview->favicon }}" alt="" class="h-6 w-6 object-contain" loading="lazy">
                                        @else
                                            <i class="{{ $summaryIcon }}"></i>
                                        @endif
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h4 class="truncate text-sm font-semibold" :class="active ? '' : 'opacity-50 line-through'">{{ $block->title }}</h4>
                                            <span class="rounded-full border border-border bg-muted/40 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-muted-foreground">
                                                {{ $block->type === 'product' ? 'Urun' : 'Baglanti' }}
                                            </span>
                                            <span x-show="!active" x-cloak class="rounded-full border border-amber-200 bg-amber-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-widest text-amber-700">
                                                Pasif
                                            </span>
                                        </div>
                                        <p class="mt-1 truncate text-xs text-muted-foreground">{{ $summaryText }}</p>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <button @click="toggleBlock({{ $block->id }}, (nextState) => { active = nextState; })" type="button" :class="active ? 'bg-primary' : 'bg-muted'" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors">
                                            <span :class="active ? 'translate-x-6' : 'translate-x-1'" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                                        </button>
                                        <button @click="editing = true" type="button" class="rounded-lg border border-border px-3 py-2 text-xs font-semibold text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
                                            Duzenle
                                        </button>
                                        <form method="post" action="{{ route('blocks.destroy', $block) }}" onsubmit="return confirm('Bu blogu silmek istediginize emin misiniz?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg border border-destructive/20 px-3 py-2 text-xs font-semibold text-destructive transition-colors hover:bg-destructive/5">
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <form x-show="editing" x-cloak method="post" action="{{ route('blocks.update', $block) }}" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="type" :value="blockType">
                                    <input type="hidden" name="is_active" :value="active ? 1 : 0">

                                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Baslik</label>
                                            <input type="text" name="title" value="{{ $block->title }}" required class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                        </div>

                                        <div class="space-y-2">
                                            <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Blok tipi</label>
                                            <select x-model="blockType" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                                <option value="link">Baglanti</option>
                                                <option value="product">Urun</option>
                                            </select>
                                        </div>

                                        <label class="flex items-center justify-between rounded-xl border border-border bg-muted/20 px-4 py-3 text-sm">
                                            <span class="font-medium">Aktif</span>
                                            <input type="checkbox" x-model="active" class="rounded border-border text-primary focus:ring-primary">
                                        </label>
                                    </div>

                                    <template x-if="blockType === 'link'">
                                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                            <div class="space-y-2 md:col-span-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">URL</label>
                                                <input type="url" name="url" value="{{ $block->url }}" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Ikon</label>
                                                <select name="icon" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                                    <option value="" @selected($iconValue === '')>Otomatik sec</option>
                                                    <option value="fab fa-instagram" @selected($iconValue === 'fab fa-instagram')>Instagram</option>
                                                    <option value="fab fa-twitter" @selected($iconValue === 'fab fa-twitter')>X / Twitter</option>
                                                    <option value="fab fa-youtube" @selected($iconValue === 'fab fa-youtube')>YouTube</option>
                                                    <option value="fab fa-whatsapp" @selected($iconValue === 'fab fa-whatsapp')>WhatsApp</option>
                                                    <option value="fab fa-github" @selected($iconValue === 'fab fa-github')>GitHub</option>
                                                    <option value="fab fa-linkedin" @selected($iconValue === 'fab fa-linkedin')>LinkedIn</option>
                                                    <option value="fas fa-link" @selected($iconValue === 'fas fa-link')>Standart Link</option>
                                                    <option value="fas fa-envelope" @selected($iconValue === 'fas fa-envelope')>E-posta</option>
                                                    <option value="fas fa-phone" @selected($iconValue === 'fas fa-phone')>Telefon</option>
                                                </select>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="blockType === 'product'">
                                        <div class="space-y-4">
                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Aciklama</label>
                                                <textarea name="description" rows="3" class="w-full resize-none rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">{{ $block->description }}</textarea>
                                            </div>

                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Gorsel Yukle</label>
                                                    <input type="file" name="image_file" accept="image/png,image/jpeg,image/webp" class="block w-full rounded-xl border border-input bg-background px-3 py-2 text-sm shadow-sm file:mr-3 file:rounded-lg file:border-0 file:bg-primary/10 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-primary">
                                                </div>
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Dis Gorsel URL</label>
                                                    <input type="url" name="image_url" value="{{ $remoteImageValue }}" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary" placeholder="https://...">
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Fiyat</label>
                                                    <input type="text" name="price" value="{{ $price }}" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                                </div>
                                                @if($productImagePreview)
                                                    <label class="flex items-center justify-between rounded-xl border border-border bg-muted/20 px-4 py-3 text-sm">
                                                        <span class="font-medium">Gorseli kaldir</span>
                                                        <input type="checkbox" name="remove_image" value="1" class="rounded border-border text-primary focus:ring-primary">
                                                    </label>
                                                @endif
                                            </div>

                                            @if($productImagePreview)
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Mevcut Gorsel</label>
                                                    <div class="overflow-hidden rounded-2xl border border-border bg-muted/20">
                                                        <img src="{{ $productImagePreview }}" alt="{{ $block->title }}" class="h-40 w-full object-cover">
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Ikon</label>
                                                    <select name="icon" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                                        <option value="" @selected($iconValue === '')>Varsayilan urun ikonu</option>
                                                        <option value="fas fa-bag-shopping" @selected($iconValue === 'fas fa-bag-shopping')>Alisveris</option>
                                                        <option value="fas fa-shirt" @selected($iconValue === 'fas fa-shirt')>Moda</option>
                                                        <option value="fas fa-mobile-screen" @selected($iconValue === 'fas fa-mobile-screen')>Teknoloji</option>
                                                        <option value="fas fa-gem" @selected($iconValue === 'fas fa-gem')>Premium</option>
                                                    </select>
                                                </div>
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Buton tipi</label>
                                                    <select name="button_type" x-model="buttonType" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                                        <option value="external_link" @selected($buttonType === 'external_link')>Dis baglanti</option>
                                                        <option value="whatsapp" @selected($buttonType === 'whatsapp')>WhatsApp</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground" x-text="buttonType === 'whatsapp' ? 'Telefon / WhatsApp linki' : 'Buton baglantisi'"></label>
                                                <input type="text" name="button_link" value="{{ $block->button_link }}" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
                                            </div>

                                            <template x-if="buttonType === 'whatsapp'">
                                                <div class="space-y-2">
                                                    <label class="text-xs font-semibold uppercase tracking-widest text-muted-foreground">Mesaj sablonu</label>
                                                    <textarea name="whatsapp_message" rows="3" class="w-full resize-none rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">{{ $message }}</textarea>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <div class="flex items-center justify-end gap-3 border-t border-border pt-4">
                                        <button type="button" @click="editing = false" class="rounded-xl border border-border px-4 py-2 text-sm font-semibold text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
                                            Vazgec
                                        </button>
                                        <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-sm font-bold text-primary-foreground transition-opacity hover:opacity-90">
                                            Kaydet
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-border bg-muted/10 p-12 text-center">
                                <i class="fas fa-layer-group mb-4 text-3xl text-muted-foreground/30"></i>
                                <h3 class="text-sm font-semibold">Henuz blok yok</h3>
                                <p class="mt-1 text-xs text-muted-foreground">Soldaki form ile ilk blokunuzu olusturun.</p>
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
                if (!Alpine.data('blocksManager')) {
                    Alpine.data('blocksManager', () => ({
                        init() {
                            const el = this.$refs.sortableList;
                            if (!el || typeof Sortable === 'undefined') {
                                return;
                            }

                            Sortable.create(el, {
                                handle: '.sort-handle',
                                animation: 180,
                                ghostClass: 'opacity-40',
                                onEnd: () => this.reorderBlocks(el),
                            });
                        },

                        async reorderBlocks(el) {
                            const orderedIds = Array.from(el.querySelectorAll('.block-item'))
                                .map((item) => item.dataset.id)
                                .filter(Boolean);

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
                                if (typeof onSuccess === 'function') {
                                    onSuccess(data.is_active);
                                }

                                window.dispatchEvent(new CustomEvent('blocks-updated'));
                            }
                        },
                    }));
                }
            });
        </script>
    @endpush
@endonce
