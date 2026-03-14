<!-- Admin Inline Navbar -->
<nav class="h-14 flex-shrink-0 border-b border-border/40 bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 flex items-center px-4 md:px-6">
    <div class="flex flex-1 items-center justify-end space-x-4">
        <a href="{{ route('public.profile', auth()->user()->username) }}" target="_blank" 
           class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary text-primary-foreground rounded-md text-xs font-medium hover:bg-primary/90 transition-colors shadow-sm">
            <i class="fas fa-external-link-alt text-[10px]"></i>
            {{ __('Sayfamı Gör') }}
        </a>

        <div class="flex items-center gap-2 border-l border-border pl-4">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-2 py-1.5 text-sm font-medium rounded-md hover:bg-accent hover:text-accent-foreground transition-colors group">
                        <span class="mr-2">{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4 text-muted-foreground group-hover:text-foreground transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-2 py-1.5 text-xs font-semibold text-muted-foreground uppercase tracking-widest">{{ __('Account') }}</div>
                    <x-dropdown-link :href="route('dashboard', ['tab' => 'settings'])" class="flex items-center">
                        <i class="fas fa-cog mr-2 w-4 opacity-50"></i> {{ __('Ayarlar') }}
                    </x-dropdown-link>

                    <div class="h-px bg-border my-1"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center text-destructive hover:bg-destructive/10">
                            <i class="fas fa-sign-out-alt mr-2 w-4"></i> {{ __('Çıkış Yap') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>
