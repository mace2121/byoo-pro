<x-guest-layout>
    <div class="mb-8 text-center sm:text-left">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Güvenlik Onayı</h1>
        <p class="text-gray-600 dark:text-gray-400">
            {{ __('Bu alan uygulamanın güvenli bir bölgesidir. Devam etmeden önce lütfen şifrenizi doğrulayın.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Şifre')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Onayla') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
