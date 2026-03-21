<x-app-layout>
    <div class="h-full flex">
        @include('admin.partials.sidebar')

        <div class="flex-1 min-w-0 flex flex-col">
            @include('admin.partials.navbar')

            <main class="flex-1 overflow-y-auto bg-background">
                <div class="max-w-6xl mx-auto p-6 md:p-10 space-y-6">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Kullanici Yonetimi</h1>
                        <p class="mt-1 text-sm text-muted-foreground">Platformdaki tum kullanicilari inceleyin, durumlarini yonetin ve rozetlerini guncelleyin.</p>
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

                    <div class="rounded-lg border border-border bg-card shadow-sm p-4">
                        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-3">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground text-xs"></i>
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Isim, kullanici adi veya e-posta ile ara..." class="w-full pl-9 h-9 rounded-md border border-input bg-background text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring" />
                            </div>
                            <button type="submit" class="inline-flex items-center gap-2 h-9 px-4 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">Ara</button>
                            @if($search)
                                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center h-9 px-4 bg-secondary text-secondary-foreground rounded-md text-sm font-medium hover:bg-secondary/80 transition-colors">Temizle</a>
                            @endif
                        </form>
                    </div>

                    <div class="rounded-lg border border-border bg-card shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-muted/50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Kullanici</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-muted-foreground uppercase tracking-wider">Blok</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-muted-foreground uppercase tracking-wider">Goruntulenme / Tik</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Durum</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Tarih</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-muted-foreground uppercase tracking-wider">Islemler</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @forelse ($users as $user)
                                        <tr class="hover:bg-muted/50 transition-colors">
                                            <td class="px-4 py-3 text-xs text-muted-foreground font-mono">#{{ $user->id }}</td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-muted flex items-center justify-center text-xs font-semibold flex-shrink-0">{{ substr($user->name, 0, 1) }}</div>
                                                    <div class="min-w-0">
                                                        <div class="flex items-center gap-1.5">
                                                            <p class="text-sm font-semibold truncate">{{ $user->name }}</p>
                                                            @if($user->verified)
                                                                <x-verified-badge size="sm" />
                                                            @endif
                                                            @if($user->is_admin)
                                                                <span class="px-1.5 py-0.5 text-[9px] font-semibold rounded bg-foreground text-background uppercase">Admin</span>
                                                            @endif
                                                        </div>
                                                        <p class="text-xs text-muted-foreground truncate">{{ '@' . $user->username }} · {{ $user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <span class="text-xs font-semibold text-muted-foreground">{{ $blocksEnabled ? ($user->blocks_count ?? $user->links_count) : $user->links_count }}</span>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="text-xs">
                                                    <span class="font-semibold">{{ number_format($user->profile->views ?? 0) }}</span>
                                                    <span class="text-muted-foreground mx-1">/</span>
                                                    <span class="text-muted-foreground">{{ number_format($user->links->sum('clicks')) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    @if($user->is_active)
                                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Aktif</span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 text-[10px] font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">Askida</span>
                                                    @endif

                                                    @if($user->verified)
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-sky-50 px-2 py-0.5 text-[10px] font-medium text-sky-700">
                                                            <x-verified-badge size="sm" class="!h-3.5 !w-3.5 !text-[8px]" />
                                                            Dogrulanmis
                                                        </span>
                                                    @endif

                                                    @if($user->plan === 'pro')
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-medium text-amber-700">
                                                            <i class="fas fa-crown text-[9px]"></i>
                                                            PRO
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center gap-1 rounded-full bg-muted/50 px-2 py-0.5 text-[10px] font-medium text-muted-foreground border border-border">
                                                            FREE
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 text-xs text-muted-foreground">{{ $user->created_at->format('d M Y') }}</td>
                                            <td class="px-4 py-3 text-right">
                                                @if($user->id !== auth()->id())
                                                    <div class="flex justify-end gap-1">
                                                        <a href="{{ route('public.profile', $user->username) }}" target="_blank" class="p-1.5 rounded-md text-muted-foreground hover:text-foreground hover:bg-accent transition-colors" title="Profili Gor">
                                                            <i class="fas fa-external-link-alt text-xs"></i>
                                                        </a>
                                                        <a href="{{ route('admin.users.impersonate', $user) }}" class="p-1.5 rounded-md text-muted-foreground hover:text-foreground hover:bg-accent transition-colors" title="Kullanici Olarak Giris">
                                                            <i class="fas fa-user-secret text-xs"></i>
                                                        </a>
                                                        <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="p-1.5 rounded-md transition-colors {{ $user->is_active ? 'text-amber-500 hover:text-amber-700 hover:bg-amber-50' : 'text-green-500 hover:text-green-700 hover:bg-green-50' }}" title="{{ $user->is_active ? 'Askiya Al' : 'Aktiflestir' }}">
                                                                <i class="fas {{ $user->is_active ? 'fa-ban' : 'fa-check-circle' }} text-xs"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.users.verified', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="p-1.5 rounded-md transition-colors {{ $user->verified ? 'text-sky-500 hover:text-sky-700 hover:bg-sky-50' : 'text-muted-foreground hover:text-sky-500 hover:bg-sky-50' }}" title="{{ $user->verified ? 'Dogrulamayi Kaldir' : 'Dogrula' }}">
                                                                <i class="fas fa-circle-check text-xs"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.users.plan', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="plan" value="{{ $user->plan === 'pro' ? 'free' : 'pro' }}">
                                                            <button type="submit" class="p-1.5 rounded-md transition-colors {{ $user->plan === 'pro' ? 'text-amber-500 hover:text-amber-700 hover:bg-amber-50' : 'text-muted-foreground hover:text-amber-500 hover:bg-amber-50' }}" title="{{ $user->plan === 'pro' ? 'Free Plana Düşür' : 'Pro Plana Yükselt' }}">
                                                                <i class="fas fa-crown text-xs"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Bu kullaniciyi kalici olarak silmek istediginize emin misiniz?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="p-1.5 rounded-md text-destructive transition-colors hover:bg-destructive/10" title="Kullaniciyi Sil">
                                                                <i class="fas fa-trash text-xs"></i>
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
                                                Kullanici bulunamadi.
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
