<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data" @submit="$dispatch('profile-updated')">
        @csrf
        @method('patch')

        <div class="flex flex-col sm:flex-row items-center gap-6 p-6 rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--muted))/50]">
            <div class="shrink-0 relative group">
                <img id="avatar-preview" class="h-20 w-20 object-cover rounded-md border border-[hsl(var(--border))] shadow-sm transition-all group-hover:ring-2 group-hover:ring-ring" 
                     src="{{ $user->profile?->avatar_url }}" 
                     alt="Avatar" />
                <div class="absolute -bottom-1 -right-1 bg-primary text-primary-foreground w-6 h-6 rounded-full flex items-center justify-center shadow-lg border-2 border-background">
                    <i class="fas fa-camera text-[8px]"></i>
                </div>
            </div>
            <div class="flex-1 w-full space-y-2">
                <x-input-label for="avatar" :value="__('Profil Fotoğrafı')" class="text-xs font-medium" />
                <input type="file" name="avatar" id="avatar" accept="image/*"
                       class="block w-full text-xs text-muted-foreground
                              file:mr-4 file:py-1.5 file:px-3
                              file:rounded-md file:border file:border-input
                              file:text-xs file:font-medium
                              file:bg-background file:text-foreground hover:file:bg-accent transition-colors" />
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <x-input-label for="username" :value="__('Kullanıcı Adı')" class="text-xs font-medium" />
                <x-text-input id="username" name="username" type="text" :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="name" :value="__('Görünen İsim')" class="text-xs font-medium" />
                <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        </div>

        <div class="space-y-2">
            <x-input-label for="bio" :value="__('Biyografi')" class="text-xs font-medium" />
            <textarea id="bio" name="bio" rows="3" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:cursor-not-allowed disabled:opacity-50 shadow-sm transition-colors">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--muted))/30] overflow-hidden">
            <div class="px-6 py-3 border-b border-[hsl(var(--border))] bg-[hsl(var(--muted))/50]">
                <h3 class="text-xs font-semibold uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-search opacity-50"></i>
                    {{ __('SEO & Arama Ayarları') }}
                </h3>
            </div>
            
            <div class="p-6 space-y-6">
                <div class="space-y-2">
                    <x-input-label for="meta_title" :value="__('Meta Başlık')" class="text-xs font-medium" />
                    <x-text-input id="meta_title" name="meta_title" type="text" :value="old('meta_title', $user->profile->meta_title ?? '')" placeholder="Google'da nasıl görünsün?" />
                </div>

                <div class="space-y-2">
                    <x-input-label for="meta_description" :value="__('Meta Açıklama')" class="text-xs font-medium" />
                    <textarea id="meta_description" name="meta_description" rows="2" class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring shadow-sm transition-colors" placeholder="Kısa bir özet yazın.">{{ old('meta_description', $user->profile->meta_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('E-posta Adresi')" class="text-xs font-medium" />
            <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-3 rounded-md bg-destructive/10 border border-destructive/20 text-destructive text-xs">
                    <p class="font-medium">
                        {{ __('E-posta adresiniz doğrulanmadı.') }}
                        <button form="send-verification" class="ml-2 underline font-bold hover:text-destructive/80 transition-colors">
                            {{ __('Doğrulama maili gönder') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-6">
            <x-primary-button>{{ __('Kaydet') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-2 text-sm font-medium text-primary">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Kaydedildi') }}
                </div>
            @endif
        </div>
    </form>
</section>
