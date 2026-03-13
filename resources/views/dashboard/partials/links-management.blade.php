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
                <i class="fas fa-plus-circle text-indigo-600"></i>
                <h2 class="text-xs font-black text-gray-900 dark:text-gray-100 uppercase tracking-widest">{{ __('Yeni Link Ekle') }}</h2>
            </div>
        </header>
        <div class="p-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
        <form method="post" action="{{ route('links.store') }}" class="space-y-4">
            @csrf
            <div class="flex flex-col md:flex-row gap-5 items-end">
                <div class="w-full md:flex-1">
                    <x-input-label for="title" :value="__('Başlık')" class="text-[10px] font-black uppercase text-gray-400" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900" placeholder="Örn: Web Sitem" required />
                </div>
                <div class="w-full md:flex-1">
                    <x-input-label for="url" :value="__('URL (Bağlantı)')" class="text-[10px] font-black uppercase text-gray-400" />
                    <x-text-input id="url" name="url" type="url" class="mt-1 block w-full rounded-xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900" placeholder="https://example.com" required 
                        @input="detectPlatform($event.target.value)" />
                </div>
                <div class="w-full md:w-32" x-data="{ showIcons: false }">
                    <x-input-label for="icon" :value="__('İkon')" class="text-[10px] font-black uppercase text-gray-400" />
                    <div class="relative mt-1">
                        <button type="button" @click="showIcons = !showIcons" class="w-full h-[42px] rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex items-center justify-center text-gray-500 hover:text-indigo-500 transition-colors">
                            <template x-if="newIcon">
                                <i :class="newIcon" class="text-lg"></i>
                            </template>
                            <template x-if="!newIcon">
                                <i class="fas fa-icons text-lg"></i>
                            </template>
                        </button>
                        <input type="hidden" name="icon" x-model="newIcon">
                        
                        <!-- Icon Picker Dropdown (Simplified) -->
                        <div x-show="showIcons" @click.away="showIcons = false" class="absolute z-50 mt-2 p-3 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 grid grid-cols-4 gap-2 w-48">
                            <template x-for="iconItem in iconOptions">
                                <button type="button" @click="newIcon = iconItem; showIcons = false" class="p-2 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg text-gray-500 hover:text-indigo-600 transition-colors text-center">
                                    <i :class="iconItem"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-auto">
                    <x-primary-button class="w-full h-[42px] justify-center px-8 rounded-xl bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/20">
                        {{ __('Ekle') }}
                    </x-primary-button>
                </div>
            </div>

            <!-- Advanced Settings Toggle -->
            <div x-data="{ open: false }" class="mt-4 pt-4 border-t border-gray-50 dark:border-gray-700/50">
                <button type="button" @click="open = !open" class="text-[10px] text-gray-400 hover:text-indigo-500 font-bold uppercase tracking-wider flex items-center gap-1 transition-colors">
                    <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    {{ __('Gelişmiş Seçenekler (Zamanlama, Şifre)') }}
                </button>
                
                <div x-show="open" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-xl">
                    <div>
                        <x-input-label for="starts_at" :value="__('Başlangıç Tarihi')" class="text-[10px] font-bold text-gray-400" />
                        <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full text-xs rounded-lg" />
                    </div>
                    <div>
                        <x-input-label for="expires_at" :value="__('Bitiş Tarihi')" class="text-[10px] font-bold text-gray-400" />
                        <x-text-input id="expires_at" name="expires_at" type="datetime-local" class="mt-1 block w-full text-xs rounded-lg" />
                    </div>
                    <div>
                        <x-text-input id="password" name="password" type="text" class="mt-1 block w-full text-xs rounded-lg" :placeholder="__('Opsiyonel')" />
                    </div>
                </div>
            </div>
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('title')" />
        <x-input-error class="mt-2" :messages="$errors->get('url')" />
    </div>

    <!-- Link Listesi (Sortable) -->
    <div x-ref="sortableList" class="space-y-4">
        @forelse($links as $link)
            <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm link-item relative group hover:shadow-md hover:border-indigo-100 dark:hover:border-indigo-900/50 transition-all" data-id="{{ $link->id }}">
                
                <!-- Drag Handle -->
                <div class="cursor-grab sort-handle text-gray-200 hover:text-indigo-500 active:cursor-grabbing transition-colors p-1">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 9h2v2H8V9zm4 0h2v2h-2V9zm4 0h2v2h-2V9zm-8 4h2v2H8v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2z" /></svg>
                </div>

                <!-- Link Bilgileri -->
                <div class="flex items-center gap-4 w-12 h-12 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 flex-shrink-0 justify-center text-gray-400 group-hover:text-indigo-500 transition-colors">
                    <i class="{{ $link->icon_class }} text-xl"></i>
                </div>

                <div class="flex-1" x-data="{ editing: false, active: {{ $link->is_active ? 'true' : 'false' }} }">
                    <div x-show="!editing" class="flex justify-between items-center text-left">
                        <div class="truncate max-w-[200px] sm:max-w-md">
                            <p class="font-black text-gray-900 dark:text-gray-100" :class="{ 'opacity-50 line-through': !active }">{{ $link->title }}</p>
                            <p class="text-xs font-bold text-indigo-500 truncate mt-0.5">{{ $link->url }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-[10px] font-black uppercase text-gray-400 bg-gray-50 dark:bg-gray-700 px-2 py-0.5 rounded-lg border border-gray-100 dark:border-gray-600">
                                    {{ $link->clicks }} {{ __('tıklama') }}
                                </span>
                                @if($link->starts_at || $link->expires_at)
                                    <span class="text-[10px] font-black uppercase text-amber-500 bg-amber-50 dark:bg-amber-900/20 px-2 py-0.5 rounded-lg border border-amber-100 dark:border-amber-900/30">
                                        <i class="fas fa-calendar-alt mr-1"></i> {{ __('Planlı') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <!-- Toggle Switch -->
                            <button @click="toggleLink({{ $link->id }}, active); active = !active" 
                                    :class="active ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-700'" 
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <span aria-hidden="true" :class="active ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow-lg ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            
                            <!-- Actions Menu -->
                            <div class="flex items-center bg-gray-50 dark:bg-gray-900 p-1 rounded-xl border border-gray-100 dark:border-gray-700">
                                <button @click="editing = true" class="p-2 text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form method="post" action="{{ route('links.destroy', $link) }}" onsubmit="return confirm('{{ __('Bu bağlantıyı silmek istediğinizden emin misiniz?') }}');" class="flex items-center">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modu -->
                    <form x-show="editing" method="post" action="{{ route('links.update', $link) }}" class="flex flex-col gap-4 w-full bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 mt-2">
                        @csrf
                        @method('put')
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" x-data="{ currentIcon: '{{ $link->icon_class }}', showIcons: false }">
                            <div>
                                <x-input-label :value="__('Başlık')" class="text-[10px] font-bold text-gray-400" />
                                <x-text-input name="title" value="{{ $link->title }}" class="w-full text-sm rounded-lg" required />
                            </div>
                            <div>
                                <x-input-label :value="__('URL (Bağlantı)')" class="text-[10px] font-bold text-gray-400" />
                                <x-text-input name="url" value="{{ $link->url }}" type="url" class="w-full text-sm rounded-lg" required />
                            </div>
                            <div>
                                <x-input-label :value="__('İkon')" class="text-[10px] font-bold text-gray-400" />
                                <div class="relative mt-1">
                                    <button type="button" @click="showIcons = !showIcons" class="w-full h-[42px] rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex items-center justify-center text-gray-500 hover:text-indigo-500 transition-colors">
                                        <i :class="currentIcon" class="text-lg"></i>
                                    </button>
                                    <input type="hidden" name="icon" x-model="currentIcon">
                                    
                                    <div x-show="showIcons" @click.away="showIcons = false" class="absolute z-50 mt-2 p-3 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 grid grid-cols-4 gap-2 w-48">
                                        <template x-for="iconItem in iconOptions">
                                            <button type="button" @click="currentIcon = iconItem; showIcons = false" class="p-2 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg text-gray-500 hover:text-indigo-600 transition-colors text-center">
                                                <i :class="iconItem"></i>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="text-[10px] text-gray-400 hover:text-indigo-500 font-bold uppercase flex items-center gap-1 transition-colors">
                                <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                {{ __('Gelişmiş Ayarlar') }}
                            </button>
                            <div x-show="open" x-cloak class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-4 p-4 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Başlangıç') }}</label>
                                    <x-text-input name="starts_at" value="{{ $link->starts_at?->format('Y-m-d\TH:i') }}" type="datetime-local" class="w-full text-xs rounded-lg mt-1" />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Bitiş') }}</label>
                                    <x-text-input name="expires_at" value="{{ $link->expires_at?->format('Y-m-d\TH:i') }}" type="datetime-local" class="w-full text-xs rounded-lg mt-1" />
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Şifre') }}</label>
                                    <x-text-input name="password" value="{{ $link->password }}" class="w-full text-xs rounded-lg mt-1" :placeholder="__('Opsiyonel')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                             <x-secondary-button @click.prevent="editing = false" class="py-2 px-4 text-xs rounded-xl">{{ __('İptal') }}</x-secondary-button>
                             <x-primary-button class="py-2 px-6 text-xs font-black rounded-xl bg-indigo-600 hover:bg-indigo-700">{{ __('Güncelle') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100 italic">{{ __('Henüz link bulunmuyor') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Yukarıdan ilk linkinizi ekleyerek başlayın.') }}</p>
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
                        'fas fa-globe', 'fas fa-shopping-cart', 'fas fa-music', 'fas fa-video'
                    ],
                    init() {
                        let el = this.$refs.sortableList;
                        if(el) {
                            Sortable.create(el, {
                                handle: '.sort-handle',
                                animation: 150,
                                ghostClass: 'bg-indigo-50',
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
