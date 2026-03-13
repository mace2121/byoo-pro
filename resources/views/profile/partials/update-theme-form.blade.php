<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Theme') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Profil sayfanız için bir tema seçin.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-8" enctype="multipart/form-data" x-data="{ 
        themeType: '{{ $user->profile?->theme_type ?? 'preset' }}',
        bgType: '{{ $user->profile?->bg_type ?? 'color' }}'
    }">
        @csrf
        @method('patch')

        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="username" value="{{ $user->username }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="bio" value="{{ $user->profile?->bio }}">

        <!-- Theme Type Selector -->
        <div class="flex p-1 bg-gray-100 dark:bg-gray-900 rounded-xl w-fit">
            <button type="button" 
                @click="themeType = 'preset'" 
                :class="themeType === 'preset' ? 'bg-white dark:bg-gray-800 shadow text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 rounded-lg text-sm font-bold transition-all">
                Preset Themes
            </button>
            <button type="button" 
                @click="themeType = 'custom'" 
                :class="themeType === 'custom' ? 'bg-white dark:bg-gray-800 shadow text-indigo-600 dark:text-indigo-400' : 'text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 rounded-lg text-sm font-bold transition-all ml-1">
                Custom Design
            </button>
        </div>
        <input type="hidden" name="theme_type" :value="themeType">

        <!-- Preset Themes Section -->
        <div x-show="themeType === 'preset'" x-cloak>
            @php
                $themes = [
                    'minimal' => ['label' => 'Minimal', 'bg' => '#f9fafb', 'text' => '#111827', 'accent' => '#e5e7eb'],
                    'dark' => ['label' => 'Dark', 'bg' => '#0f172a', 'text' => '#f1f5f9', 'accent' => '#334155'],
                    'neon' => ['label' => 'Neon', 'bg' => '#0a0a0a', 'text' => '#39ff14', 'accent' => '#39ff14'],
                    'glass' => ['label' => 'Glass', 'bg' => '#667eea', 'text' => '#ffffff', 'accent' => 'rgba(255,255,255,0.3)'],
                    'midnight' => ['label' => 'Midnight', 'bg' => '#1a1a2e', 'text' => '#e0e0ff', 'accent' => '#0f3460'],
                    'sunset' => ['label' => 'Sunset', 'bg' => '#f5576c', 'text' => '#ffffff', 'accent' => 'rgba(255,255,255,0.3)'],
                    'aurora' => ['label' => 'Aurora', 'bg' => '#0c3547', 'text' => '#a7f3d0', 'accent' => '#34d399'],
                    'forest' => ['label' => 'Forest', 'bg' => '#1a2f1a', 'text' => '#d4edda', 'accent' => '#5cb85c'],
                    'cyber' => ['label' => 'Cyber', 'bg' => '#0d0221', 'text' => '#ff00ff', 'accent' => '#00ffff'],
                    'obsidian' => ['label' => 'Obsidian', 'bg' => '#121212', 'text' => '#e0e0e0', 'accent' => '#333333'],
                ];
                $currentTheme = $user->profile?->theme ?? 'minimal';
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                @foreach($themes as $key => $theme)
                    <label class="cursor-pointer">
                        <input type="radio" name="theme" value="{{ $key }}" class="sr-only peer" {{ $currentTheme === $key ? 'checked' : '' }}>
                        <div class="rounded-lg border-2 p-3 text-center transition-all peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-200 border-gray-200 dark:border-gray-600 hover:border-gray-300">
                            <div class="mx-auto w-full h-8 rounded-md mb-2 flex items-center justify-center" style="background-color: {{ $theme['bg'] }}; border: 1px solid {{ $theme['accent'] }};">
                                <span class="text-xs font-bold" style="color: {{ $theme['text'] }};">Aa</span>
                            </div>
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $theme['label'] }}</span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Custom Design Section -->
        <div x-show="themeType === 'custom'" x-cloak class="space-y-6">
            <!-- Background Section -->
            <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Arka Plan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label value="Arka Plan Tipi" />
                        <select name="bg_type" x-model="bgType" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                            <option value="color">Düz Renk</option>
                            <option value="image">Görsel</option>
                        </select>
                    </div>

                    <div x-show="bgType === 'color'">
                        <x-input-label for="bg_color" value="Renk" />
                        <div class="mt-1 flex gap-2">
                            <input type="color" id="bg_color" name="bg_color" value="{{ $user->profile?->bg_color ?? '#f9fafb' }}" class="h-10 w-20 rounded p-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
                            <x-text-input value="{{ $user->profile?->bg_color ?? '#f9fafb' }}" class="flex-1 text-sm" />
                        </div>
                    </div>

                    <div x-show="bgType === 'image'">
                        <x-input-label for="bg_image" value="Arka Plan Görseli" />
                        <input type="file" id="bg_image" name="bg_image" class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400" />
                        @if($user->profile?->bg_image)
                            <p class="mt-2 text-[10px] text-gray-400">Mevcut görsel: {{ basename($user->profile->bg_image) }}</p>
                        @endif
                    </div>
                </div>

                <div x-show="bgType === 'image'" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <x-input-label value="Bulanıklık (Blur) : " x-text="'Bulanıklık (Blur): ' + $refs.bg_blur.value + 'px'" />
                        <input type="range" name="bg_blur" x-ref="bg_blur" min="0" max="20" value="{{ $user->profile?->bg_blur ?? 0 }}" class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-indigo-600 mt-2">
                    </div>
                    <div>
                        <x-input-label value="Koyuluk (Overlay) : " x-text="'Koyuluk (Overlay): ' + $refs.bg_overlay.value + '%'" />
                        <input type="range" name="bg_overlay" x-ref="bg_overlay" min="0" max="90" value="{{ $user->profile?->bg_overlay ?? 0 }}" class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-indigo-600 mt-2">
                    </div>
                </div>
            </div>

            <!-- Buttons & Colors Section -->
            <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" /></svg>
                    Renkler ve Butonlar
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-input-label value="Yazı Rengi" />
                        <input type="color" name="text_color" value="{{ $user->profile?->text_color ?? '#111827' }}" class="mt-1 h-10 w-full rounded p-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
                    </div>
                    <div>
                        <x-input-label value="Buton Rengi" />
                        <input type="color" name="button_color" value="{{ $user->profile?->button_color ?? '#ffffff' }}" class="mt-1 h-10 w-full rounded p-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
                    </div>
                    <div>
                        <x-input-label value="Buton Yazı Rengi" />
                        <input type="color" name="button_text_color" value="{{ $user->profile?->button_text_color ?? '#111827' }}" class="mt-1 h-10 w-full rounded p-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <x-input-label value="Buton Stili" />
                        <select name="button_style" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                            <option value="rounded" {{ ($user->profile?->button_style ?? 'rounded') === 'rounded' ? 'selected' : '' }}>Köşeli (Hafif)</option>
                            <option value="pill" {{ ($user->profile?->button_style ?? 'rounded') === 'pill' ? 'selected' : '' }}>Oval (Pill)</option>
                            <option value="square" {{ ($user->profile?->button_style ?? 'rounded') === 'square' ? 'selected' : '' }}>Keskin (Kare)</option>
                            <option value="soft" {{ ($user->profile?->button_style ?? 'rounded') === 'soft' ? 'selected' : '' }}>Yumuşak (Soft)</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label value="Yazı Tipi (Font)" />
                        <select name="font_family" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                            <option value="sans" {{ ($user->profile?->font_family ?? 'sans') === 'sans' ? 'selected' : '' }}>Modern (Sans)</option>
                            <option value="inter" {{ ($user->profile?->font_family ?? 'sans') === 'inter' ? 'selected' : '' }}>Inter</option>
                            <option value="poppins" {{ ($user->profile?->font_family ?? 'sans') === 'poppins' ? 'selected' : '' }}>Poppins</option>
                            <option value="serif" {{ ($user->profile?->font_family ?? 'sans') === 'serif' ? 'selected' : '' }}>Klasik (Serif)</option>
                            <option value="mono" {{ ($user->profile?->font_family ?? 'sans') === 'mono' ? 'selected' : '' }}>Teknik (Mono)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Advanced Section -->
            <div class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-2xl border border-gray-100 dark:border-gray-800">
                <h3 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                    Gelişmiş (Custom CSS)
                </h3>
                <textarea name="custom_css" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-xs font-mono" rows="4" placeholder="/* Kendi CSS kodlarınızı buraya yazabilirsiniz */">{{ $user->profile?->custom_css }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-4 pt-6 border-t border-gray-100 dark:border-gray-800">
            <x-primary-button class="px-8 py-3">{{ __('Tasarladıklarımı Kaydet') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 dark:text-green-400 font-medium">
                    {{ __('Değişiklikler başarıyla kaydedildi.') }}
                </p>
            @endif
        </div>
    </form>
</section>
