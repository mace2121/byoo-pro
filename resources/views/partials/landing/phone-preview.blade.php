@php($wrapperClass = $wrapperClass ?? '')

<div class="{{ $wrapperClass }}">
    <div class="phone-shell">
        <div class="phone-screen" :style="previewShellStyle()">
            <div class="flex items-center justify-between text-[11px] font-medium text-slate-300/80">
                <span x-text="previewTitle()"></span>
                <span class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-white/5 px-2.5 py-1">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00ffcc]"></span>
                    Live
                </span>
            </div>

            <div class="mt-4 phone-card p-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/10">
                        <x-application-logo class="h-7 w-7 text-white" />
                    </div>
                    <div>
                        <p class="text-base font-semibold text-white">byoo.pro demo</p>
                        <p class="text-xs text-slate-300/80">blok builder + tema editoru</p>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap gap-2 text-[11px] font-medium text-slate-200">
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5" x-text="currentTheme().name"></span>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5" x-text="currentFont().label"></span>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5">
                        Blur <span x-text="blurLevel"></span>
                    </span>
                </div>
            </div>

            <div class="mt-4 space-y-3">
                <template x-if="activeScene === 'hero' || activeScene === 'builder'">
                    <div class="space-y-3">
                        <template x-for="block in previewBlocks(activeScene === 'hero' ? 3 : null)" :key="block.id">
                            <div class="phone-card flex items-center gap-3 p-3">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl" :style="blockTone(block.kind)">
                                    <i class="fa-solid text-base" :class="block.icon"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="truncate text-sm font-semibold text-white" x-text="block.title"></p>
                                        <span
                                            class="rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.22em]"
                                            :style="blockTone(block.kind)"
                                            x-text="blockKindLabel(block.kind)"
                                        ></span>
                                    </div>
                                    <p class="mt-1 truncate text-xs text-slate-300/80" x-text="block.subtitle"></p>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="activeScene === 'problem'">
                    <div class="space-y-3">
                        <div class="phone-card p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-rose-300">Once</p>
                            <div class="mt-3 space-y-2">
                                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">Tek link</div>
                                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">Zayif ozellestirme</div>
                                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-300">Siparis akisi yok</div>
                            </div>
                        </div>
                        <div class="phone-card p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-cyan-300">Sonra</p>
                            <div class="mt-3 space-y-2">
                                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white">Blok bazli mini site</div>
                                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white">Canli tema motoru</div>
                                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-white">WhatsApp siparis</div>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="activeScene === 'products'">
                    <div class="space-y-3">
                        <template x-for="product in products" :key="product.name">
                            <div class="phone-card overflow-hidden">
                                <div class="h-24 bg-[linear-gradient(135deg,rgba(255,255,255,0.08),transparent),linear-gradient(135deg,rgba(0,255,204,0.2),rgba(124,58,237,0.3))]"></div>
                                <div class="p-4">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="text-sm font-semibold text-white" x-text="product.name"></p>
                                        <p class="text-sm font-semibold text-cyan-300" x-text="product.price"></p>
                                    </div>
                                    <p class="mt-1 text-xs text-slate-300/80" x-text="product.subtitle"></p>
                                    <button class="mt-4 w-full rounded-2xl bg-[#00ffcc] px-4 py-3 text-sm font-bold text-slate-950">
                                        WhatsApp ile siparis ver
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="activeScene === 'customize'">
                    <div class="space-y-3">
                        <div class="phone-card p-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-white">Tema secimi</p>
                                <span class="text-xs text-slate-300/80" x-text="currentTheme().name"></span>
                            </div>
                            <div class="mt-4 flex gap-3">
                                <span class="picker-dot h-6 w-6 rounded-full" :style="'background:' + currentTheme().accent"></span>
                                <span class="picker-dot h-6 w-6 rounded-full" :style="'background:' + currentTheme().secondary"></span>
                                <span class="picker-dot h-6 w-6 rounded-full bg-white/50"></span>
                            </div>
                        </div>
                        <div class="phone-card p-4">
                            <p class="text-sm font-semibold text-white">Font ve blur</p>
                            <div class="mt-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-200" x-text="currentFont().label"></div>
                            <div class="mt-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-200">
                                Blur seviyesi: <span x-text="blurLevel"></span>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="activeScene === 'proof'">
                    <div class="space-y-3">
                        <div class="phone-card grid grid-cols-3 gap-3 p-4 text-center">
                            <div>
                                <p class="text-lg font-semibold text-white" x-text="formattedCount('creators')"></p>
                                <p class="mt-1 text-[11px] text-slate-300/80">creator</p>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-white" x-text="formattedCount('links')"></p>
                                <p class="mt-1 text-[11px] text-slate-300/80">aktif link</p>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-white" x-text="formattedCount('sales')"></p>
                                <p class="mt-1 text-[11px] text-slate-300/80">siparis</p>
                            </div>
                        </div>
                        <div class="phone-card p-4">
                            <p class="text-sm font-semibold text-white" x-text="testimonials[activeTestimonial].name"></p>
                            <p class="mt-1 text-xs uppercase tracking-[0.22em] text-cyan-300" x-text="testimonials[activeTestimonial].role"></p>
                            <p class="mt-4 text-sm leading-6 text-slate-200" x-text="testimonials[activeTestimonial].quote"></p>
                        </div>
                    </div>
                </template>

                <template x-if="activeScene === 'cta'">
                    <div class="space-y-3">
                        <div class="phone-card p-4">
                            <p class="text-sm font-semibold text-white">Yayina hazir checklist</p>
                            <div class="mt-4 space-y-2 text-sm text-slate-200">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#00ffcc]/15 text-[#00ffcc]">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </span>
                                    Profil bilgileri tamamlandi
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#00ffcc]/15 text-[#00ffcc]">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </span>
                                    Bloklar hazirlandi
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-[#00ffcc]/15 text-[#00ffcc]">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </span>
                                    Tema secildi ve onizlendi
                                </div>
                            </div>
                            <button class="mt-5 w-full rounded-2xl bg-[#00ffcc] px-4 py-3 text-sm font-bold text-slate-950">
                                Sayfami yayinla
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
