<section id="builder" data-scene="builder" class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 xl:pr-[24rem]">
        <div class="max-w-3xl reveal" data-reveal>
            <div class="section-chip">
                <i class="fa-solid fa-layer-group text-[#00ffcc]"></i>
                Block builder demo
            </div>
            <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                Sol tarafta blok ekle, sag tarafta aninda sonucunu gor.
            </h2>
            <p class="mt-5 text-lg leading-8 text-slate-300">
                byoo.pro'nun kalbi builder akisi. Link bloklari, urun kartlari, WhatsApp CTA ve sosyal alanlar tek kompozisyonda birlesir; landing de bunu canli olarak deneyimletir.
            </p>
        </div>

        <div class="mt-12 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="glass-panel rounded-[2rem] p-6 reveal" data-reveal>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-lg font-semibold text-white">Yeni blok ekle</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Fake builder demo icin istedigin blok turunu sec ve listeye ekle.</p>
                    </div>
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.22em] text-slate-300">
                        demo
                    </span>
                </div>

                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    <template x-for="option in composerKinds" :key="option.key">
                        <button
                            type="button"
                            @click="composerKind = option.key"
                            class="flex items-center gap-3 rounded-3xl border px-4 py-4 text-left text-sm font-semibold transition"
                            :class="composerButtonClass(option.key)"
                        >
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-100">
                                <i class="fa-solid" :class="option.icon"></i>
                            </span>
                            <span x-text="option.label"></span>
                        </button>
                    </template>
                </div>

                <button
                    type="button"
                    @click="addComposerBlock()"
                    class="glow-button mt-6 inline-flex w-full items-center justify-center gap-3 rounded-3xl bg-[#00ffcc] px-5 py-4 text-sm font-bold text-slate-950 transition hover:translate-y-[-1px] hover:bg-[#7effe1]"
                >
                    <i class="fa-solid fa-plus"></i>
                    Secili bloku listeye ekle
                </button>

                <div class="mt-8 rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-cyan-300">Neden etkili?</p>
                    <ul class="mt-4 space-y-3 text-sm leading-7 text-slate-300">
                        <li class="flex gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#00ffcc]"></span>
                            Kullanici blok mantigini okumadan gorur.
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#00ffcc]"></span>
                            Ekleme ve preview arasindaki iliski netlesir.
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-[#00ffcc]"></span>
                            Signup oncesi urunun nasil hissettirdigi ortaya cikar.
                        </li>
                    </ul>
                </div>
            </div>

            <div class="glass-panel rounded-[2rem] p-6 reveal" data-reveal>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-lg font-semibold text-white">Aktif demo listesi</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Kartlar acik-kapali durumlariyla birlikte fake olarak duzenlenebilir.</p>
                    </div>
                    <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white">
                        <span x-text="builderBlocks.length"></span> blok
                    </span>
                </div>

                <div class="mt-6 space-y-3">
                    <template x-for="block in builderBlocks" :key="block.id">
                        <div class="rounded-[1.5rem] border border-white/10 bg-white/[0.03] p-4">
                            <div class="flex items-center gap-3">
                                <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-400">
                                    <i class="fa-solid fa-grip"></i>
                                </button>

                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl" :style="blockTone(block.kind)">
                                    <i class="fa-solid text-base" :class="block.icon"></i>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-3">
                                        <p class="truncate text-base font-semibold text-white" x-text="block.title"></p>
                                        <span
                                            class="rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.22em]"
                                            :style="blockTone(block.kind)"
                                            x-text="blockKindLabel(block.kind)"
                                        ></span>
                                    </div>
                                    <p class="mt-1 truncate text-sm text-slate-300" x-text="block.subtitle"></p>
                                </div>

                                <button
                                    type="button"
                                    @click="toggleBlock(block.id)"
                                    class="inline-flex h-9 w-16 items-center rounded-full border border-white/10 p-1 transition"
                                    :class="block.enabled ? 'bg-white text-slate-950' : 'bg-white/5 text-slate-400'"
                                >
                                    <span class="h-7 w-7 rounded-full transition" :class="block.enabled ? 'translate-x-7 bg-slate-950' : 'translate-x-0 bg-slate-400'"></span>
                                </button>

                                <button
                                    type="button"
                                    @click="removeBlock(block.id)"
                                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-300 transition hover:border-rose-300/30 hover:text-rose-200"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="mt-8 xl:hidden">
            @include('partials.landing.phone-preview', ['wrapperClass' => 'mx-auto max-w-sm reveal is-visible'])
        </div>
    </div>
</section>
