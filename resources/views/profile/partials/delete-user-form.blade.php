<section class="space-y-6">
    <x-section-header 
        :title="__('Hesabı Sil')" 
        :subtitle="__('Hesabınızı sildiğinizde, tüm verileriniz ve kaynaklarınız kalıcı olarak silinecektir. Lütfen bu işlemi geri alamayacağınızı unutmayın.')" 
    />

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-8 py-3 rounded-2xl bg-red-50 text-red-600 border border-red-100 dark:bg-red-900/10 dark:text-red-400 dark:border-red-900/30 font-black text-[10px] uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-sm shadow-red-500/5"
    >{{ __('Hesabı Tamamen Sil') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-white dark:bg-black rounded-3xl">
            @csrf
            @method('delete')

            <h2 class="text-sm font-black text-gray-900 dark:text-gray-100 uppercase tracking-widest mb-4">
                {{ __('Hesabınızı silmek istediğinizden emin misiniz?') }}
            </h2>

            <p class="text-xs font-bold text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                {{ __('Devam etmek için lütfen şifrenizi girin. Bu işlem sonucunda sayfanız ve tüm istatistikleriniz kalıcı olarak yok edilecektir.') }}
            </p>

            <div class="space-y-2">
                <x-input-label for="password" value="{{ __('Şifre') }}" class="text-[10px] font-black uppercase text-gray-400" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full rounded-2xl border-gray-100 dark:border-gray-800 dark:bg-black focus:ring-red-500 focus:border-red-500"
                    placeholder="{{ __('Devam etmek için şifre girin') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6 py-2.5 text-[10px] uppercase font-black tracking-widest">
                    {{ __('İptal') }}
                </x-secondary-button>

                <x-danger-button class="rounded-xl px-6 py-2.5 text-[10px] uppercase font-black tracking-widest bg-red-600 text-white shadow-xl shadow-red-500/20">
                    {{ __('Onayla ve Sil') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
