<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 px-4">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-700">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 dark:bg-indigo-900/30 rounded-full mb-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Password Protected</h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">This link is protected. Please enter the password to continue.</p>
            </div>

            <form method="POST" action="{{ route('public.verify-password', $link) }}">
                @csrf
                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus />
                </div>

                @if ($errors->any())
                    <div class="mt-3 text-sm text-red-600 dark:text-red-400">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="w-full justify-center py-3">
                        Continue to Link
                    </x-primary-button>
                </div>
            </form>
            
            <div class="mt-8 text-center">
                <a href="{{ route('public.profile', $link->user->username) }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                    &larr; Back to profile
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
