<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-4">
            <div class="space-y-2">
                <x-input-label for="update_password_current_password" :value="__('Mevcut Şifre')" class="text-xs font-medium" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="max-w-md" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <x-input-label for="update_password_password" :value="__('Yeni Şifre')" class="text-xs font-medium" />
                    <x-text-input id="update_password_password" name="password" type="password" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div class="space-y-2">
                    <x-input-label for="update_password_password_confirmation" :value="__('Şifre Onayı')" class="text-xs font-medium" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('Şifreyi Güncelle') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-2 text-sm font-medium text-primary">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Güncellendi') }}
                </div>
            @endif
        </div>
    </form>
</section>
