<section id="customize" data-scene="customize" class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 xl:pr-[24rem]">
        <div class="grid gap-6 lg:grid-cols-[1.04fr_0.96fr]">
            <div class="glass-panel rounded-[2rem] p-6 sm:p-8 reveal" data-reveal>
                <div class="section-chip">
                    <i class="fa-solid fa-palette text-[#00ffcc]"></i>
                    Customization demo
                </div>
                <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                    Renk, blur ve font sec; sayfa nasil degisiyor hemen gor.
                </h2>
                <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-300">
                    Tema gucunu sadece anlatmak yerine kullandir. Landing uzerindeki bu demo, kullanicinin gercek editor deneyimini kayit olmadan hissetmesini saglar.
                </p>

                <div class="mt-8 grid gap-4">
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-cyan-300">Palet sec</p>
                        <div class="mt-4 grid gap-3 sm:grid-cols-3">
                            <template x-for="theme in themes" :key="theme.key">
                                <button
                                    type="button"
                                    @click="selectedThemeKey = theme.key"
                                    class="rounded-3xl border px-4 py-4 text-left transition"
                                    :class="themeButtonClass(theme.key)"
                                >
                                    <div class="flex items-center gap-3">
                                        <span class="picker-dot h-5 w-5 rounded-full" :style="'background:' + theme.accent"></span>
                                        <span class="picker-dot h-5 w-5 rounded-full" :style="'background:' + theme.secondary"></span>
                                    </div>
                                    <p class="mt-4 text-sm font-semibold" x-text="theme.name"></p>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-cyan-300">Font sec</p>
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <template x-for="font in fonts" :key="font.key">
                                <button
                                    type="button"
                                    @click="selectedFontKey = font.key"
                                    class="rounded-3xl border px-4 py-4 text-left text-base transition"
                                    :class="fontButtonClass(font.key)"
                                    :style="'font-family:' + font.stack"
                                >
                                    <span x-text="font.label"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                        <div class="flex items-center justify-between gap-4">
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-cyan-300">Blur ayari</p>
                            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-sm font-semibold text-white">
                                <span x-text="blurLevel"></span>/30
                            </span>
                        </div>
                        <input x-model="blurLevel" class="range-input mt-5" max="30" min="0" step="1" type="range">
                        <p class="mt-3 text-sm leading-6 text-slate-300">Arka plan ve kart gecislerinin ne kadar yumusak hissedilecegini demo uzerinde test et.</p>
                    </div>
                </div>
            </div>

            <div class="glass-panel rounded-[2rem] p-6 reveal" data-reveal>
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-cyan-300">Canli degisim mantigi</p>
                <div class="mt-5 space-y-4">
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                        <p class="text-base font-semibold text-white">Secim yapildikca onizleme yenilenir</p>
                        <p class="mt-2 text-sm leading-7 text-slate-300">Renk, font ve blur degisiklikleri sagdaki telefon gorunumunu ve section aktifligini birlikte etkiler.</p>
                    </div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                        <p class="text-base font-semibold text-white">Tek state, net kurgu</p>
                        <p class="mt-2 text-sm leading-7 text-slate-300">Tum kontroller ayni veri modelinden beslenir; bu da kullanicinin neyi degistirdigini aninda anlamasini saglar.</p>
                    </div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                        <p class="text-base font-semibold text-white">Editor hissi</p>
                        <p class="mt-2 text-sm leading-7 text-slate-300">Landing deneyimi urunu satmakla kalmaz; editoru kullanmanin ne kadar akici oldugunu da hissettirir.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 xl:hidden">
            @include('partials.landing.phone-preview', ['wrapperClass' => 'mx-auto max-w-sm reveal is-visible'])
        </div>
    </div>
</section>
