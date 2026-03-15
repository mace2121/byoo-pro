<x-app-layout>
    <div class="px-4 md:px-8 py-8">
        <x-section-header
            :title="__('Ayarlar')"
            :subtitle="__('Hesap bilgilerinizi, güvenlik ayarlarınızı ve alan adı yapılandırmanızı buradan yönetin.')"
            class="mb-8"
        />

        <div class="space-y-8 max-w-4xl">
            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm overflow-hidden">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-lg font-semibold leading-none tracking-tight">{{ __('Profil Bilgileri') }}</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="rounded-lg border border-primary/20 bg-primary/5 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-primary/10">
                    <h3 class="text-lg font-semibold leading-none tracking-tight">{{ __('Tasarım Editörü') }}</h3>
                </div>
                <div class="p-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-foreground">{{ __('Tasarım ayarları artık tek yerden yönetiliyor.') }}</p>
                        <p class="text-sm text-muted-foreground">{{ __('Canlı önizlemeli yeni editörü kullanmak için dashboard içindeki Tasarım sekmesine geçin.') }}</p>
                    </div>
                    <a href="{{ route('dashboard', ['tab' => 'design']) }}" class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground shadow-sm transition-colors hover:bg-primary/90">
                        <i class="fas fa-paint-brush text-xs"></i>
                        <span>{{ __('Tasarım Editörünü Aç') }}</span>
                    </a>
                </div>
            </div>

            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm overflow-hidden">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-lg font-semibold leading-none tracking-tight">{{ __('Özel Alan Adı') }}</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-custom-domain-form')
                </div>
            </div>

            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm overflow-hidden">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-lg font-semibold leading-none tracking-tight">{{ __('Şifreyi Güncelle') }}</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="rounded-lg border border-destructive/20 bg-[hsl(var(--card))] shadow-sm overflow-hidden">
                <div class="p-6 border-b border-destructive/10 bg-destructive/5 text-destructive">
                    <h3 class="text-lg font-semibold leading-none tracking-tight">{{ __('Hesabı Sil') }}</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
