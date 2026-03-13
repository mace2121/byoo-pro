<section class="space-y-6">
    <div class="rounded-md border border-destructive/20 bg-destructive/5 p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="space-y-1">
            <h4 class="text-sm font-semibold text-destructive flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i>
                {{ __('Kalıcı Silme') }}
            </h4>
            <p class="text-xs text-muted-foreground leading-relaxed">
                {{ __('Bu işlem geri alınamaz. Lütfen hesabınızı silmeden önce verilerinizi yedeklediğinizden emin olun.') }}
            </p>
        </div>
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('Hesabı Sil') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="space-y-4">
                <h2 class="text-lg font-semibold tracking-tight">
                    {{ __('Hesabınızı silmek istediğinizden emin misiniz?') }}
                </h2>

                <p class="text-sm text-muted-foreground leading-relaxed">
                    {{ __('Devam etmek için lütfen şifrenizi girin. Bu işlem sonucunda sayfanız ve tüm istatistikleriniz kalıcı olarak yok edilecektir.') }}
                </p>

                <div class="space-y-2">
                    <x-input-label for="password" value="{{ __('Şifre') }}" class="text-xs font-medium" />
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full"
                        placeholder="{{ __('Onaylamak için şifrenizi girin') }}"
                    />
                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('İptal') }}
                </x-secondary-button>

                <x-danger-button>
                    {{ __('Hesabı kalıcı olarak sil') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
