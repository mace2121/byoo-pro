<x-app-layout>
    <div class="px-4 md:px-8 py-8">
        <x-section-header 
            :title="__('Ayarlar')" 
            :subtitle="__('Hesap bilgilerinizi, güvenlik ayarlarınızı ve sayfa temanızı buradan yönetin.')" 
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

            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm overflow-hidden">
                <div class="p-6 border-b border-[hsl(var(--border))]">
                    <h3 class="text-lg font-semibold leading-none tracking-tight">{{ __('Görünüm Ayarları') }}</h3>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-theme-form')
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
