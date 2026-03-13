<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Links') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="linksManager()">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Link Ekle Formu -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Add New Link') }}</h2>
                </header>
                <form method="post" action="{{ route('links.store') }}" class="mt-6 flex gap-4 items-end">
                    @csrf
                    <div class="flex-1">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="e.g. My Website" required />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="url" :value="__('URL')" />
                        <x-text-input id="url" name="url" type="url" class="mt-1 block w-full" placeholder="https://example.com" required />
                    </div>
                    <div>
                        <x-primary-button>{{ __('Add') }}</x-primary-button>
                    </div>
                </form>
                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                <x-input-error class="mt-2" :messages="$errors->get('url')" />
            </div>

            <!-- Link Listesi (Sortable) -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div x-ref="sortableList" class="space-y-3">
                    @forelse($links as $link)
                        <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded shadow-sm link-item" data-id="{{ $link->id }}">
                            
                            <!-- Drag Handle -->
                            <div class="cursor-pointer sort-handle text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                            </div>

                            <!-- Link Bilgileri -->
                            <div class="flex-1" x-data="{ editing: false, active: {{ $link->is_active ? 'true' : 'false' }} }">
                                <div x-show="!editing" class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100" :class="{ 'opacity-50 line-through': !active }">{{ $link->title }}</p>
                                        <a href="{{ $link->url }}" target="_blank" class="text-sm text-indigo-500 hover:underline">{{ $link->url }}</a>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <!-- Toggle Switch -->
                                        <button @click="toggleLink({{ $link->id }}, active); active = !active" :class="active ? 'bg-indigo-600' : 'bg-gray-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                            <span aria-hidden="true" :class="active ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                        </button>
                                        
                                        <!-- Edit Btn -->
                                        <button @click="editing = true" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Edit</button>
                                    </div>
                                </div>

                                <!-- Edit Modu -->
                                <form x-show="editing" method="post" action="{{ route('links.update', $link) }}" class="flex gap-2 items-end w-full">
                                    @csrf
                                    @method('put')
                                    <div class="flex-1">
                                        <x-text-input name="title" value="{{ $link->title }}" class="w-full text-sm" required />
                                    </div>
                                    <div class="flex-1">
                                        <x-text-input name="url" value="{{ $link->url }}" type="url" class="w-full text-sm" required />
                                    </div>
                                    <div class="flex gap-2">
                                        <x-primary-button class="text-xs">Save</x-primary-button>
                                        <x-secondary-button @click="editing = false" class="text-xs">Cancel</x-secondary-button>
                                    </div>
                                </form>
                            </div>

                            <!-- Silme Butonu -->
                            <form method="post" action="{{ route('links.destroy', $link) }}" onsubmit="return confirm('Are you sure you want to delete this link?');">
                                @csrf
                                @method('delete')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">You haven't added any links yet.</p>
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>

    <!-- SortableJS Dahil Edilmesi & Alpine Bileşeni -->
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('linksManager', () => ({
                init() {
                    let el = this.$refs.sortableList;
                    if(el) {
                        Sortable.create(el, {
                            handle: '.sort-handle',
                            animation: 150,
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
                    });
                }
            }))
        });
    </script>
    @endpush
</x-app-layout>
