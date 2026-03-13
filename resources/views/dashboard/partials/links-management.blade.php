<div x-data="linksManager()">
    <!-- Link Ekle Formu -->
    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
        <header class="mb-4">
            <h2 class="text-md font-semibold text-gray-900 dark:text-gray-100">{{ __('Add New Link') }}</h2>
        </header>
        <form method="post" action="{{ route('links.store') }}" class="space-y-4">
            @csrf
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:flex-1">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="e.g. My Website" required />
                </div>
                <div class="w-full md:flex-1">
                    <x-input-label for="url" :value="__('URL')" />
                    <x-text-input id="url" name="url" type="url" class="mt-1 block w-full" placeholder="https://example.com" required />
                </div>
                <div class="w-full md:w-auto">
                    <x-primary-button class="w-full justify-center">{{ __('Add') }}</x-primary-button>
                </div>
            </div>

            <!-- Advanced Settings Toggle -->
            <div x-data="{ open: false }">
                <button type="button" @click="open = !open" class="text-xs text-indigo-500 hover:text-indigo-600 font-medium flex items-center gap-1">
                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    Advanced Options (Scheduling, Password)
                </button>
                
                <div x-show="open" x-cloak class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700">
                    <div>
                        <x-input-label for="starts_at" :value="__('Starts At')" />
                        <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full text-xs" />
                    </div>
                    <div>
                        <x-input-label for="expires_at" :value="__('Expires At')" />
                        <x-text-input id="expires_at" name="expires_at" type="datetime-local" class="mt-1 block w-full text-xs" />
                    </div>
                    <div>
                        <x-input-label for="password" :value="__('Password Protection')" />
                        <x-text-input id="password" name="password" type="text" class="mt-1 block w-full text-xs" placeholder="Optional" />
                    </div>
                </div>
            </div>
        </form>
        <x-input-error class="mt-2" :messages="$errors->get('title')" />
        <x-input-error class="mt-2" :messages="$errors->get('url')" />
    </div>

    <!-- Link Listesi (Sortable) -->
    <div x-ref="sortableList" class="space-y-3">
        @forelse($links as $link)
            <div class="flex items-center gap-4 bg-white dark:bg-gray-700 p-4 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm link-item relative group" data-id="{{ $link->id }}">
                
                <!-- Drag Handle -->
                <div class="cursor-grab sort-handle text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 active:cursor-grabbing">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                </div>

                <!-- Link Bilgileri -->
                <div class="flex-1" x-data="{ editing: false, active: {{ $link->is_active ? 'true' : 'false' }} }">
                    <div x-show="!editing" class="flex justify-between items-center">
                        <div class="truncate max-w-[200px] sm:max-w-md">
                            <p class="font-semibold text-gray-900 dark:text-gray-100" :class="{ 'opacity-50 line-through': !active }">{{ $link->title }}</p>
                            <p class="text-xs text-indigo-500 truncate">{{ $link->url }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $link->clicks }} clicks</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <!-- Toggle Switch -->
                            <button @click="toggleLink({{ $link->id }}, active); active = !active" 
                                    :class="active ? 'bg-indigo-600' : 'bg-gray-200 dark:bg-gray-600'" 
                                    class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                <span aria-hidden="true" :class="active ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            
                            <!-- Edit Btn -->
                            <button @click="editing = true" class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Edit Modu -->
                    <form x-show="editing" method="post" action="{{ route('links.update', $link) }}" class="flex flex-col gap-4 w-full">
                        @csrf
                        @method('put')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <x-text-input name="title" value="{{ $link->title }}" class="w-full text-sm" required />
                            <x-text-input name="url" value="{{ $link->url }}" type="url" class="w-full text-sm" required />
                        </div>
                        
                        <div x-data="{ open: false }">
                            <button type="button" @click="open = !open" class="text-[10px] text-gray-500 hover:text-indigo-500 flex items-center gap-1">
                                <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-90' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                Advanced Settings
                            </button>
                            <div x-show="open" x-cloak class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-2 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                <div>
                                    <label class="text-[10px] text-gray-400">Starts At</label>
                                    <x-text-input name="starts_at" value="{{ $link->starts_at?->format('Y-m-d\TH:i') }}" type="datetime-local" class="w-full text-[10px] p-1" />
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400">Expires At</label>
                                    <x-text-input name="expires_at" value="{{ $link->expires_at?->format('Y-m-d\TH:i') }}" type="datetime-local" class="w-full text-[10px] p-1" />
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400">Password</label>
                                    <x-text-input name="password" value="{{ $link->password }}" class="w-full text-[10px] p-1" />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <x-secondary-button @click="editing = false" class="py-1 px-3 text-xs">Cancel</x-secondary-button>
                            <x-primary-button class="py-1 px-3 text-xs font-bold">Save</x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Silme Butonu -->
                <div class="flex items-center">
                    <form method="post" action="{{ route('links.destroy', $link) }}" onsubmit="return confirm('Are you sure you want to delete this link?');">
                        @csrf
                        @method('delete')
                        <button type="submit" class="p-1 text-red-400 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100 italic">No links yet</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding your first link above.</p>
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
