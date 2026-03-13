<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="username" value="{{ $user->username }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="bio" value="{{ $user->profile?->bio }}">
        <input type="hidden" name="theme" value="{{ $user->profile?->theme }}">

        <div class="space-y-2">
            <x-input-label for="custom_domain" :value="__('Özel Alan Adı')" class="text-xs font-medium" />
            <x-text-input id="custom_domain" name="custom_domain" type="text" :value="old('custom_domain', $user->profile?->custom_domain)" placeholder="links.site.com" />
            <x-input-error class="mt-2" :messages="$errors->get('custom_domain')" />
        </div>

        @if($user->profile?->custom_domain)
            <div class="rounded-md border border-[hsl(var(--border))] bg-[hsl(var(--muted))/30] overflow-hidden">
                <div class="p-4 bg-[hsl(var(--muted))/50] border-b border-[hsl(var(--border))]">
                    <h4 class="text-xs font-semibold flex items-center gap-2">
                        <i class="fas fa-network-wired opacity-50"></i>
                        {{ __('DNS Kurulumu') }}
                    </h4>
                </div>
                <div class="p-4 space-y-4">
                    <p class="text-[11px] text-muted-foreground leading-relaxed">
                        {{ __('Alan adınızı buraya yönlendirmek için DNS yönetim panelinizden şu A kaydını ekleyin:') }}
                    </p>
                    <div class="flex items-center justify-between bg-background p-2 rounded border border-input shadow-sm">
                        <code class="text-xs font-mono font-semibold text-primary">A @ 168.231.125.93</code>
                        <span class="text-[10px] font-semibold text-muted-foreground uppercase tracking-widest">{{ __('Sunucu IP') }}</span>
                    </div>
                    
                    <div class="pt-2 flex items-center gap-3">
                        @if($user->profile?->custom_domain_verified)
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-green-600 dark:text-green-500">
                                <i class="fas fa-check-circle"></i>
                                {{ __('Doğrulandı') }}
                            </div>
                        @else
                            <div class="flex items-center gap-1.5 text-xs font-semibold text-amber-600 dark:text-amber-500">
                                <i class="fas fa-clock"></i>
                                {{ __('Doğrulama Bekleniyor') }}
                            </div>
                            <p class="text-[10px] text-muted-foreground italic">
                                {{ __('(Yönlendirme tamamlandıktan sonra admin onayının ardından aktif olacaktır)') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4 pt-2">
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
