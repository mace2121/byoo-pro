<section>
    <x-section-header 
        :title="__('Şifre Güncelleme')" 
        :subtitle="__('Hesap güvenliğiniz için düzenli olarak karmaşık bir şifre kullanmanızı öneririz.')" 
    />

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <x-input-label for="update_password_current_password" :value="__('Mevcut Şifre')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black focus:ring-black focus:border-black" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>
            <div></div> <!-- Spacer -->

            <div class="space-y-2">
                <x-input-label for="update_password_password" :value="__('Yeni Şifre')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                <x-text-input id="update_password_password" name="password" type="password" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black focus:ring-black focus:border-black" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div class="space-y-2">
                <x-input-label for="update_password_password_confirmation" :value="__('Şifre Onayı')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black focus:ring-black focus:border-black" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-6 pt-6 border-t border-gray-100 dark:border-gray-800">
            <x-primary-button class="px-10 py-4 bg-black dark:bg-white text-white dark:text-black rounded-3xl text-sm font-black uppercase tracking-widest shadow-xl">{{ __('Şifreyi Güncelle') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-2 text-black dark:text-white font-black text-xs uppercase tracking-widest">
                    <i class="fas fa-check"></i>
                    {{ __('Güncellendi') }}
                </div>
            @endif
        </div>
    </form>
</section>
