@php
    $proofBadges = [
        '500+ aktif creator',
        '10.000+ yayindaki link',
        'WhatsApp odakli siparis akisi',
        'Canli tema editoru',
        'Blok bazli profil sistemi',
    ];
@endphp

<section id="proof" data-scene="proof" data-stats class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 xl:pr-[24rem]">
        <div class="grid gap-8 lg:grid-cols-[0.84fr_1.16fr]">
            <div class="reveal" data-reveal>
                <div class="section-chip">
                    <i class="fa-solid fa-shield-heart text-cyan-300"></i>
                    Sosyal kanit
                </div>
                <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                    Sayilar, yorumlar ve urun sinyalleri tek yerde.
                </h2>
                <p class="mt-5 text-lg leading-8 text-slate-300">
                    Bu section "neden guveneyim?" sorusuna cevap verir. Sayilar canli akar, yorumlar sirayla gosterilir ve urunun olgunlugu somut sinyallerle desteklenir.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @foreach ($proofBadges as $badge)
                        <span class="rounded-full border border-white/10 bg-white/[0.04] px-4 py-2 text-sm font-medium text-slate-200">{{ $badge }}</span>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-5">
                <div class="grid gap-5 sm:grid-cols-3 reveal" data-reveal>
                    <div class="stat-card rounded-[1.75rem] p-5">
                        <p class="text-sm uppercase tracking-[0.22em] text-cyan-300">Creator</p>
                        <p class="mt-5 text-4xl font-semibold text-white" x-text="formattedCount('creators')"></p>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Her biri profilini mini siteye cevirdi.</p>
                    </div>
                    <div class="stat-card rounded-[1.75rem] p-5">
                        <p class="text-sm uppercase tracking-[0.22em] text-cyan-300">Link</p>
                        <p class="mt-5 text-4xl font-semibold text-white" x-text="formattedCount('links')"></p>
                        <p class="mt-3 text-sm leading-6 text-slate-300">Aktif blok ve link karti yayinda.</p>
                    </div>
                    <div class="stat-card rounded-[1.75rem] p-5">
                        <p class="text-sm uppercase tracking-[0.22em] text-cyan-300">Siparis</p>
                        <p class="mt-5 text-4xl font-semibold text-white" x-text="formattedCount('sales')"></p>
                        <p class="mt-3 text-sm leading-6 text-slate-300">WhatsApp odakli aksiyonlar olustu.</p>
                    </div>
                </div>

                <div class="glass-panel rounded-[2rem] p-6 reveal" data-reveal>
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-cyan-300">Yorumlar</p>
                            <h3 class="mt-2 text-2xl font-semibold text-white">Kullanicilar urunu nasil anlatiyor?</h3>
                        </div>
                        <div class="flex gap-2">
                            <template x-for="(testimonial, index) in testimonials" :key="testimonial.name">
                                <button
                                    type="button"
                                    @click="activeTestimonial = index"
                                    class="h-2.5 w-8 rounded-full transition"
                                    :class="activeTestimonial === index ? 'bg-[#00ffcc]' : 'bg-white/10'"
                                ></button>
                            </template>
                        </div>
                    </div>

                    <div class="mt-6 min-h-[13rem]">
                        <template x-for="(testimonial, index) in testimonials" :key="testimonial.name + index">
                            <article x-show="activeTestimonial === index" x-transition.opacity.duration.500ms class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-6">
                                <p class="text-base leading-8 text-slate-100" x-text="testimonial.quote"></p>
                                <div class="mt-6 flex items-center gap-3">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-white">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-white" x-text="testimonial.name"></p>
                                        <p class="text-xs uppercase tracking-[0.22em] text-cyan-300" x-text="testimonial.role"></p>
                                    </div>
                                </div>
                            </article>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
