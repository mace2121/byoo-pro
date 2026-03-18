<section id="hero" data-scene="hero" class="relative overflow-hidden pt-28 sm:pt-32">
    <div class="mx-auto grid max-w-7xl gap-14 px-4 pb-16 pt-10 sm:px-6 lg:px-8 xl:grid-cols-[minmax(0,1fr)_22rem] xl:gap-20 xl:pr-[24rem]">
        <div class="max-w-3xl">
            <div class="section-chip reveal" data-reveal>
                <span class="pulse-ring inline-flex h-2.5 w-2.5 rounded-full bg-[#00ffcc]"></span>
                SaaS landing demo + canli builder deneyimi
            </div>

            <div class="mt-8 reveal" data-reveal>
                <h1 class="landing-heading text-5xl font-semibold leading-[1.02] text-white sm:text-6xl lg:text-7xl">
                    Linklerin artik
                    <span class="bg-[linear-gradient(135deg,#00ffcc_0%,#7dd3fc_40%,#c084fc_100%)] bg-clip-text text-transparent">
                        sadece link degil.
                    </span>
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300 sm:text-xl">
                    Profilini mini bir web sitesine donustur. Link, urun, WhatsApp siparis ve sosyal bloklarini ekle; tum degisiklikleri canli onizlemede aninda gor.
                </p>
            </div>

            <div class="mt-10 flex flex-col gap-4 sm:flex-row reveal" data-reveal>
                <a
                    href="{{ Route::has('register') ? route('register') : route('login') }}"
                    class="glow-button inline-flex items-center justify-center gap-3 rounded-full bg-[#00ffcc] px-7 py-4 text-base font-bold text-slate-950 transition hover:translate-y-[-1px] hover:bg-[#7effe1]"
                >
                    <i class="fa-solid fa-rocket"></i>
                    Ucretsiz basla
                </a>
                <a
                    href="#builder"
                    class="ghost-button inline-flex items-center justify-center gap-3 rounded-full px-7 py-4 text-base font-semibold text-slate-100 transition hover:bg-white/5"
                >
                    <i class="fa-solid fa-play"></i>
                    Canli demoyu incele
                </a>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-3 reveal" data-reveal>
                <div class="glass-panel-soft rounded-3xl p-5">
                    <p class="text-sm font-semibold text-white">2 dakikada yayina cik</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Linkleri blok olarak ekle, temayi sec ve profilini paylas.</p>
                </div>
                <div class="glass-panel-soft rounded-3xl p-5">
                    <p class="text-sm font-semibold text-white">Canli onizleme</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">Yaptigin her degisiklik ayni anda telefon onizlemesine yansir.</p>
                </div>
                <div class="glass-panel-soft rounded-3xl p-5">
                    <p class="text-sm font-semibold text-white">Siparis odakli</p>
                    <p class="mt-2 text-sm leading-6 text-slate-300">WhatsApp ve urun bloklariyla tiklanabilir mini vitrin kur.</p>
                </div>
            </div>
        </div>

        <div class="relative xl:hidden">
            <div class="absolute left-0 top-10 h-28 w-28 rounded-full bg-[#00ffcc]/15 blur-3xl"></div>
            <div class="absolute right-0 top-24 h-32 w-32 rounded-full bg-[#6c5ce7]/25 blur-3xl"></div>
            @include('partials.landing.phone-preview', ['wrapperClass' => 'mx-auto max-w-sm reveal is-visible'])
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 xl:pr-[24rem]">
        <div class="glass-panel reveal relative overflow-hidden rounded-[2rem] p-6 sm:p-8" data-reveal>
            <div class="absolute inset-x-0 top-0 h-px bg-[linear-gradient(90deg,transparent,rgba(0,255,204,0.8),transparent)]"></div>
            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.26em] text-cyan-300/90">Mini site mantigi</p>
                    <h2 class="landing-heading mt-4 text-3xl font-semibold text-white sm:text-4xl">
                        Urunu anlatan degil, urunu deneyimleten bir landing.
                    </h2>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-slate-300">
                        Bu sayfa klasik bir tanitim alanindan fazlasi olacak sekilde tasarlandi. Kullanici hem builder mantigini goruyor hem de tema, blok ve urun akislarinin nasil calistigini kaydolmadan deneyimliyor.
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-2xl font-semibold text-white">+34%</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Canli demo anlatimi sayesinde sign-up niyeti daha hizli olusur.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5">
                        <p class="text-2xl font-semibold text-white">1 sayfa</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Tum fayda, urun akisi ve guven unsurlari tek scroll deneyiminde sunulur.</p>
                    </div>
                    <div class="rounded-3xl border border-white/10 bg-white/5 p-5 sm:col-span-2">
                        <div class="flex flex-wrap gap-3 text-sm text-slate-200">
                            <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2">Link-in-bio</span>
                            <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2">WhatsApp siparis</span>
                            <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2">Urun bloklari</span>
                            <span class="rounded-full border border-white/10 bg-white/5 px-4 py-2">Canli tema editoru</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
