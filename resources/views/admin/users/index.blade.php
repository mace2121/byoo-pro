<x-app-layout>
    <div class="h-full flex">
        <!-- Admin Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Right Column: Navbar + Content -->
        <div class="flex-1 min-w-0 flex flex-col">
            @include('admin.partials.navbar')

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-background">
                <div class="max-w-6xl mx-auto p-6 md:p-10 space-y-6">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">{{ __('Kullanıcı Yönetimi') }}</h1>
                        <p class="text-sm text-muted-foreground mt-1">{{ __('Platformdaki tüm kullanıcıları inceleyin, durumlarını yönetin ve erişimlerini kontrol edin.') }}</p>
                    </div>

                    @if(session('success'))
                        <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="rounded-md border border-destructive/20 bg-destructive/5 px-4 py-3 text-sm text-destructive flex items-center gap-2">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Search -->
                    <div class="rounded-lg border border-border bg-card shadow-sm p-4">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-3">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground text-xs"></i>
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="İsim, kullanıcı adı veya e-posta ile ara..." 
                                       class="w-full pl-9 h-9 rounded-md border border-input bg-background text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring" />
                            </div>
                            <button type="submit" class="inline-flex items-center gap-2 h-9 px-4 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                                {{ __('Ara') }}
                            </button>
                            @if($search)
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center h-9 px-4 bg-secondary text-secondary-foreground rounded-md text-sm font-medium hover:bg-secondary/80 transition-colors">
                                    {{ __('Temizle') }}
                                </a>
                            @endif
                        </form>
                    </div>

                    <!-- Users Table -->
                    <div class="rounded-lg border border-border bg-card shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-muted/50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">{{ __('Kullanıcı') }}</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-muted-foreground uppercase tracking-wider">{{ __('Link') }}</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-muted-foreground uppercase tracking-wider">{{ __('Görüntülenme / Tık') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">{{ __('Durum') }}</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">{{ __('Tarih') }}</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-muted-foreground uppercase tracking-wider">{{ __('İşlemler') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @forelse ($users as $user)
                                        <tr class="hover:bg-muted/50 transition-colors">
                                            <td class="px-4 py-3 text-xs text-muted-foreground font-mono">#{{ $user->id }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-muted flex items-center justify-center text-xs font-semibold flex-shrink-0">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <div class="flex items-center gap-1.5">
                                                            <p class="text-sm font-semibold truncate">{{ $user->name }}</p>
                                                            @if($user->is_admin)
                                                                <span class="px-1.5 py-0.5 text-[9px] font-semibold rounded bg-foreground text-background uppercase">Admin</span>
                                                            @endif
                                                        </div>
                                                        <p class="text-xs text-muted-foreground truncate">{{ '@' . $user->username }} · {{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="text-xs font-semibold text-muted-foreground">{{ $user->links_count }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="text-xs">
                                                    <span class="font-semibold">{{ number_format($user->profile->views ?? 0) }}</span>
                                                    <span class="text-muted-foreground mx-1">/</span>
                                                    <span class="text-muted-foreground">{{ number_format($user->links->sum('clicks')) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($user->is_active)
                                                    <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ __('Aktif') }}</span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">{{ __('Askıda') }}</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-xs text-muted-foreground">{{ $user->created_at->format('d M Y') }}</td>
                                            <td class="px-4 py-3 text-right">
                                                @if($user->id !== auth()->id())
                                                    <div class="flex justify-end gap-1">
                                                        <a href="{{ route('public.profile', $user->username) }}" target="_blank" class="p-1.5 rounded-md text-muted-foreground hover:text-foreground hover:bg-accent transition-colors" title="{{ __('Profili Gör') }}">
                                                            <i class="fas fa-external-link-alt text-xs"></i>
                                                        </a>
                                                        <a href="{{ route('admin.users.impersonate', $user) }}" class="p-1.5 rounded-md text-muted-foreground hover:text-foreground hover:bg-accent transition-colors" title="{{ __('Kullanıcı Olarak Giriş') }}">
                                                            <i class="fas fa-user-secret text-xs"></i>
                                                        </a>
                                                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="p-1.5 rounded-md transition-colors {{ $user->is_active ? 'text-amber-500 hover:text-amber-700 hover:bg-amber-50' : 'text-green-500 hover:text-green-700 hover:bg-green-50' }}" title="{{ $user->is_active ? __('Askıya Al') : __('Aktifleştir') }}">
                                                                <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }} text-xs"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-12 text-center text-sm text-muted-foreground">
                                                <i class="fas fa-users-slash text-2xl opacity-20 mb-2 block"></i>
                                                {{ __('Kullanıcı bulunamadı.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-4 py-3 border-t border-border">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
