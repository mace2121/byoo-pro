@php
    $problems = [
        ['title' => 'Tek link mantigi sinirli kaliyor', 'copy' => 'Sosyal hesaplar, kampanya linkleri ve urun yonlendirmeleri ayni alan icinde kayboluyor.'],
        ['title' => 'Satis akisina yer acilmiyor', 'copy' => 'Klasik bio link araclari urun vitrini, fiyat ve siparis niyeti icin yeterli degil.'],
        ['title' => 'Tasarim kontrolu zayif', 'copy' => 'Kullandigin tema urunun ruhunu yansitmiyorsa sayfa bir vitrinden cok listeye donuyor.'],
    ];

    $solutions = [
        ['title' => 'Blok bazli mini site', 'copy' => 'Link, urun, sosyal ikon ve WhatsApp CTA bloklarini bir araya getir.'],
        ['title' => 'Canli preview + yayin akisi', 'copy' => 'Degisiklikleri aninda gor, tamamlayinca tek tikla sayfana uygula.'],
        ['title' => 'Tam tema kontrolu', 'copy' => 'Renk, blur, font ve buton diliyle markana uygun bir vitrin kur.'],
    ];
@endphp

<section id="problem" data-scene="problem" class="relative py-24 sm:py-28">
    <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:px-8 xl:grid-cols-[1fr_1fr] xl:gap-10 xl:pr-[24rem]">
        <div class="glass-panel rounded-[2rem] p-6 sm:p-8 reveal" data-reveal>
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-500/12 text-rose-300">
                    <i class="fa-solid fa-link-slash"></i>
                </span>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-rose-300">Problem</p>
                    <h2 class="landing-heading mt-1 text-2xl font-semibold text-white sm:text-3xl">Tek link artik yeterli degil.</h2>
                </div>
            </div>

            <div class="mt-8 space-y-4">
                @foreach ($problems as $problem)
                    <article class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                        <h3 class="text-lg font-semibold text-white">{{ $problem['title'] }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-300">{{ $problem['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="glass-panel rounded-[2rem] p-6 sm:p-8 reveal" data-reveal>
            <div class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-[#00ffcc]/12 text-[#00ffcc]">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                </span>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-cyan-300">Solution</p>
                    <h2 class="landing-heading mt-1 text-2xl font-semibold text-white sm:text-3xl">byoo.pro ile mini bir vitrin kur.</h2>
                </div>
            </div>

            <div class="mt-8 space-y-4">
                @foreach ($solutions as $solution)
                    <article class="rounded-3xl border border-white/10 bg-white/[0.03] p-5">
                        <h3 class="text-lg font-semibold text-white">{{ $solution['title'] }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-300">{{ $solution['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
