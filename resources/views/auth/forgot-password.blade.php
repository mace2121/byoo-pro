<x-guest-layout>
    <div class="mb-8 text-center sm:text-left">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">Şifremi Unuttum</h1>
        <p class="text-gray-600 dark:text-gray-400">
            {{ __('Şifrenizi mi unuttunuz? Sorun değil. Sadece e-posta adresinizi bize bildirin ve size yeni bir şifre seçmenizi sağlayacak bir şifre sıfırlama bağlantısı gönderelim.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-posta')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Şifre Sıfırlama Bağlantısı Gönder') }}
            </x-primary-button>
        </div>
    </form>

    <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
            &larr; Giriş sayfasına dön
        </a>
    </p>
</x-guest-layout>
