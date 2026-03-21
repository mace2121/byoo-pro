<x-app-layout>
    <div class="h-full flex">
        @include('admin.partials.sidebar')

        <div class="flex-1 min-w-0 flex flex-col">
            @include('admin.partials.navbar')

            <main class="flex-1 overflow-y-auto bg-background">
                <div class="max-w-6xl mx-auto p-6 md:p-10 space-y-8">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Yonetici Paneli</h1>
                        <p class="mt-1 text-sm text-muted-foreground">Platform genelindeki kullanici hareketlerini ve sistem istatistiklerini izleyin.</p>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="rounded-lg border border-border bg-card p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-muted-foreground">Toplam Kullanıcı</p>
                                <i class="fas fa-users text-muted-foreground/50"></i>
                            </div>
                            <p class="text-2xl font-bold mt-2">{{ number_format($total_users) }}</p>
                        </div>
                        <div class="rounded-lg border border-amber-200/50 bg-amber-50/10 p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-amber-700/70">Pro Kullanıcı</p>
                                <i class="fas fa-crown text-amber-500/70"></i>
                            </div>
                            <p class="text-2xl font-bold mt-2 text-amber-600">{{ number_format($pro_users) }}</p>
                        </div>
                        <div class="rounded-lg border border-border bg-card p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-muted-foreground">Free Kullanıcı</p>
                                <i class="fas fa-user text-muted-foreground/50"></i>
                            </div>
                            <p class="text-2xl font-bold mt-2">{{ number_format($free_users) }}</p>
                        </div>
                        <div class="rounded-lg border border-emerald-200/50 bg-emerald-50/10 p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-emerald-700/70">Tahmini Aylık Gelir</p>
                                <i class="fas fa-dollar-sign text-emerald-500/70"></i>
                            </div>
                            <p class="text-2xl font-bold mt-2 text-emerald-600">${{ number_format($monthly_revenue) }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="rounded-lg border border-border bg-card shadow-sm">
                            <div class="p-6 border-b border-border">
                                <h3 class="text-sm font-semibold flex items-center gap-2">
                                    <i class="fas fa-fire text-orange-500 text-xs"></i>
                                    Populer Profiller
                                </h3>
                            </div>
                            <div class="p-4 space-y-2">
                                @foreach($popular_profiles as $profile)
                                    <div class="flex items-center justify-between p-3 rounded-md hover:bg-accent transition-colors">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $profile->avatar_url }}" class="w-9 h-9 rounded-full object-cover border border-border">
                                            <div>
                                                <div class="flex items-center gap-1.5">
                                                    <p class="text-sm font-semibold">{{ $profile->user->name }}</p>
                                                    @if($profile->user->verified)
                                                        <x-verified-badge size="sm" />
                                                    @endif
                                                </div>
                                                <p class="text-xs text-muted-foreground">{{ '@' . $profile->username }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold">{{ number_format($profile->views) }}</p>
                                            <p class="text-[10px] text-muted-foreground uppercase">goruntulenme</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-lg border border-border bg-card shadow-sm">
                            <div class="p-6 border-b border-border">
                                <h3 class="text-sm font-semibold flex items-center gap-2">
                                    <i class="fas fa-user-plus text-xs text-muted-foreground"></i>
                                    Yeni Kayitlar
                                </h3>
                            </div>
                            <div class="p-4 space-y-2">
                                @foreach($recent_users as $user)
                                    <div class="flex items-center justify-between p-3 rounded-md hover:bg-accent transition-colors">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-muted flex items-center justify-center text-sm font-semibold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-1.5">
                                                    <p class="text-sm font-semibold">{{ $user->name }}</p>
                                                    @if($user->verified)
                                                        <x-verified-badge size="sm" />
                                                    @endif
                                                </div>
                                                <p class="text-xs text-muted-foreground">{{ $user->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            @if($user->is_active)
                                                <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">AKTIF</span>
                                            @else
                                                <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">ASKIDA</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border border-border bg-card p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h3 class="text-sm font-semibold">Kullanici Yonetimi</h3>
                            <p class="text-xs text-muted-foreground mt-1">Tum platform kullanicilarini yonetin ve rozetlerini kontrol edin.</p>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-primary-foreground rounded-md text-sm font-medium hover:bg-primary/90 transition-colors shadow-sm">
                            <i class="fas fa-users-cog text-xs"></i>
                            Kullanicilari Yonet
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
