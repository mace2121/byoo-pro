<div x-data="linksManager()">
    <!-- Header -->
    <x-section-header 
        :title="__('Linklerim')" 
        :subtitle="__('Sayfanızda görünecek olan tüm bağlantıları buradan yönetebilirsiniz.')" 
    />

    <!-- Link Ekle Formu (Card) -->
    <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm mb-10 overflow-hidden">
        <div class="p-6 border-b border-[hsl(var(--border))]">
            <h3 class="text-lg font-semibold leading-none tracking-tight">{{ __('Yeni Link Ekle') }}</h3>
            <p class="text-sm text-[hsl(var(--muted-foreground))] mt-1.5">{{ __('Bağlantı başlığını ve linkini girerek anında yayına alın.') }}</p>
        </div>
        <div class="p-6">
            <form method="post" action="{{ route('links.store') }}" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                    <div class="md:col-span-4">
                        <x-input-label for="title" :value="__('Başlık')" class="text-xs font-medium mb-1.5" />
                        <x-text-input id="title" name="title" type="text" placeholder="Örn: Portfolyom" required />
                    </div>
                    <div class="md:col-span-5">
                        <x-input-label for="url" :value="__('URL (Bağlantı)')" class="text-xs font-medium mb-1.5" />
                        <x-text-input id="url" name="url" type="url" placeholder="https://example.com" required @input="detectPlatform($event.target.value)" />
                    </div>
                    <div class="md:col-span-2">
                        <x-input-label for="icon" :value="__('İkon')" class="text-xs font-medium mb-1.5" />
                        <div class="relative">
                            <button type="button" @click.stop="showIconsList = !showIconsList" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm transition-colors hover:bg-accent flex items-center justify-center text-[hsl(var(--muted-foreground))]">
                                <template x-if="newIcon"><i :class="newIcon"></i></template>
                                <template x-if="!newIcon"><i class="fas fa-icons"></i></template>
                                <i class="fas fa-chevron-down ml-2 text-[10px] opacity-20"></i>
                            </button>
                            <input type="hidden" name="icon" x-model="newIcon">
                            
                            <!-- Icon Picker Dropdown -->
                            <div x-show="showIconsList" @click.away="showIconsList = false" class="absolute z-50 mt-2 p-2 bg-[hsl(var(--popover))] text-[hsl(var(--popover-foreground))] rounded-md shadow-md border border-border grid grid-cols-4 gap-1 w-48 max-h-60 overflow-y-auto" x-cloak>
                                <template x-for="iconItem in iconOptions">
                                    <button type="button" @click="newIcon = iconItem; showIconsList = false" class="inline-flex items-center justify-center rounded-sm p-2 text-sm font-medium hover:bg-accent hover:text-accent-foreground transition-all">
                                        <i :class="iconItem"></i>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-1">
                        <x-primary-button class="w-full">{{ __('Ekle') }}</x-primary-button>
                    </div>
                </div>

                <!-- Advanced Settings Toggle -->
                <div x-data="{ open: false }" class="pt-4 border-t border-[hsl(var(--border))]">
                    <button type="button" @click="open = !open" class="text-xs text-[hsl(var(--muted-foreground))] hover:text-foreground font-medium flex items-center gap-1 transition-colors">
                        <i class="fas h-3 w-3 transition-transform" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                        {{ __('Gelişmiş Seçenekler') }}
                    </button>
                    
                    <div x-show="open" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4 p-4 rounded-md border border-[hsl(var(--border))] bg-[hsl(var(--muted))]">
                        <div class="space-y-1.5">
                            <x-input-label for="starts_at" :value="__('Başlangıç')" class="text-xs font-medium" />
                            <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="bg-card" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="expires_at" :value="__('Bitiş')" class="text-xs font-medium" />
                            <x-text-input id="expires_at" name="expires_at" type="datetime-local" class="bg-card" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label for="password" :value="__('Şifre')" class="text-xs font-medium" />
                            <x-text-input id="password" name="password" type="text" class="bg-card" :placeholder="__('Opsiyonel')" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Link Listesi (Sortable) -->
    <div x-ref="sortableList" class="space-y-3">
        @forelse($links as $link)
            <div class="flex items-center gap-4 bg-[hsl(var(--card))] p-3 rounded-lg border border-[hsl(var(--border))] shadow-sm link-item relative group hover:border-[hsl(var(--ring))] transition-all duration-200" data-id="{{ $link->id }}">
                
                <!-- Drag Handle -->
                <div class="cursor-grab sort-handle text-[hsl(var(--muted-foreground))] hover:text-foreground transition-colors p-2">
                    <i class="fas fa-grip-vertical text-xs"></i>
                </div>

                <!-- Icon -->
                <div class="flex items-center justify-center w-10 h-10 rounded-md border border-[hsl(var(--border))] bg-[hsl(var(--muted))] text-[hsl(var(--muted-foreground))] flex-shrink-0">
                    <i class="{{ $link->icon_class }} text-lg"></i>
                </div>

                <div class="flex-1 flex items-center justify-between" x-data="{ editing: false, active: {{ $link->is_active ? 'true' : 'false' }} }">
                    <div x-show="!editing" class="flex-1 min-w-0 pr-4">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-semibold truncate" :class="{ 'opacity-40 line-through font-normal': !active }">{{ $link->title }}</p>
                            @if($link->starts_at || $link->expires_at)
                                <i class="fas fa-calendar-alt text-[10px] text-primary" title="{{ __('Planlı') }}"></i>
                            @endif
                        </div>
                        <p class="text-xs text-[hsl(var(--muted-foreground))] truncate mt-0.5">{{ str_replace(['https://','http://'], '', $link->url) }}</p>
                    </div>

                    <div x-show="!editing" class="flex items-center gap-3">
                        <div class="text-[10px] font-medium text-[hsl(var(--muted-foreground))] px-2 py-0.5 bg-[hsl(var(--muted))] rounded shadow-inner">
                            {{ $link->clicks }} {{ __('click') }}
                        </div>

                        <!-- Toggle Switch -->
                        <button @click="toggleLink({{ $link->id }}, active); active = !active" 
                                :class="active ? 'bg-primary' : 'bg-[hsl(var(--muted))]'" 
                                class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-1 focus:ring-ring">
                            <span aria-hidden="true" :class="active ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow-lg ring-0 transition duration-200"></span>
                        </button>
                        
                        <!-- Actions -->
                        <div class="flex items-center border-l border-[hsl(var(--border))] pl-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button @click="editing = true" class="p-1.5 text-[hsl(var(--muted-foreground))] hover:text-foreground transition-colors">
                                <i class="fas fa-pencil-alt text-[10px]"></i>
                            </button>
                            <form method="post" action="{{ route('links.destroy', $link) }}" onsubmit="return confirm('{{ __('Emin misiniz?') }}');">
                                @csrf @method('delete')
                                <button type="submit" class="p-1.5 text-[hsl(var(--muted-foreground))] hover:text-destructive transition-colors">
                                    <i class="fas fa-trash-alt text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Edit Mode (Simplified for compact feel) -->
                    <form @submit="editing = false" x-show="editing" method="post" action="{{ route('links.update', $link) }}" class="flex-1 flex flex-col md:flex-row gap-2" x-cloak>
                        @csrf @method('put')
                        <x-text-input name="title" value="{{ $link->title }}" required class="h-8 text-xs" />
                        <x-text-input name="url" value="{{ $link->url }}" type="url" required class="h-8 text-xs" />
                        <div class="flex gap-1">
                            <button type="submit" class="p-1.5 bg-primary text-primary-foreground rounded hover:opacity-90"><i class="fas fa-check text-[10px]"></i></button>
                            <button type="button" @click="editing = false" class="p-1.5 bg-[hsl(var(--muted))] text-[hsl(var(--muted-foreground))] rounded hover:text-foreground"><i class="fas fa-times text-[10px]"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-lg border border-dashed border-[hsl(var(--border))] p-12 text-center bg-[hsl(var(--muted))] /10">
                <i class="fas fa-link text-3xl text-[hsl(var(--muted-foreground))] mb-4 opacity-20"></i>
                <h3 class="text-sm font-semibold">{{ __('Henüz bağlantı bulunmuyor') }}</h3>
                <p class="text-xs text-[hsl(var(--muted-foreground))] mt-1">{{ __('İlk bağlantınızı eklemek için yukarıdaki formu kullanın.') }}</p>
            </div>
        @endforelse
    </div>
</div>
</div>

@once
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            if (!Alpine.data('linksManager')) {
                Alpine.data('linksManager', () => ({
                    newIcon: '',
                    showIconsList: false,
                    iconOptions: [
                        'fab fa-instagram', 'fab fa-twitter', 'fab fa-facebook', 'fab fa-linkedin', 
                        'fab fa-youtube', 'fab fa-tiktok', 'fab fa-whatsapp', 'fab fa-github', 
                        'fab fa-telegram', 'fas fa-link', 'fas fa-envelope', 'fas fa-phone',
                        'fas fa-globe', 'fas fa-shopping-cart', 'fas fa-music', 'fas fa-video',
                        'fab fa-discord', 'fab fa-spotify', 'fab fa-twitch', 'fab fa-medium'
                    ],
                    init() {
                        let el = this.$refs.sortableList;
                        if(el) {
                            Sortable.create(el, {
                                handle: '.sort-handle',
                                animation: 200,
                                ghostClass: 'opacity-20',
                                onEnd: (evt) => {
                                    let items = el.querySelectorAll('.link-item');
                                    let orderedIds = Array.from(items).map(item => item.dataset.id);
                                    
                                    fetch('{{ route("links.reorder") }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ ordered_ids: orderedIds })
                                    }).then(() => {
                                        window.dispatchEvent(new CustomEvent('links-updated'));
                                    });
                                }
                            });
                        }
                    },
                    detectPlatform(url) {
                        url = url.toLowerCase();
                        if (url.includes('instagram.com')) this.newIcon = 'fab fa-instagram';
                        else if (url.includes('twitter.com') || url.includes('x.com')) this.newIcon = 'fab fa-twitter';
                        else if (url.includes('facebook.com') || url.includes('fb.com')) this.newIcon = 'fab fa-facebook';
                        else if (url.includes('linkedin.com')) this.newIcon = 'fab fa-linkedin';
                        else if (url.includes('youtube.com') || url.includes('youtu.be')) this.newIcon = 'fab fa-youtube';
                        else if (url.includes('tiktok.com')) this.newIcon = 'fab fa-tiktok';
                        else if (url.includes('whatsapp.com') || url.includes('wa.me')) this.newIcon = 'fab fa-whatsapp';
                        else if (url.includes('github.com')) this.newIcon = 'fab fa-github';
                        else if (url.includes('t.me') || url.includes('telegram.org')) this.newIcon = 'fab fa-telegram';
                        else if (url.includes('discord.')) this.newIcon = 'fab fa-discord';
                        else if (url.includes('spotify.')) this.newIcon = 'fab fa-spotify';
                        else if (url.includes('twitch.')) this.newIcon = 'fab fa-twitch';
                        else if (url.length > 5 && !this.newIcon) this.newIcon = 'fas fa-link';
                    },
                    toggleLink(id, isActive) {
                        fetch(`/links/${id}/toggle`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(() => {
                            window.dispatchEvent(new CustomEvent('links-updated'));
                        });
                    }
                }))
            }
        });
    </script>
    @endpush
@endonce
