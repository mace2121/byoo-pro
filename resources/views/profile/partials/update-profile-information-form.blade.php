<section>
    <x-section-header 
        :title="__('Profil Bilgileri')" 
        :subtitle="__('Hesabınızın temel bilgilerini ve profil resminizi buradan güncelleyebilirsiniz.')" 
    />

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-8" enctype="multipart/form-data" @submit="$dispatch('profile-updated')">
        @csrf
        @method('patch')

        <div class="flex items-center gap-8 p-6 bg-gray-50 dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-800">
            <div class="shrink-0 relative group">
                <img id="avatar-preview" class="h-20 w-20 object-cover rounded-2xl border-4 border-white dark:border-black shadow-xl transition-transform group-hover:scale-105" 
                     src="{{ $user->profile?->avatar_url }}" 
                     alt="Avatar" />
                <div class="absolute -bottom-2 -right-2 bg-black dark:bg-white text-white dark:text-black w-7 h-7 rounded-full flex items-center justify-center shadow-lg border-2 border-white dark:border-black">
                    <i class="fas fa-camera text-[10px]"></i>
                </div>
            </div>
            <div class="flex-1">
                <x-input-label for="avatar" :value="__('Profil Fotoğrafı')" class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2" />
                <input type="file" name="avatar" id="avatar" accept="image/*"
                       class="block w-full text-[10px] text-gray-400 font-black uppercase
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-xl file:border-0
                              file:text-[10px] file:font-black file:uppercase
                              file:bg-black file:text-white dark:file:bg-white dark:file:text-black hover:opacity-80" />
                <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-2">
                <x-input-label for="username" :value="__('Kullanıcı Adı')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                <x-text-input id="username" name="username" type="text" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black focus:ring-black focus:border-black" :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="name" :value="__('Görünen İsim')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                <x-text-input id="name" name="name" type="text" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black focus:ring-black focus:border-black" :value="old('name', $user->name)" required autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        </div>

        <div class="space-y-2">
            <x-input-label for="bio" :value="__('Biyografi')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
            <textarea id="bio" name="bio" rows="3" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black focus:ring-black focus:border-black text-sm">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="p-8 bg-gray-50 dark:bg-gray-900 rounded-[3rem] border border-gray-100 dark:border-gray-800 space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <i class="fas fa-search text-black dark:text-white"></i>
                <h3 class="text-[10px] font-black uppercase tracking-widest text-gray-900 dark:text-gray-100">{{ __('SEO & Arama Ayarları') }}</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <x-input-label for="meta_title" :value="__('Meta Başlık')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                    <x-text-input id="meta_title" name="meta_title" type="text" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black" :value="old('meta_title', $user->profile->meta_title ?? '')" placeholder="Google'da nasıl görünsün?" />
                </div>

                <div class="space-y-2">
                    <x-input-label for="meta_description" :value="__('Meta Açıklama')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                    <textarea id="meta_description" name="meta_description" rows="2" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black text-xs" placeholder="Kısa bir özet yazın.">{{ old('meta_description', $user->profile->meta_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="space-y-2">
            <x-input-label for="email" :value="__('E-posta Adresi')" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
            <x-text-input id="email" name="email" type="email" class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black" :value="old('email', $user->email)" required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-4 bg-red-50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/20">
                    <p class="text-[10px] font-bold text-red-600 dark:text-red-400 uppercase tracking-widest">
                        {{ __('E-posta adresiniz doğrulanmadı.') }}
                        <button form="send-verification" class="ml-2 underline hover:text-red-800 font-black">
                            {{ __('Doğrulama maili gönder') }}
                        </button>
                    </p>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-6 border-t border-gray-100 dark:border-gray-800">
            <x-primary-button class="px-10 py-4 bg-black dark:bg-white text-white dark:text-black rounded-3xl text-xs font-black uppercase tracking-widest shadow-xl">{{ __('Kaydet') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-2 text-black dark:text-white font-black text-xs uppercase tracking-widest">
                    <i class="fas fa-check"></i>
                    {{ __('Kaydedildi') }}
                </div>
            @endif
        </div>
    </form>
</section>
