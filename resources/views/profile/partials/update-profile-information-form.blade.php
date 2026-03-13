<section>
    <x-section-header 
        :title="__('Profil Bilgileri')" 
        :subtitle="__('Hesabınızın temel bilgilerini ve profil resminizi buradan güncelleyebilirsiniz.')" 
    />

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="flex items-center space-x-6">
            <div class="shrink-0">
                <img id="avatar-preview" class="h-16 w-16 object-cover rounded-full" 
                     src="{{ $user->profile?->avatar_url }}" 
                     alt="Current profile photo" />
            </div>
            <label class="block">
                <span class="sr-only">{{ __('Choose profile photo') }}</span>
                <input type="file" name="avatar" id="avatar"
                       accept="image/*"
                       class="block w-full text-sm text-slate-500 dark:text-gray-400
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100
                              dark:file:bg-indigo-900/50 dark:file:text-indigo-400" />
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Write a few sentences about yourself.') }}</p>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="border-t border-gray-100 dark:border-gray-800 pt-6 space-y-6">
            <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <i class="fas fa-search-dollar text-indigo-500"></i>
                {{ __('SEO Ayarları') }}
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="meta_title" :value="__('Sayfa Başlığı (Meta Title)')" />
                    <x-text-input id="meta_title" name="meta_title" type="text" class="mt-1 block w-full" :value="old('meta_title', $user->profile->meta_title ?? '')" placeholder="Örn: John Doe | Bio Link" />
                    <x-input-error class="mt-2" :messages="$errors->get('meta_title')" />
                </div>

                <div>
                    <x-input-label for="meta_description" :value="__('Sayfa Açıklaması (Meta Description)')" />
                    <textarea id="meta_description" name="meta_description" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Arama motorları için kısa bir açıklama.">{{ old('meta_description', $user->profile->meta_description ?? '') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('meta_description')" />
                </div>
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
