<div class="space-y-8">
    <div class="rounded-2xl border border-border bg-muted/10 p-5">
        <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Profil Bilgileri') }}</h4>
        <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-1.5">
                <label class="text-[11px] font-medium text-muted-foreground">{{ __('Profil İsmi') }}</label>
                <input type="text" x-model="draftDesign.profile.name" class="w-full rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary">
            </div>
            <div class="space-y-1.5">
                <label class="text-[11px] font-medium text-muted-foreground">{{ __('Biyografi') }}</label>
                <textarea x-model="draftDesign.profile.bio" rows="2" class="w-full resize-none rounded-xl border-input bg-background text-sm shadow-sm focus:border-primary focus:ring-primary"></textarea>
            </div>
        </div>
    </div>

    <div class="space-y-3">
        <label class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Header Düzeni') }}</label>
        <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.header.layout" @change="handleHeaderLayoutChange('centered-classic')" value="centered-classic" class="sr-only peer">
                <div class="flex h-24 flex-col items-center justify-center gap-2 rounded-2xl border border-input bg-muted/20 p-3 transition-all peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring hover:bg-muted/50">
                    <div class="h-10 w-10 rounded-full bg-foreground/20"></div>
                    <div class="h-2 w-16 rounded-full bg-foreground/40"></div>
                    <div class="h-1.5 w-20 rounded-full bg-foreground/20"></div>
                </div>
                <span class="mt-2 block text-center text-[11px] font-semibold text-muted-foreground group-hover:text-foreground">{{ __('Klasik Merkez') }}</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.header.layout" @change="handleHeaderLayoutChange('left-aligned')" value="left-aligned" class="sr-only peer">
                <div class="flex h-24 flex-col items-start justify-center gap-2 rounded-2xl border border-input bg-muted/20 p-4 transition-all peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring hover:bg-muted/50">
                    <div class="h-10 w-10 rounded-full bg-foreground/20"></div>
                    <div class="h-2 w-16 rounded-full bg-foreground/40"></div>
                    <div class="h-1.5 w-24 rounded-full bg-foreground/20"></div>
                </div>
                <span class="mt-2 block text-center text-[11px] font-semibold text-muted-foreground group-hover:text-foreground">{{ __('Sol Hizalı') }}</span>
            </label>
            <label class="cursor-pointer group">
                <input type="radio" x-model="draftDesign.header.layout" @change="handleHeaderLayoutChange('hero-cover')" value="hero-cover" class="sr-only peer">
                <div class="relative h-24 overflow-hidden rounded-2xl border border-input bg-muted/20 transition-all peer-checked:border-primary peer-checked:ring-1 peer-checked:ring-ring hover:bg-muted/50">
                    <div class="h-11 w-full bg-foreground/10"></div>
                    <div class="absolute left-1/2 top-7 h-10 w-10 -translate-x-1/2 rounded-full border-2 border-background bg-foreground/30"></div>
                    <div class="mt-7 flex flex-col items-center gap-1">
                        <div class="h-2 w-16 rounded-full bg-foreground/40"></div>
                        <div class="h-1.5 w-20 rounded-full bg-foreground/20"></div>
                    </div>
                </div>
                <span class="mt-2 block text-center text-[11px] font-semibold text-muted-foreground group-hover:text-foreground">{{ __('Hero Kapak') }}</span>
            </label>
        </div>
    </div>

    <div x-show="draftDesign.header.layout === 'hero-cover'" x-cloak class="rounded-2xl border border-primary/20 bg-primary/5 p-5">
        <div class="space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h4 class="text-xs font-semibold uppercase tracking-wider text-primary">{{ __('Hero Kapak Görseli') }}</h4>
                    <p class="mt-1 text-[11px] text-muted-foreground">{{ __('Hero kapak seçildiğinde varsayılan avatar boyutu orta olarak ayarlanır.') }}</p>
                </div>
                <button type="button" x-show="draftDesign.header.hero_image_url" @click="clearDesignMedia('hero_image', 'header.hero_image_url')" class="text-[11px] font-semibold text-destructive hover:underline">{{ __('Görseli Kaldır') }}</button>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative h-20 w-28 overflow-hidden rounded-2xl border border-input bg-background">
                    <template x-if="draftDesign.header.hero_image_url">
                        <img :src="draftDesign.header.hero_image_url" class="h-full w-full object-cover">
                    </template>
                    <template x-if="!draftDesign.header.hero_image_url">
                        <div class="flex h-full w-full items-center justify-center bg-muted/30 text-muted-foreground/40">
                            <i class="fas fa-image"></i>
                        </div>
                    </template>
                </div>
                <div class="space-y-2">
                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-xl bg-primary px-4 py-2 text-xs font-semibold text-primary-foreground shadow-sm transition-all hover:bg-primary/90">
                        <i class="fas fa-upload text-[11px]"></i>
                        {{ __('Görsel Seç') }}
                        <input type="file" class="hidden" accept="image/*" @change="handleFileChange($event, 'hero_image')">
                    </label>
                    <p class="text-[11px] text-muted-foreground">{{ __('Önerilen oran: 1200 x 400') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Profil Görseli') }}</h4>

            <div class="space-y-3" x-show="draftDesign.header.layout !== 'left-aligned'" x-cloak>
                <label class="text-[11px] font-medium text-muted-foreground">{{ __('Görsel Boyutu') }}</label>
                <div class="grid grid-cols-2 gap-2">
                    <template x-for="size in avatarSizeOptions" :key="size.id">
                        <button type="button"
                                @click="draftDesign.header.avatar_size = size.id"
                                :class="draftDesign.header.avatar_size === size.id ? 'border-primary bg-primary/5 text-primary' : 'border-input bg-background text-muted-foreground hover:text-foreground'"
                                class="rounded-xl border px-3 py-2 text-sm font-semibold transition-all"
                                x-text="size.label"></button>
                    </template>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[11px] font-medium text-muted-foreground">{{ __('Görsel Çerçevesi') }}</label>
                <select x-model="draftDesign.header.avatar_frame" class="h-11 w-full rounded-xl border-input bg-background text-sm shadow-sm">
                    <option value="circle">{{ __('Tam Yuvarlak') }}</option>
                    <option value="rounded-xl">{{ __('Yumuşak Kare') }}</option>
                    <option value="square">{{ __('Keskin Kare') }}</option>
                    <option value="polygon">{{ __('Çokgen') }}</option>
                </select>
            </div>
        </div>

        <div class="space-y-4 rounded-2xl border border-border bg-muted/10 p-5">
            <h4 class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ __('Görünürlük') }}</h4>
            <div class="space-y-3">
                <template x-for="toggle in headerToggleOptions" :key="toggle.key">
                    <label class="flex items-center justify-between rounded-xl border border-border/70 bg-background px-4 py-3">
                        <span class="text-sm font-medium text-foreground" x-text="toggle.label"></span>
                        <button type="button"
                                @click="draftDesign.header[toggle.key] = !draftDesign.header[toggle.key]"
                                :class="draftDesign.header[toggle.key] ? 'bg-primary' : 'bg-muted-foreground/30'"
                                class="relative inline-flex h-6 w-11 rounded-full border-2 border-transparent transition-colors">
                            <span :class="draftDesign.header[toggle.key] ? 'translate-x-5' : 'translate-x-0'" class="inline-block h-5 w-5 rounded-full bg-background shadow transition-transform"></span>
                        </button>
                    </label>
                </template>
            </div>
        </div>
    </div>
</div>
