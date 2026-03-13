<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Custom Domain') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Connect a custom domain to your profile (e.g. links.mysite.com).') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="username" value="{{ $user->username }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="bio" value="{{ $user->profile?->bio }}">
        <input type="hidden" name="theme" value="{{ $user->profile?->theme }}">

        <div>
            <x-input-label for="custom_domain" :value="__('Custom Domain')" />
            <x-text-input id="custom_domain" name="custom_domain" type="text" class="mt-1 block w-full" :value="old('custom_domain', $user->profile?->custom_domain)" placeholder="links.site.com" />
            <x-input-error class="mt-2" :messages="$errors->get('custom_domain')" />
        </div>

        @if($user->profile?->custom_domain)
            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
                <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">{{ __('DNS Setup:') }}</h4>
                <p class="text-xs text-gray-600 dark:text-gray-400">{{ __('To point your domain here, go to your DNS management and add the following A record:') }}</p>
                <div class="mt-3 flex items-center justify-between bg-white dark:bg-gray-800 p-2 rounded border border-gray-100 dark:border-gray-900">
                    <code class="text-xs font-mono text-indigo-600 dark:text-indigo-400">A @ 123.123.123.123</code>
                    <span class="text-[10px] text-gray-400 uppercase font-bold tracking-widest">Server IP</span>
                </div>
                
                <div class="mt-4 flex items-center">
                    @if($user->profile?->custom_domain_verified)
                        <span class="flex items-center text-xs text-green-600 dark:text-green-400 font-bold">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            {{ __('Verified') }}
                        </span>
                    @else
                        <span class="flex items-center text-xs text-amber-600 dark:text-amber-400 font-bold">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            {{ __('Pending Verification') }}
                        </span>
                        <p class="ml-2 text-[10px] text-gray-500">{{ __('(It will be active after admin approval when the redirection is complete)') }}</p>
                    @endif
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
