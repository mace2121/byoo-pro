<section>
    <x-section-header 
        :title="__('Görünüm ve Tema')" 
        :subtitle="__('Profil sayfanızın tasarımını, renklerini ve genel stilini kişiselleştirin.')" 
    />

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-10" enctype="multipart/form-data" x-data="{ 
        themeType: '{{ $user->profile?->theme_type ?? 'preset' }}',
        bgType: '{{ $user->profile?->bg_type ?? 'color' }}'
    }" @submit="$dispatch('profile-updated')">
        @csrf
        @method('patch')

        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="username" value="{{ $user->username }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="bio" value="{{ $user->profile?->bio }}">

        <!-- Theme Type Selector (Monochrome) -->
        <div class="flex p-1.5 bg-gray-50 dark:bg-gray-900 rounded-2xl w-fit border border-gray-100 dark:border-gray-800">
            <button type="button" 
                @click="themeType = 'preset'" 
                :class="themeType === 'preset' ? 'bg-black text-white dark:bg-white dark:text-black shadow-xl ring-1 ring-black/5' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200'"
                class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                {{ __('Hazır Temalar') }}
            </button>
            <button type="button" 
                @click="themeType = 'custom'" 
                :class="themeType === 'custom' ? 'bg-black text-white dark:bg-white dark:text-black shadow-xl ring-1 ring-black/5' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-200'"
                class="px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all ml-1">
                {{ __('Özel Tasarım') }}
            </button>
        </div>
        <input type="hidden" name="theme_type" :value="themeType">

        <!-- Preset Themes Section -->
        <div x-show="themeType === 'preset'" x-cloak x-transition>
            @php
                $themes = [
                    'minimal' => ['label' => 'Minimal', 'bg' => '#ffffff', 'text' => '#000000', 'accent' => '#f3f4f6'],
                    'dark' => ['label' => 'Night', 'bg' => '#000000', 'text' => '#ffffff', 'accent' => '#262626'],
                    'mono' => ['label' => 'Monochrome', 'bg' => '#fafafa', 'text' => '#000000', 'accent' => '#000000'],
                    'glass' => ['label' => 'Glass', 'bg' => '#f8fafc', 'text' => '#000000', 'accent' => 'rgba(0,0,0,0.05)'],
                    'obsidian' => ['label' => 'Pitch Black', 'bg' => '#000000', 'text' => '#a3a3a3', 'accent' => '#171717'],
                ];
                $currentTheme = $user->profile?->theme ?? 'minimal';
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-5 gap-6">
                @foreach($themes as $key => $theme)
                    <label class="cursor-pointer group">
                        <input type="radio" name="theme" value="{{ $key }}" class="sr-only peer" {{ $currentTheme === $key ? 'checked' : '' }}>
                        <div class="relative rounded-[2.5rem] border border-gray-100 dark:border-gray-800 p-2 transition-all bg-white dark:bg-black peer-checked:border-black dark:peer-checked:border-white peer-checked:ring-4 peer-checked:ring-gray-50 dark:peer-checked:ring-white/5">
                            <div class="w-full h-24 rounded-[2rem] mb-2 flex flex-col items-center justify-center p-4 transition-transform group-hover:scale-95" style="background-color: {{ $theme['bg'] }};">
                                <div class="w-full space-y-1.5 opacity-20">
                                    <div class="h-2 w-full rounded-full" style="background-color: {{ $theme['text'] }};"></div>
                                    <div class="h-2 w-3/4 rounded-full" style="background-color: {{ $theme['text'] }};"></div>
                                    <div class="h-6 w-full rounded-xl mt-2" style="background-color: {{ $theme['accent'] }};"></div>
                                </div>
                            </div>
                            <div class="px-3 pb-2 text-center">
                                <span class="text-[9px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">{{ $theme['label'] }}</span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Custom Design Section (Monochrome) -->
        <div x-show="themeType === 'custom'" x-cloak x-transition class="space-y-10">
            <!-- Background Selection -->
            <div class="p-8 bg-gray-50 dark:bg-gray-900 rounded-[3rem] border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 rounded-full bg-black dark:bg-white flex items-center justify-center text-white dark:text-black">
                        <i class="fas fa-image text-xs"></i>
                    </div>
                    <h3 class="text-xs font-black text-gray-900 dark:text-gray-100 uppercase tracking-widest">Arka Plan Yapılandırması</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <x-input-label value=" Stil Tipi" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                        <select name="bg_type" x-model="bgType" class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-black text-sm focus:ring-black focus:border-black transition-all">
                            <option value="color">Düz Renk</option>
                            <option value="gradient">Gradyan (Siyah-Beyaz)</option>
                            <option value="image">Özel Görsel</option>
                        </select>
                    </div>

                    <div x-show="bgType === 'color'" x-transition>
                        <x-input-label value="Renk Seçimi" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                        <div class="mt-2 flex items-center gap-4">
                            <div class="relative w-12 h-12 rounded-full overflow-hidden border border-gray-200 shadow-inner">
                                <input type="color" name="bg_color" value="{{ $user->profile?->bg_color ?? '#ffffff' }}" class="absolute inset-0 w-full h-full scale-150 cursor-pointer">
                            </div>
                            <span class="text-xs font-black text-gray-400 font-mono">{{ $user->profile?->bg_color ?? '#ffffff' }}</span>
                        </div>
                    </div>

                    <div x-show="bgType === 'gradient'" class="col-span-full" x-transition>
                        <x-input-label value="Monokrom Gradyanlar" class="text-[10px] font-black uppercase tracking-widest text-gray-400" />
                        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 mt-4">
                            @foreach([
                                'linear-gradient(to bottom, #ffffff, #f3f4f6)' => 'Light Gray',
                                'linear-gradient(to bottom, #ffffff, #000000)' => 'BW Fade',
                                'linear-gradient(to bottom, #171717, #000000)' => 'Dark Night',
                                'linear-gradient(to bottom, #404040, #171717)' => 'Charcoal',
                                'radial-gradient(circle, #ffffff, #e5e5e5)' => 'Radial Light',
                                'linear-gradient(45deg, #000000, #262626)' => 'Diagonal'
                            ] as $grad => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="bg_gradient" value="{{ $grad }}" class="sr-only peer" {{ ($user->profile?->bg_gradient ?? '') === $grad ? 'checked' : '' }}>
                                    <div class="h-14 rounded-2xl border-2 border-transparent peer-checked:border-black dark:peer-checked:border-white shadow-sm transition-all" style="background: {{ $grad }}"></div>
                                    <span class="text-[9px] font-black text-gray-400 uppercase mt-2 block text-center tracking-tighter">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div x-show="bgType === 'image'" class="col-span-full" x-transition>
                        <div class="p-6 bg-white dark:bg-black rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-800 text-center">
                            <x-input-label for="bg_image" value="Görsel Yükle (Önerilen: 1920x1080)" class="text-xs font-bold mb-4" />
                            <input type="file" id="bg_image" name="bg_image" class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-black file:text-white dark:file:bg-white dark:file:text-black cursor-pointer" />
                            @if($user->profile?->bg_image)
                                <div class="mt-4 flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    <span class="text-[10px] font-black text-gray-400 uppercase uppercase">{{ basename($user->profile->bg_image) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- UI Aesthetics -->
            <div class="p-8 bg-gray-50 dark:bg-gray-900 rounded-[3rem] border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-8 h-8 rounded-full bg-black dark:bg-white flex items-center justify-center text-white dark:text-black">
                        <i class="fas fa-palette text-xs"></i>
                    </div>
                    <h3 class="text-xs font-black text-gray-900 dark:text-gray-100 uppercase tracking-widest">Estetik Ayrıntılar</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-4">
                        <x-input-label value="Yazı Rengi" class="text-[10px] font-black uppercase text-gray-400" />
                        <div class="flex items-center gap-3">
                            <input type="color" name="text_color" value="{{ $user->profile?->text_color ?? '#000000' }}" class="h-10 w-10 overflow-hidden rounded-full border-2 border-white shadow-sm cursor-pointer">
                            <span class="text-xs font-bold font-mono">{{ $user->profile?->text_color ?? '#000000' }}</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <x-input-label value="Buton Rengi" class="text-[10px] font-black uppercase text-gray-400" />
                        <div class="flex items-center gap-3">
                            <input type="color" name="button_color" value="{{ $user->profile?->button_color ?? '#000000' }}" class="h-10 w-10 overflow-hidden rounded-full border-2 border-white shadow-sm cursor-pointer">
                            <span class="text-xs font-bold font-mono">{{ $user->profile?->button_color ?? '#000000' }}</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <x-input-label value="Buton Metin Rengi" class="text-[10px] font-black uppercase text-gray-400" />
                        <div class="flex items-center gap-3">
                            <input type="color" name="button_text_color" value="{{ $user->profile?->button_text_color ?? '#ffffff' }}" class="h-10 w-10 overflow-hidden rounded-full border-2 border-white shadow-sm cursor-pointer">
                            <span class="text-xs font-bold font-mono">{{ $user->profile?->button_text_color ?? '#ffffff' }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-10">
                    <div class="space-y-2">
                        <x-input-label value="Buton Köşe Stili" class="text-[10px] font-black uppercase text-gray-400" />
                        <select name="button_style" class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-black text-sm focus:ring-black focus:border-black transition-all">
                            <option value="pill" {{ ($user->profile?->button_style ?? 'pill') === 'pill' ? 'selected' : '' }}>Oval (Modern)</option>
                            <option value="rounded" {{ ($user->profile?->button_style ?? 'pill') === 'rounded' ? 'selected' : '' }}>Yumuşak Kare</option>
                            <option value="square" {{ ($user->profile?->button_style ?? 'pill') === 'square' ? 'selected' : '' }}>Keskin</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <x-input-label value="Tipografi" class="text-[10px] font-black uppercase text-gray-400" />
                        <select name="font_family" class="block w-full rounded-2xl border-gray-200 dark:border-gray-700 dark:bg-black text-sm focus:ring-black focus:border-black transition-all">
                            <option value="inter" {{ ($user->profile?->font_family ?? 'inter') === 'inter' ? 'selected' : '' }}>Inter (Premium)</option>
                            <option value="outfit" {{ ($user->profile?->font_family ?? 'inter') === 'outfit' ? 'selected' : '' }}>Outfit (Modern)</option>
                            <option value="roboto" {{ ($user->profile?->font_family ?? 'inter') === 'roboto' ? 'selected' : '' }}>Roboto</option>
                            <option value="montserrat" {{ ($user->profile?->font_family ?? 'inter') === 'montserrat' ? 'selected' : '' }}>Montserrat</option>
                            <option value="playfair" {{ ($user->profile?->font_family ?? 'inter') === 'playfair' ? 'selected' : '' }}>Classic Serif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-6 pt-10 border-t border-gray-100 dark:border-gray-800">
            <x-primary-button class="px-10 py-4 bg-black dark:bg-white text-white dark:text-black rounded-3xl text-sm font-black uppercase tracking-[0.2em] shadow-2xl shadow-black/20 hover:scale-105 transition-all">
                {{ __('Yapılandırmayı Kaydet') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="flex items-center gap-2 text-black dark:text-white font-black text-xs uppercase tracking-widest">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Güncellendi') }}
                </div>
            @endif
        </div>
    </form>
</section>
