<section id="cta" data-scene="cta" class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 xl:pr-[24rem]">
        <div class="glass-panel relative overflow-hidden rounded-[2.25rem] p-8 sm:p-10 reveal" data-reveal>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(0,255,204,0.22),transparent_30%),radial-gradient(circle_at_bottom_left,rgba(124,58,237,0.22),transparent_28%)]"></div>
            <div class="relative grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <div class="section-chip">
                        <i class="fa-solid fa-rocket text-[#00ffcc]"></i>
                        Final CTA
                    </div>
                    <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                        2 dakikada profilini yayina al, takipciyi dogrudan aksiyona gotur.
                    </h2>
                    <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-300">
                        Hazir bloklari sec, markana uygun temayi kur ve mini web siteni hemen paylas. byoo.pro ile urununu sadece gostermiyorsun; kullandiriyorsun.
                    </p>
                </div>

                <div class="grid gap-3 sm:min-w-[18rem]">
                    <a
                        href="{{ Route::has('register') ? route('register') : route('login') }}"
                        class="glow-button inline-flex items-center justify-center gap-3 rounded-full bg-[#00ffcc] px-6 py-4 text-base font-bold text-slate-950 transition hover:translate-y-[-1px] hover:bg-[#7effe1]"
                    >
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                        Ucretsiz basla
                    </a>
                    <a
                        href="#builder"
                        class="ghost-button inline-flex items-center justify-center gap-3 rounded-full px-6 py-4 text-base font-semibold text-white transition hover:bg-white/5"
                    >
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        Demo bolumune don
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
