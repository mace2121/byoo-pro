<section class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="premium-panel relative overflow-hidden rounded-[2.25rem] p-8 sm:p-10 lg:p-12">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(216,178,122,0.18),transparent_30%),radial-gradient(circle_at_bottom_left,rgba(139,211,199,0.14),transparent_28%)]"></div>
            <div class="relative grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                <div class="max-w-3xl">
                    <div class="premium-tag">
                        <i class="fa-solid fa-crown"></i>
                        Premium başlangıç
                    </div>
                    <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                        byoo.pro ile profilini daha şık, daha güçlü ve daha güvenilir göster.
                    </h2>
                    <p class="mt-5 text-lg leading-8 text-zinc-300">
                        Free pakette hızlıca başla. Pro pakete geçtiğinde ürün ekleme, custom tema & CSS, verified badge ve analytics ile farkını net şekilde ortaya koy.
                    </p>
                </div>

                <div class="grid gap-3 sm:min-w-[18rem]">
                    <a
                        href="{{ Route::has('register') ? route('register') : route('login') }}"
                        class="premium-button inline-flex items-center justify-center gap-3 rounded-full px-6 py-4 text-base font-bold transition"
                    >
                        <i class="fa-solid fa-star"></i>
                        Şimdi Başla
                    </a>
                    <a
                        href="#plans"
                        class="premium-button-ghost inline-flex items-center justify-center gap-3 rounded-full px-6 py-4 text-base font-semibold transition"
                    >
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        Paketleri Gör
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
