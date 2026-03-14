<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Tema Seçimi') }}</h3>
            <p class="text-[10px] text-muted-foreground mt-1">{{ __('Profilinizin genel renk ve görünüm şablonunu seçin.') }}</p>
        </div>
        
        <!-- Private Theme Toggle -->
        <div class="inline-flex h-9 items-center justify-center rounded-md bg-muted/50 p-1 text-muted-foreground shadow-sm">
            <button type="button" 
                @click="draftDesign.theme.custom_theme = false" 
                :class="!draftDesign.theme.custom_theme ? 'bg-background text-foreground shadow-sm' : 'hover:text-foreground'"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-4 py-1 text-[11px] font-semibold transition-all">
                {{ __('Hazır Temalar') }}
            </button>
            <button type="button" 
                @click="draftDesign.theme.custom_theme = true" 
                :class="draftDesign.theme.custom_theme ? 'bg-background text-foreground shadow-sm' : 'hover:text-foreground'"
                class="inline-flex items-center justify-center whitespace-nowrap rounded-sm px-4 py-1 text-[11px] font-semibold transition-all">
                {{ __('Özel Tasarım') }}
            </button>
        </div>
    </div>

    @php
        $themes = [
            'minimal' => ['label' => 'Minimal', 'bg' => '#f9fafb', 'card' => '#ffffff', 'text' => '#111827', 'accent' => '#6b7280'],
            'dark' => ['label' => 'Night', 'bg' => '#0f172a', 'card' => '#1e293b', 'text' => '#f1f5f9', 'accent' => '#94a3b8'],
            'neon' => ['label' => 'Neon', 'bg' => '#0a0a0a', 'card' => '#111111', 'text' => '#39ff14', 'accent' => '#00ff88'],
            'glass' => ['label' => 'Glass', 'bg' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', 'card' => 'rgba(255,255,255,0.15)', 'text' => '#ffffff', 'accent' => 'rgba(255,255,255,0.8)'],
            'midnight' => ['label' => 'Midnight', 'bg' => '#1a1a2e', 'card' => '#16213e', 'text' => '#e0e0ff', 'accent' => '#8888bb'],
            'sunset' => ['label' => 'Sunset', 'bg' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #fda085 100%)', 'card' => 'rgba(255,255,255,0.2)', 'text' => '#ffffff', 'accent' => 'rgba(255,255,255,0.85)'],
            'aurora' => ['label' => 'Aurora', 'bg' => 'linear-gradient(135deg, #0c3547 0%, #1a5e63 40%, #204060 100%)', 'card' => 'rgba(167,243,208,0.08)', 'text' => '#a7f3d0', 'accent' => '#6ee7b7'],
            'forest' => ['label' => 'Forest', 'bg' => '#1a2f1a', 'card' => '#2d4a2d', 'text' => '#d4edda', 'accent' => '#8fbc8f'],
            'cyber' => ['label' => 'Cyber', 'bg' => '#0d0221', 'card' => 'rgba(255,0,255,0.05)', 'text' => '#ff00ff', 'accent' => '#00ffff'],
            'obsidian' => ['label' => 'Pitch Black', 'bg' => '#121212', 'card' => '#1e1e1e', 'text' => '#e0e0e0', 'accent' => '#888888'],
        ];
    @endphp

    <div x-show="!draftDesign.theme.custom_theme" x-cloak x-transition class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-4">
        @foreach($themes as $key => $theme)
            <label class="cursor-pointer group flex flex-col gap-2">
                <input type="radio" x-model="draftDesign.theme.preset" value="{{ $key }}" class="sr-only peer">
                <!-- Preset Card Preview -->
                <div class="relative rounded-xl border-2 border-transparent peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/20 transition-all hover:scale-[1.02] overflow-hidden aspect-[3/4] shadow-sm flex flex-col justify-between" style="background: {{ $theme['bg'] }};">
                    
                    <div class="flex flex-col items-center mt-4 space-y-2">
                        <div class="w-8 h-8 rounded-full" style="background-color: {{ $theme['card'] }}; border: 1px solid {{ $theme['accent'] }};"></div>
                        <div class="w-12 h-1.5 rounded-full" style="background-color: {{ $theme['text'] }};"></div>
                        <div class="w-8 h-1 rounded-full" style="background-color: {{ $theme['accent'] }};"></div>
                    </div>
                    
                    <div class="p-3 space-y-2">
                        <div class="w-full h-4 rounded-md" style="background-color: {{ $theme['card'] }}; border: 1px solid {{ str_contains($theme['card'], 'rgba') ? 'transparent' : $theme['accent'] }}40;"></div>
                        <div class="w-full h-4 rounded-md" style="background-color: {{ $theme['card'] }}; border: 1px solid {{ str_contains($theme['card'], 'rgba') ? 'transparent' : $theme['accent'] }}40;"></div>
                    </div>
                </div>
                <!-- Label -->
                <span class="text-[10px] font-medium text-center text-muted-foreground group-hover:text-foreground transition-colors">{{ $theme['label'] }}</span>
            </label>
        @endforeach
    </div>

    <!-- Custom Theme Mode Settings -->
    <div x-show="draftDesign.theme.custom_theme" x-cloak x-transition class="space-y-6">
        <!-- Font Selection -->
        <div class="bg-muted/10 p-4 rounded-xl border border-border space-y-4">
            <div class="flex items-center gap-2 mb-2">
                <i class="fas fa-font text-primary text-xs"></i>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Yazı Tipi (Font)') }}</h4>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <template x-for="font in [
                    {id: 'inter', label: 'Inter', family: 'Inter'},
                    {id: 'outfit', label: 'Outfit', family: 'Outfit'},
                    {id: 'roboto', label: 'Roboto', family: 'Roboto'},
                    {id: 'montserrat', label: 'Montserrat', family: 'Montserrat'},
                    {id: 'playfair', label: 'Playfair', family: 'Playfair Display'},
                    {id: 'mono', label: 'Mono', family: 'JetBrains Mono'}
                ]">
                    <label class="cursor-pointer group">
                        <input type="radio" x-model="draftDesign.theme.font_family" :value="font.id" class="sr-only peer">
                        <div class="border border-input peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/20 rounded-lg p-3 bg-background hover:bg-muted/50 transition-all text-center">
                            <span class="block text-sm font-semibold truncate" :style="`font-family: ${font.family}, sans-serif`" x-text="font.label"></span>
                        </div>
                    </label>
                </template>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center p-8 text-center bg-primary/5 border border-dashed border-primary/20 rounded-xl">
            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary/10 text-primary mb-3">
                <i class="fas fa-paint-brush text-sm"></i>
            </div>
            <h4 class="text-sm font-semibold mb-1">{{ __('Özel Tasarım Modu Aktif') }}</h4>
            <p class="text-[10px] text-muted-foreground max-w-sm">{{ __('Profilinizi tamamen kişiselleştirmek için Arka Plan, Butonlar ve Renkler sekmelerini kullanabilirsiniz.') }}</p>
        </div>
    </div>
</div>
