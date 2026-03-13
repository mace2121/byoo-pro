<x-app-layout>
    <div class="h-[calc(100vh-65px)] overflow-hidden flex flex-col" x-data="{ tab: 'links' }">
        <div class="flex-1 flex overflow-hidden">
            <!-- Sidebar Navigation (Shadcn Style) -->
            <aside class="w-64 border-r border-[hsl(var(--border))] bg-[hsl(var(--background))] flex-shrink-0 transition-all duration-300 z-30" 
                   :class="sidebarOpen ? 'ml-0' : '-ml-64'">
                <div class="h-full flex flex-col py-4">
                    <div class="px-4 mb-4">
                        <p class="text-[10px] font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-widest">{{ __('Menu') }}</p>
                    </div>
                    <nav class="space-y-1 px-2">
                        <button @click="tab = 'links'" 
                                :class="tab === 'links' ? 'bg-[hsl(var(--accent))] text-[hsl(var(--accent-foreground))]' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--accent))] hover:text-[hsl(var(--accent-foreground))]'"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-link w-4 text-center"></i>
                            {{ __('Linklerim') }}
                        </button>
                        <button @click="tab = 'stats'" 
                                :class="tab === 'stats' ? 'bg-[hsl(var(--accent))] text-[hsl(var(--accent-foreground))]' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--accent))] hover:text-[hsl(var(--accent-foreground))]'"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-chart-pie w-4 text-center"></i>
                            {{ __('Analytics') }}
                        </button>
                        <button @click="tab = 'design'" 
                                :class="tab === 'design' ? 'bg-[hsl(var(--accent))] text-[hsl(var(--accent-foreground))]' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--accent))] hover:text-[hsl(var(--accent-foreground))]'"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-paint-brush w-4 text-center"></i>
                            {{ __('Tasarım') }}
                        </button>
                        <button @click="tab = 'settings'" 
                                :class="tab === 'settings' ? 'bg-[hsl(var(--accent))] text-[hsl(var(--accent-foreground))]' : 'text-[hsl(var(--muted-foreground))] hover:bg-[hsl(var(--accent))] hover:text-[hsl(var(--accent-foreground))]'"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            <i class="fas fa-cog w-4 text-center"></i>
                            {{ __('Ayarlar') }}
                        </button>
                    </nav>

                    <div class="mt-auto px-4 pb-4">
                        <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] p-4 shadow-sm">
                            <p class="text-[10px] font-medium text-[hsl(var(--muted-foreground))] uppercase tracking-widest mb-3">Copy URL</p>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-8 h-8 rounded bg-[hsl(var(--muted))] flex items-center justify-center">
                                    <i class="fas fa-qrcode text-xs"></i>
                                </div>
                                <p class="text-[10px] font-medium text-[hsl(var(--foreground))] truncate">{{ $user->username }}</p>
                            </div>
                            <button @click="navigator.clipboard.writeText('{{ route('public.profile', $user->username) }}'); alert('Kopyalandı!')" 
                                    class="w-full py-1.5 bg-[hsl(var(--primary))] text-[hsl(var(--primary-foreground))] rounded-md text-xs font-bold hover:opacity-90 transition-opacity">
                                {{ __('Kopyala') }}
                            </button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 min-w-0 overflow-y-auto bg-[hsl(var(--background))] border-l border-[hsl(var(--border))]">
                <div class="max-w-4xl mx-auto p-4 md:p-10 space-y-10">
                    <div x-show="tab === 'links'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        @include('dashboard.partials.links-management')
                    </div>
                    
                    <div x-show="tab === 'stats'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="grid grid-cols-1 gap-6">
                            @include('dashboard.partials.stats-cards')
                        </div>
                    </div>

                    <div x-show="tab === 'design'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] p-6 md:p-8 shadow-sm">
                            @include('profile.partials.update-theme-form')
                        </div>
                    </div>

                    <div x-show="tab === 'settings'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="space-y-6">
                            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] p-6 md:p-8 shadow-sm">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] p-6 md:p-8 shadow-sm">
                                @include('profile.partials.update-password-form')
                            </div>
                            <div class="rounded-lg border border-destructive/20 bg-destructive/5 p-6 md:p-8">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Preview Panel (Fixed) -->
            <aside class="hidden xl:block w-[450px] border-l border-[hsl(var(--border))] bg-[hsl(var(--muted))] p-8 overflow-y-auto">
                <div class="sticky top-0">
                    <header class="mb-6 flex items-center justify-between">
                        <h3 class="text-[10px] font-bold text-[hsl(var(--muted-foreground))] uppercase tracking-[0.2em]">{{ __('Live Preview') }}</h3>
                        <div class="flex gap-2">
                            <span class="w-3 h-3 rounded-full border border-[hsl(var(--border))]"></span>
                            <span class="w-3 h-3 rounded-full border border-[hsl(var(--border))]"></span>
                        </div>
                    </header>
                    <div class="relative mx-auto w-full max-w-[320px] aspect-[9/18.5] bg-[hsl(var(--background))] rounded-[2.5rem] border-[8px] border-[hsl(var(--primary))] shadow-2xl overflow-hidden ring-1 ring-[hsl(var(--border))]"
                         x-on:links-updated.window="$refs.previewIframe.src = $refs.previewIframe.src"
                         x-on:profile-updated.window="$refs.previewIframe.src = $refs.previewIframe.src">
                        <iframe x-ref="previewIframe" src="{{ route('public.profile', auth()->user()->username) }}" class="w-full h-full border-none"></iframe>
                    </div>
                    <div class="mt-8 text-center">
                        <p class="text-[10px] font-bold text-[hsl(var(--muted-foreground))] uppercase tracking-widest italic opacity-50">{{ __('Synced in Realtime') }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
