<div x-data="linksManager()">
    <!-- Header -->
    <x-section-header 
        :title="__('Linklerim')" 
        :subtitle="__('Sayfanızda görünecek olan tüm bağlantıları buradan yönetebilirsiniz.')" 
    />

    <!-- Link Ekle Formu -->
    <div class="mb-10 p-2 sm:p-0">
        <header class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-plus-circle text-black dark:text-white"></i>
                <h2 class="text-xs font-black text-gray-900 dark:text-gray-100 uppercase tracking-widest">{{ __('Yeni Link Ekle') }}</h2>
            </div>
        </header>
        <div class="p-6 bg-white dark:bg-black rounded-3xl border border-gray-100 dark:border-gray-800">
            <form method="post" action="{{ route('links.store') }}" class="space-y-4">
                @csrf
                <div class="flex flex-col md:flex-row gap-5 items-end">
                    <div class="w-full md:flex-1">
                        <x-input-label for="title" :value="__('Başlık')" class="text-[10px] font-black uppercase text-gray-400" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full rounded-2xl border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 focus:ring-black focus:border-black" placeholder="Örn: Web Sitem" required />
                    </div>
                    <div class="w-full md:flex-1">
                        <x-input-label for="url" :value="__('URL (Bağlantı)')" class="text-[10px] font-black uppercase text-gray-400" />
                        <x-text-input id="url" name="url" type="url" class="mt-1 block w-full rounded-2xl border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 focus:ring-black focus:border-black" placeholder="https://example.com" required 
                            @input="detectPlatform($event.target.value)" />
                    </div>
                    <div class="w-full md:w-32" x-data="{ showIconsList: false }">
                        <x-input-label for="icon" :value="__('İkon')" class="text-[10px] font-black uppercase text-gray-400" />
                        <div class="relative mt-1">
                            <button type="button" @click="showIconsList = !showIconsList" class="w-full h-12 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 flex items-center justify-center text-gray-500 hover:text-black dark:hover:text-white transition-colors">
                                <template x-if="newIcon">
                                    <i :class="newIcon" class="text-lg"></i>
                                </template>
                                <template x-if="!newIcon">
                                    <i class="fas fa-icons text-lg"></i>
                                </template>
                            </button>
                            <input type="hidden" name="icon" x-model="newIcon">
                            
                            <!-- Icon Picker Dropdown -->
                            <div x-show="showIconsList" @click.away="showIconsList = false" class="absolute z-50 mt-2 p-3 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-800 grid grid-cols-4 gap-2 w-48 max-h-60 overflow-y-auto custom-scrollbar" x-cloak>
                                <template x-for="iconItem in iconOptions">
                                    <button type="button" @click="newIcon = iconItem; showIconsList = false" class="p-2 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black rounded-xl text-gray-500 transition-all text-center">
                                        <i :class="iconItem"></i>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-auto">
                        <x-primary-button class="w-full h-12 justify-center px-8 rounded-2xl bg-black dark:bg-white text-white dark:text-black hover:opacity-80 shadow-xl shadow-black/10">
                            {{ __('Ekle') }}
                        </x-primary-button>
                    </div>
                </div>

                <!-- Advanced Settings Toggle -->
                <div x-data="{ open: false }" class="mt-4 pt-4 border-t border-gray-50 dark:border-gray-800/50">
                    <button type="button" @click="open = !open" class="text-[10px] text-gray-400 hover:text-black dark:hover:text-white font-black uppercase tracking-widest flex items-center gap-1 transition-colors">
                        <i class="fas h-3 w-3 transition-transform" :class="open ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                        {{ __('Gelişmiş Seçenekler') }}
                    </button>
                    
                    <div x-show="open" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 p-5 bg-gray-50 dark:bg-gray-900 rounded-2xl">
                        <div>
                            <x-input-label for="starts_at" :value="__('Başlangıç')" class="text-[10px] font-black uppercase text-gray-400" />
                            <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full text-xs rounded-xl" />
                        </div>
                        <div>
                            <x-input-label for="expires_at" :value="__('Bitiş')" class="text-[10px] font-black uppercase text-gray-400" />
                            <x-text-input id="expires_at" name="expires_at" type="datetime-local" class="mt-1 block w-full text-xs rounded-xl" />
                        </div>
                        <div>
                            <x-input-label for="password" :value="__('Şifre')" class="text-[10px] font-black uppercase text-gray-400" />
                            <x-text-input id="password" name="password" type="text" class="mt-1 block w-full text-xs rounded-xl" :placeholder="__('Opsiyonel')" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('title')" />
        <x-input-error class="mt-2" :messages="$errors->get('url')" />
    </div>

    <!-- Link Listesi (Sortable) -->
    <div x-ref="sortableList" class="space-y-4">
        @forelse($links as $link)
            <div class="flex items-center gap-4 bg-white dark:bg-black p-5 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm link-item relative group hover:border-black dark:hover:border-white transition-all duration-300" data-id="{{ $link->id }}">
                
                <!-- Drag Handle -->
                <div class="cursor-grab sort-handle text-gray-200 hover:text-black dark:hover:text-white active:cursor-grabbing transition-colors p-2">
                    <i class="fas fa-grip-vertical"></i>
                </div>

                <!-- Link Bilgileri -->
                <div class="flex items-center gap-4 w-12 h-12 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 flex-shrink-0 justify-center text-gray-400 group-hover:text-black dark:group-hover:text-white transition-colors">
                    <i class="{{ $link->icon_class }} text-xl"></i>
                </div>

                <div class="flex-1" x-data="{ editing: false, active: {{ $link->is_active ? 'true' : 'false' }} }">
                    <div x-show="!editing" class="flex justify-between items-center text-left">
                        <div class="truncate max-w-[200px] sm:max-w-md">
                            <p class="text-sm font-black text-gray-900 dark:text-white" :class="{ 'opacity-30 line-through': !active }">{{ $link->title }}</p>
                            <p class="text-[10px] font-black text-gray-400 truncate mt-0.5">{{ str_replace(['https://','http://'], '', $link->url) }}</p>
                            
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-[9px] font-black uppercase text-gray-400 bg-gray-50 dark:bg-black/50 px-2 py-0.5 rounded-lg border border-gray-100 dark:border-gray-800">
                                    {{ $link->clicks }} {{ __('tıklama') }}
                                </span>
                                @if($link->starts_at || $link->expires_at)
                                    <span class="text-[9px] font-black uppercase text-black dark:text-white bg-gray-100 dark:bg-gray-800 px-2 py-0.5 rounded-lg">
                                        <i class="fas fa-calendar-alt mr-1"></i> {{ __('Planlı') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <!-- Toggle Switch -->
                            <button @click="toggleLink({{ $link->id }}, active); active = !active" 
                                    :class="active ? 'bg-black dark:bg-white' : 'bg-gray-100 dark:bg-gray-800'" 
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out">
                                <span aria-hidden="true" :class="active ? 'translate-x-5 bg-white dark:bg-black' : 'translate-x-0 bg-white'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full shadow-lg transition duration-300"></span>
                            </button>
                            
                            <!-- Actions Overlay -->
                            <div class="flex items-center bg-gray-50 dark:bg-black p-1 rounded-2xl border border-gray-100 dark:border-gray-800 opacity-0 group-hover:opacity-100 transition-all">
                                <button @click="editing = true" class="p-2 text-gray-400 hover:text-black dark:hover:text-white transition-colors">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <form method="post" action="{{ route('links.destroy', $link) }}" onsubmit="return confirm('{{ __('Emin misiniz?') }}');" class="flex items-center">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-black dark:hover:text-white transition-colors">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <form @submit="editing = false" x-show="editing" method="post" action="{{ route('links.update', $link) }}" class="flex flex-col gap-4 w-full bg-gray-50 dark:bg-gray-900 p-6 rounded-3xl border border-dashed border-gray-200 dark:border-gray-700 mt-2" x-cloak>
                        @csrf
                        @method('put')
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" x-data="{ currentIcon: '{{ $link->icon_class }}', showIconsEdit: false }">
                            <div>
                                <x-input-label :value="__('Başlık')" class="text-[10px] font-black text-gray-400" />
                                <x-text-input name="title" value="{{ $link->title }}" class="w-full text-xs rounded-xl" required />
                            </div>
                            <div>
                                <x-input-label :value="__('URL')" class="text-[10px] font-black text-gray-400" />
                                <x-text-input name="url" value="{{ $link->url }}" type="url" class="w-full text-xs rounded-xl" required />
                            </div>
                            <div>
                                <x-input-label :value="__('İkon')" class="text-[10px] font-black text-gray-400" />
                                <div class="relative mt-1">
                                    <button type="button" @click="showIconsEdit = !showIconsEdit" class="w-full h-10 rounded-xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-black flex items-center justify-center text-gray-500 hover:text-black dark:hover:text-white transition-colors">
                                        <i :class="currentIcon" class="text-lg"></i>
                                    </button>
                                    <input type="hidden" name="icon" x-model="currentIcon">
                                    
                                    <div x-show="showIconsEdit" @click.away="showIconsEdit = false" class="absolute z-50 mt-2 p-3 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-100 dark:border-gray-800 grid grid-cols-4 gap-2 w-48 max-h-48 overflow-y-auto custom-scrollbar" x-cloak>
                                        <template x-for="iconItem in iconOptions">
                                            <button type="button" @click="currentIcon = iconItem; showIconsEdit = false" class="p-2 hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black rounded-lg text-gray-500 transition-colors text-center">
                                                <i :class="iconItem"></i>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end gap-3 pt-2">
                             <button type="button" @click="editing = false" class="text-[10px] font-black uppercase text-gray-400 hover:text-black transition-colors">{{ __('İptal') }}</button>
                             <x-primary-button class="py-2 px-6 text-[10px] font-black rounded-xl bg-black dark:bg-white text-white dark:text-black">{{ __('Güncelle') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white dark:bg-black rounded-3xl border border-gray-100 dark:border-gray-800">
                <div class="w-16 h-16 bg-gray-50 dark:bg-gray-900 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-link text-gray-300"></i>
                </div>
                <h3 class="text-xs font-black text-gray-900 dark:text-gray-100 uppercase tracking-widest">{{ __('Henüz link bulunmuyor') }}</h3>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 px-8">{{ __('Yukarıdan ilk linkinizi ekleyerek başlayın.') }}</p>
            </div>
        @endforelse
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
