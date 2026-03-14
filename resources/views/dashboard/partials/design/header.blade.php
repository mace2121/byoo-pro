<div class="space-y-8">
    <!-- Profile Info (NEW) -->
    <div class="bg-muted/30 p-4 rounded-lg border border-border space-y-4">
        <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Profil Bilgileri') }}</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="text-[10px] font-medium text-muted-foreground">{{ __('Profil İsmi') }}</label>
                <input type="text" x-model="draftDesign.profile.name" class="w-full text-sm rounded-md border-input bg-background shadow-sm focus:ring-primary focus:border-primary">
            </div>
            <div class="space-y-1.5">
                <label class="text-[10px] font-medium text-muted-foreground">{{ __('Biyografi') }}</label>
                <textarea x-model="draftDesign.profile.bio" rows="1" class="w-full text-sm rounded-md border-input bg-background shadow-sm focus:ring-primary focus:border-primary resize-none"></textarea>
            </div>
        </div>
    </div>

    <!-- Header Layout Options -->
    <div class="space-y-3">
        <label class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Header Düzeni') }}</label>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.header.layout" value="centered-classic" class="sr-only peer">
                <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col items-center justify-center gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-2">
                    <div class="w-8 h-8 rounded-full bg-foreground/20"></div>
                    <div class="w-12 h-1.5 rounded-full bg-foreground/40"></div>
                    <div class="w-16 h-1 rounded-full bg-foreground/20"></div>
                </div>
                <span class="text-[10px] font-medium text-center block mt-1.5 text-muted-foreground group-hover:text-foreground">Klasik Merkez</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.header.layout" value="left-aligned" class="sr-only peer">
                <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col justify-center items-start gap-2 bg-muted/20 hover:bg-muted/50 transition-all p-3">
                    <div class="w-8 h-8 rounded-full bg-foreground/20"></div>
                    <div class="w-16 h-1.5 rounded-full bg-foreground/40"></div>
                    <div class="w-20 h-1 rounded-full bg-foreground/20"></div>
                </div>
                <span class="text-[10px] font-medium text-center block mt-1.5 text-muted-foreground group-hover:text-foreground">Sol Hizalı</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.header.layout" value="hero-cover" class="sr-only peer">
                <div class="h-20 rounded-md border border-input peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring flex flex-col bg-muted/20 hover:bg-muted/50 transition-all overflow-hidden relative">
                    <div class="h-10 w-full bg-foreground/10"></div>
                    <div class="absolute top-6 left-1/2 -translate-x-1/2 w-8 h-8 rounded-full bg-foreground/30 border-2 border-background"></div>
                    <div class="mt-5 w-full flex flex-col items-center gap-1">
                        <div class="w-12 h-1.5 rounded-full bg-foreground/40"></div>
                        <div class="w-16 h-1 rounded-full bg-foreground/20"></div>
                    </div>
                </div>
                <span class="text-[10px] font-medium text-center block mt-1.5 text-muted-foreground group-hover:text-foreground">Hero Kapak</span>
            </label>
        </div>
    </div>

    <!-- Hero Image Upload (NEW) -->
    <div x-show="draftDesign.header.layout === 'hero-cover'" x-cloak x-transition class="space-y-4 bg-primary/5 p-4 rounded-lg border border-primary/20">
        <div class="flex items-center justify-between">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-primary">{{ __('Hero Kapak Görseli') }}</h4>
            <div x-show="draftDesign.header.hero_image_url" class="flex gap-2">
                <button @click="clearDesignMedia('hero_image', 'header.hero_image_url')" class="text-[10px] text-destructive hover:underline">{{ __('Görseli Kaldır') }}</button>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="relative w-24 h-16 rounded border border-input bg-background overflow-hidden flex-shrink-0 group">
                <template x-if="draftDesign.header.hero_image_url">
                    <img :src="draftDesign.header.hero_image_url" class="w-full h-full object-cover">
                </template>
                <div x-show="!draftDesign.header.hero_image_url" class="w-full h-full flex items-center justify-center bg-muted/30">
                    <i class="fas fa-image text-muted-foreground/30"></i>
                </div>
            </div>
            <div class="flex-1">
                <label class="inline-flex items-center px-4 py-2 bg-primary text-primary-foreground text-xs font-semibold rounded-md border border-transparent hover:bg-primary/90 cursor-pointer shadow-sm transition-all">
                    <i class="fas fa-upload mr-2"></i>
                    {{ __('Görsel Seç') }}
                    <input type="file" class="hidden" accept="image/*" @change="handleFileChange($event, 'hero_image')">
                </label>
                <p class="text-[9px] text-muted-foreground mt-2">{{ __('Önerilen boyut: 1200x400. Yatay bir görsel kullanmanız tavsiye edilir.') }}</p>
            </div>
        </div>
    </div>

    <hr class="border-border">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Avatar Settings -->
        <div class="space-y-6">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Profil Görseli (Avatar)') }}</h4>
            
            <div class="space-y-2">
                <label class="text-xs font-medium">{{ __('Görsel Boyutu') }}</label>
                <div class="flex items-center gap-2 bg-muted/30 p-1 rounded-md border border-border w-max">
                    <button @click="draftDesign.header.avatar_size = 'sm'" :class="draftDesign.header.avatar_size === 'sm' ? 'bg-background shadow-sm text-foreground' : 'text-muted-foreground hover:text-foreground'" class="px-3 py-1 text-xs rounded transition-all">Küçük</button>
                    <button @click="draftDesign.header.avatar_size = 'md'" :class="draftDesign.header.avatar_size === 'md' ? 'bg-background shadow-sm text-foreground' : 'text-muted-foreground hover:text-foreground'" class="px-3 py-1 text-xs rounded transition-all">Orta</button>
                    <button @click="draftDesign.header.avatar_size = 'lg'" :class="draftDesign.header.avatar_size === 'lg' ? 'bg-background shadow-sm text-foreground' : 'text-muted-foreground hover:text-foreground'" class="px-3 py-1 text-xs rounded transition-all">Büyük</button>
                    <button @click="draftDesign.header.avatar_size = 'xl'" :class="draftDesign.header.avatar_size === 'xl' ? 'bg-background shadow-sm text-foreground' : 'text-muted-foreground hover:text-foreground'" class="px-3 py-1 text-xs rounded transition-all">Dev</button>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-medium">{{ __('Görsel Çerçevesi') }}</label>
                <select x-model="draftDesign.header.avatar_frame" class="w-full text-sm rounded-md border-input bg-background shadow-sm">
                    <option value="circle">Tam Yuvarlak (Daire)</option>
                    <option value="rounded-xl">Yumuşak Kare</option>
                    <option value="square">Keskin Kare</option>
                    <option value="polygon">Çokgen (Hexagon)</option>
                </select>
            </div>
        </div>

        <!-- Visibility Settings -->
        <div class="space-y-6">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Görünürlük Ayarları') }}</h4>
            
            <div class="space-y-3 bg-muted/10 p-4 rounded-lg border border-border">
                <label class="flex items-center justify-between cursor-pointer group">
                    <span class="text-sm font-medium text-foreground group-hover:text-primary transition-colors">{{ __('Profil İsmini Göster') }}</span>
                    <button @click="draftDesign.header.show_name = !draftDesign.header.show_name"
                            :class="draftDesign.header.show_name ? 'bg-primary' : 'bg-muted-foreground/30'"
                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <span :class="draftDesign.header.show_name ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-background shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                </label>

                <label class="flex items-center justify-between cursor-pointer group">
                    <span class="text-sm font-medium text-foreground group-hover:text-primary transition-colors">{{ __('@kullaniciadini Göster') }}</span>
                    <button @click="draftDesign.header.show_username = !draftDesign.header.show_username"
                            :class="draftDesign.header.show_username ? 'bg-primary' : 'bg-muted-foreground/30'"
                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <span :class="draftDesign.header.show_username ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-background shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                </label>

                <label class="flex items-center justify-between cursor-pointer group">
                    <span class="text-sm font-medium text-foreground group-hover:text-primary transition-colors">{{ __('Biyografiyi Göster') }}</span>
                    <button @click="draftDesign.header.show_bio = !draftDesign.header.show_bio"
                            :class="draftDesign.header.show_bio ? 'bg-primary' : 'bg-muted-foreground/30'"
                            class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                        <span :class="draftDesign.header.show_bio ? 'translate-x-4' : 'translate-x-0'" class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-background shadow ring-0 transition duration-200 ease-in-out"></span>
                    </button>
                </label>
            </div>
            
            <p class="text-[10px] text-muted-foreground">{{ __('Profil başlığı ve biyo ayarlarını buradan anlık değiştirebilirsiniz.') }}</p>
        </div>
    </div>
</div>
