<!-- Admin Sidebar -->
<aside class="w-64 border-r border-border bg-background flex-shrink-0 flex flex-col">
    <div class="h-full flex flex-col">
        <!-- Header -->
        <div class="h-14 flex items-center px-4 border-b border-border">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                <x-application-logo class="h-5 w-5 fill-current" />
                <span class="font-bold text-sm tracking-tight italic">byoo<span class="text-muted-foreground">.pro</span></span>
            </a>
        </div>

        <!-- Navigation -->
        <div class="flex-1 py-4">
            <div class="px-4 mb-2">
                <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest">{{ __('Yönetim') }}</p>
            </div>
            <nav class="space-y-1 px-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                    <i class="fas fa-chart-bar w-4 text-center"></i>
                    {{ __('Genel Bakış') }}
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-accent text-accent-foreground' : 'text-muted-foreground hover:bg-accent hover:text-accent-foreground' }}">
                    <i class="fas fa-users w-4 text-center"></i>
                    {{ __('Kullanıcılar') }}
                </a>
            </nav>

            <div class="px-4 mt-6 mb-2">
                <p class="text-[10px] font-medium text-muted-foreground uppercase tracking-widest">{{ __('Hızlı Erişim') }}</p>
            </div>
            <nav class="space-y-1 px-2">
                <a href="{{ route('dashboard') }}" 
                   class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-muted-foreground hover:bg-accent hover:text-accent-foreground transition-colors">
                    <i class="fas fa-arrow-left w-4 text-center"></i>
                    {{ __('Panele Dön') }}
                </a>
            </nav>
        </div>
    </div>
</aside>
