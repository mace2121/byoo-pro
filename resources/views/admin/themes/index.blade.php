<x-app-layout>
    <div class="h-full flex">
        @include('admin.partials.sidebar')

        <div class="flex-1 min-w-0 flex flex-col">
            @include('admin.partials.navbar')

            <main class="flex-1 overflow-y-auto bg-background">
                <div class="max-w-6xl mx-auto p-6 md:p-10 space-y-6">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Tema Yönetimi</h1>
                        <p class="mt-1 text-sm text-muted-foreground">Kullanıcılar tarafından oluşturulan temaları inceleyin ve onaylayın.</p>
                    </div>

                    @if(session('success'))
                        <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="rounded-lg border border-border bg-card shadow-sm p-4">
                        <form action="{{ route('admin.themes.index') }}" method="GET" class="flex gap-3">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground text-xs"></i>
                                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Tema adı ile ara..." class="w-full pl-9 h-9 rounded-md border border-input bg-background text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring" />
                            </div>
                            <button type="submit" class="inline-flex items-center gap-2 h-9 px-4 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">Ara</button>
                        </form>
                    </div>

                    <div class="rounded-lg border border-border bg-card shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-muted/50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">ID</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Tema</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-muted-foreground uppercase tracking-wider">Oluşturan</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-muted-foreground uppercase tracking-wider">Tür</th>
                                        <th class="px-4 py-3 text-center text-xs font-medium text-muted-foreground uppercase tracking-wider">Durum</th>
                                        <th class="px-4 py-3 text-right text-xs font-medium text-muted-foreground uppercase tracking-wider">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border/50">
                                    @forelse($themes as $theme)
                                        <tr class="hover:bg-muted/30 transition-colors">
                                            <td class="px-4 py-4 text-xs font-mono text-muted-foreground">{{ $theme->id }}</td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="h-10 w-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                                        <i class="fas fa-palette"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-bold">{{ $theme->name }}</p>
                                                        <p class="text-[10px] text-muted-foreground font-mono">/themes/{{ $theme->slug }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="text-sm font-medium">{{ $theme->creator->name ?? 'System' }}</div>
                                                <div class="text-xs text-muted-foreground">{{ $theme->creator->email ?? '-' }}</div>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                @if($theme->is_premium)
                                                    <span class="inline-flex items-center rounded-full bg-amber-500/10 px-2 py-0.5 text-[10px] font-bold text-amber-500">PRO</span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-blue-500/10 px-2 py-0.5 text-[10px] font-bold text-blue-500">FREE</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <div class="flex flex-col items-center gap-1">
                                                    @if($theme->is_approved)
                                                        <span class="inline-flex items-center rounded-full bg-emerald-500/10 px-2 py-0.5 text-[10px] font-bold text-emerald-500">ONAYLI</span>
                                                    @else
                                                        <span class="inline-flex items-center rounded-full bg-amber-500/10 px-2 py-0.5 text-[10px] font-bold text-amber-500">BEKLIYOR</span>
                                                    @endif

                                                    @if($theme->is_active)
                                                        <span class="inline-flex items-center rounded-full bg-blue-500/10 px-2 py-0.5 text-[10px] font-bold text-blue-500">AKTIF</span>
                                                    @else
                                                        <span class="inline-flex items-center rounded-full bg-destructive/10 px-2 py-0.5 text-[10px] font-bold text-destructive">PASIF</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <form action="{{ route('admin.themes.approve', $theme) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="h-8 px-3 rounded-md border border-border text-xs font-medium transition-colors {{ $theme->is_approved ? 'hover:bg-amber-50 hover:text-amber-600' : 'bg-emerald-500 text-white hover:bg-emerald-600' }}">
                                                            {{ $theme->is_approved ? 'Onayı Kaldır' : 'Onayla' }}
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.themes.toggle', $theme) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="h-8 px-3 rounded-md border border-border text-xs font-medium transition-colors hover:bg-accent">
                                                            {{ $theme->is_active ? 'Durdur' : 'Aktif Et' }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-sm text-muted-foreground">Tema bulunamadı.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($themes->hasPages())
                            <div class="bg-muted/30 p-4 border-t border-border">
                                {{ $themes->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
