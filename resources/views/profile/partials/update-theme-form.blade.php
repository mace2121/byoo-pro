<section>
    <form method="post" action="{{ route('profile.update') }}" class="space-y-10" enctype="multipart/form-data" x-data="{ 
        themeType: '{{ $user->profile?->theme_type ?? 'preset' }}',
        bgType: '{{ $user->profile?->bg_type ?? 'color' }}'
    }" @submit="$dispatch('profile-updated')">
        @csrf
        @method('patch')

        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="username" value="{{ $user->username }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="bio" value="{{ $user->profile?->bio }}">

        <!-- Theme Type Selector (Shadcn Tabs) -->
        <div class="inline-flex h-10 items-center justify-center rounded-md bg-[hsl(var(--muted))] p-1 text-[hsl(var(--muted-foreground))]">
            <button type="button" 
                @click="themeType = 'preset'" 
                :class="themeType === 'preset' ? 'bg-background text-foreground shadow-sm' : 'hover:text-foreground'"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-6 py-1.5 text-xs font-semibold ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
                {{ __('Hazır Temalar') }}
            </button>
            <button type="button" 
                @click="themeType = 'custom'" 
                :class="themeType === 'custom' ? 'bg-background text-foreground shadow-sm' : 'hover:text-foreground'"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-6 py-1.5 text-xs font-semibold ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50">
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
                        <div class="relative rounded-lg border border-[hsl(var(--border))] p-2 peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-ring transition-all hover:bg-accent/50">
                            <div class="aspect-[4/3] rounded-md mb-2 flex flex-col items-center justify-center p-3 transition-transform group-hover:scale-95" style="background-color: {{ $theme['bg'] }};">
                                <div class="w-full space-y-1.5 opacity-20">
                                    <div class="h-1.5 w-full rounded-full" style="background-color: {{ $theme['text'] }};"></div>
                                    <div class="h-1.5 w-3/4 rounded-full" style="background-color: {{ $theme['text'] }};"></div>
                                    <div class="h-4 w-full rounded-md mt-2" style="background-color: {{ $theme['accent'] }};"></div>
                                </div>
                            </div>
                            <div class="text-center">
                                <span class="text-[10px] font-semibold text-muted-foreground uppercase tracking-widest">{{ $theme['label'] }}</span>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Custom Design Section (Monochrome) -->
        <div x-show="themeType === 'custom'" x-cloak x-transition class="space-y-8">
            <!-- Background Configuration -->
            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[hsl(var(--border))] bg-[hsl(var(--muted))/30]">
                    <h3 class="text-xs font-semibold uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-image opacity-50"></i>
                        {{ __('Arka Plan Yapılandırması') }}
                    </h3>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <x-input-label value="Stil Tipi" class="text-xs font-medium" />
                        <select name="bg_type" x-model="bgType" class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                            <option value="color">Düz Renk</option>
                            <option value="gradient">Gradyan (Monokrom)</option>
                            <option value="image">Özel Görsel</option>
                        </select>
                    </div>

                    <div x-show="bgType === 'color'" x-transition class="space-y-2">
                        <x-input-label value="Renk Seçimi" class="text-xs font-medium" />
                        <div class="flex items-center gap-4">
                            <div class="relative w-10 h-10 rounded-md overflow-hidden border border-input">
                                <input type="color" name="bg_color" value="{{ $user->profile?->bg_color ?? '#ffffff' }}" class="absolute inset-0 w-full h-full scale-150 cursor-pointer">
                            </div>
                            <span class="text-xs font-mono text-muted-foreground">{{ $user->profile?->bg_color ?? '#ffffff' }}</span>
                        </div>
                    </div>

                    <div x-show="bgType === 'gradient'" class="col-span-full space-y-4" x-transition>
                        <x-input-label value="Monokrom Gradyanlar" class="text-xs font-medium" />
                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
                            @foreach([
                                'linear-gradient(to bottom, #ffffff, #f3f4f6)' => 'Light',
                                'linear-gradient(to bottom, #ffffff, #000000)' => 'Fade',
                                'linear-gradient(to bottom, #171717, #000000)' => 'Night',
                                'linear-gradient(to bottom, #404040, #171717)' => 'Charcoal',
                                'radial-gradient(circle, #ffffff, #e5e5e5)' => 'Radial',
                                'linear-gradient(45deg, #000000, #262626)' => 'Diagonal'
                            ] as $grad => $label)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="bg_gradient" value="{{ $grad }}" class="sr-only peer" {{ ($user->profile?->bg_gradient ?? '') === $grad ? 'checked' : '' }}>
                                    <div class="h-12 rounded-md border border-input peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-ring transition-all" style="background: {{ $grad }}"></div>
                                    <span class="text-[9px] font-medium text-muted-foreground uppercase mt-1.5 block text-center truncate">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div x-show="bgType === 'image'" class="col-span-full" x-transition>
                        <div class="p-6 rounded-md border border-dashed border-input bg-muted/20 text-center">
                            <x-input-label for="bg_image" value="Görsel Yükle (1920x1080 Önerilir)" class="text-xs font-medium mb-4" />
                            <input type="file" id="bg_image" name="bg_image" class="block w-full text-xs text-muted-foreground file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border file:border-input file:text-xs file:font-semibold file:bg-background file:text-foreground hover:file:bg-accent cursor-pointer" />
                            @if($user->profile?->bg_image)
                                <div class="mt-4 flex items-center justify-center gap-2 text-[10px] text-primary">
                                    <i class="fas fa-check-circle"></i>
                                    <span class="font-medium">{{ basename($user->profile->bg_image) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aesthetic Details -->
            <div class="rounded-lg border border-[hsl(var(--border))] bg-[hsl(var(--card))] shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-[hsl(var(--border))] bg-[hsl(var(--muted))/30]">
                    <h3 class="text-xs font-semibold uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-palette opacity-50"></i>
                        {{ __('Estetik Ayrıntılar') }}
                    </h3>
                </div>

                <div class="p-6 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="space-y-3">
                            <x-input-label value="Yazı Rengi" class="text-xs font-medium" />
                            <div class="flex items-center gap-3">
                                <div class="relative w-10 h-10 rounded-md overflow-hidden border border-input shadow-sm">
                                    <input type="color" name="text_color" value="{{ $user->profile?->text_color ?? '#000000' }}" class="absolute inset-0 w-full h-full scale-150 cursor-pointer">
                                </div>
                                <span class="text-xs font-mono text-muted-foreground">{{ $user->profile?->text_color ?? '#000000' }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <x-input-label value="Buton Rengi" class="text-xs font-medium" />
                            <div class="flex items-center gap-3">
                                <div class="relative w-10 h-10 rounded-md overflow-hidden border border-input shadow-sm">
                                    <input type="color" name="button_color" value="{{ $user->profile?->button_color ?? '#000000' }}" class="absolute inset-0 w-full h-full scale-150 cursor-pointer">
                                </div>
                                <span class="text-xs font-mono text-muted-foreground">{{ $user->profile?->button_color ?? '#000000' }}</span>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <x-input-label value="Buton Metin Rengi" class="text-xs font-medium" />
                            <div class="flex items-center gap-3">
                                <div class="relative w-10 h-10 rounded-md overflow-hidden border border-input shadow-sm">
                                    <input type="color" name="button_text_color" value="{{ $user->profile?->button_text_color ?? '#ffffff' }}" class="absolute inset-0 w-full h-full scale-150 cursor-pointer">
                                </div>
                                <span class="text-xs font-mono text-muted-foreground">{{ $user->profile?->button_text_color ?? '#ffffff' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                        <div class="space-y-2">
                            <x-input-label value="Buton Köşe Stili" class="text-xs font-medium" />
                            <select name="button_style" class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                                <option value="pill" {{ ($user->profile?->button_style ?? 'pill') === 'pill' ? 'selected' : '' }}>Oval (Modern)</option>
                                <option value="rounded" {{ ($user->profile?->button_style ?? 'pill') === 'rounded' ? 'selected' : '' }}>Yumuşak Kare</option>
                                <option value="square" {{ ($user->profile?->button_style ?? 'pill') === 'square' ? 'selected' : '' }}>Keskin</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <x-input-label value="Tipografi" class="text-xs font-medium" />
                            <select name="font_family" class="flex h-9 w-full rounded-md border border-input bg-background px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
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
        </div>

        <div class="flex items-center gap-4 pt-6">
            <x-primary-button>{{ __('Yapılandırmayı Kaydet') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="flex items-center gap-2 text-sm font-medium text-primary">
                    <i class="fas fa-check-circle"></i>
                    {{ __('Güncellendi') }}
                </div>
            @endif
        </div>
    </form>
</section>
