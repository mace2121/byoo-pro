<aside class="border-r border-border bg-background flex-shrink-0 transition-all duration-300 z-30 flex flex-col" :class="sidebarOpen ? 'w-64' : 'w-0 overflow-hidden'">
    <div class="h-full flex w-64 flex-col">
        <div class="h-14 flex items-center justify-between px-4 border-b border-border">
            <a href="{{ route('dashboard') }}">
                <x-brand-mark icon-class="h-5 w-5 text-foreground" text-class="font-bold text-sm tracking-tight italic" dot-class="text-muted-foreground" />
            </a>

            <button @click="sidebarOpen = false" class="p-1 rounded-md hover:bg-accent text-muted-foreground hover:text-foreground transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            </button>
        </div>

        <div class="flex-1 py-4">
            <div class="px-4 mb-2">
                <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest">Yonetim</p>
            </div>
            <nav class="space-y-1 px-2">
                <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                    <i class="fas fa-chart-bar w-4 text-center"></i>
                    Genel Bakis
                </a>
                <a href="{{ route('admin.users.index') }}" class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                    <i class="fas fa-users w-4 text-center"></i>
                    Kullanicilar
                </a>
            </nav>

            <div class="px-4 mt-6 mb-2">
                <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest">Hizli Erisim</p>
            </div>
            <nav class="space-y-1 px-2">
                <a href="{{ route('dashboard') }}" class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-muted-foreground hover:bg-accent hover:text-accent-foreground transition-colors">
                    <i class="fas fa-arrow-left w-4 text-center"></i>
                    Panele Don
                </a>
            </nav>
        </div>
    </div>
</aside>
