<x-guest-layout>
    <div class="mb-8 text-center sm:text-left">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">E-posta Doğrulama</h1>
        <p class="text-gray-600 dark:text-gray-400">
            {{ __('Kayıt olduğunuz için teşekkürler! Başlamadan önce, size az önce gönderdiğimiz bağlantıya tıklayarak e-posta adresinizi doğrulayabilir misiniz? Eğer e-postayı almadıysanız, size memnuniyetle başka bir tane gönderebiliriz.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-4 rounded-md">
            {{ __('Kayıt olurken belirttiğiniz e-posta adresine yeni bir doğrulama bağlantısı gönderildi.') }}
        </div>
    @endif

    <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <div>
                <x-primary-button class="w-full sm:w-auto justify-center">
                    {{ __('Doğrulama E-postasını Tekrar Gönder') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto text-center underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Çıkış Yap') }}
            </button>
        </form>
    </div>
</x-guest-layout>
