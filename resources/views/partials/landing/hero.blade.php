<section id="hero" class="relative overflow-hidden pt-28 sm:pt-32">
    <div class="mx-auto grid max-w-7xl gap-12 px-4 pb-20 pt-12 sm:px-6 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] lg:px-8 lg:pb-28">
        <div class="max-w-3xl">
            <div class="premium-tag reveal-up">
                <span class="inline-flex h-2.5 w-2.5 rounded-full bg-[color:var(--landing-accent)]"></span>
                Premium bio sayfası deneyimi
            </div>

            <div class="mt-8 reveal-up-delay">
                <h1 class="landing-heading text-5xl font-semibold leading-[1.02] text-white sm:text-6xl xl:text-7xl">
                    Linklerini sıradan bir liste değil,
                    <span class="bg-[linear-gradient(135deg,#f0d4a8_0%,#d8b27a_55%,#fff3df_100%)] bg-clip-text text-transparent">
                        premium bir vitrin
                    </span>
                    haline getir.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-zinc-300 sm:text-xl">
                    byoo.pro ile profilini markana yakışan tek bir sayfada sun. Linklerini öne çıkar, Pro pakette ürün ekle, özel tema kullan, verified badge kazan ve analytics ile performansını takip et.
                </p>
            </div>

            <div class="mt-10 flex flex-col gap-4 sm:flex-row reveal-up-delay-2">
                <a
                    href="{{ Route::has('register') ? route('register') : route('login') }}"
                    class="premium-button inline-flex items-center justify-center gap-3 rounded-full px-7 py-4 text-base font-bold transition"
                >
                    <i class="fa-solid fa-crown"></i>
                    Ücretsiz Başla
                </a>
                <a
                    href="#plans"
                    class="premium-button-ghost inline-flex items-center justify-center gap-3 rounded-full px-7 py-4 text-base font-semibold transition"
                >
                    <i class="fa-solid fa-layer-group"></i>
                    Paketleri İncele
                </a>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-3">
                <div class="premium-stat p-5">
                    <p class="text-sm font-medium text-zinc-400">Kurulum</p>
                    <p class="mt-3 text-3xl font-semibold text-white">2 dk</p>
                    <p class="mt-2 text-sm leading-6 text-zinc-400">Hızlı profil kurulumu, temiz yayın akışı.</p>
                </div>
                <div class="premium-stat p-5">
                    <p class="text-sm font-medium text-zinc-400">Deneyim</p>
                    <p class="mt-3 text-3xl font-semibold text-white">Premium</p>
                    <p class="mt-2 text-sm leading-6 text-zinc-400">Şık tema, güçlü hiyerarşi ve markalı görünüm.</p>
                </div>
                <div class="premium-stat p-5">
                    <p class="text-sm font-medium text-zinc-400">Pro</p>
                    <p class="mt-3 text-3xl font-semibold text-white">Analytics</p>
                    <p class="mt-2 text-sm leading-6 text-zinc-400">Tıklama performansını ve büyümeyi izle.</p>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-x-8 top-10 h-40 rounded-full bg-[rgba(216,178,122,0.18)] blur-3xl"></div>
            <div class="phone-frame mx-auto max-w-[24rem] reveal-up-delay">
                <div class="phone-screen">
                    <div class="premium-panel-soft rounded-[1.75rem] p-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5">
                                <x-application-logo class="h-7 w-7 text-white" />
                            </div>
                            <div>
                                <p class="text-base font-semibold text-white">BYOO Studio</p>
                                <p class="text-xs uppercase tracking-[0.22em] text-[color:var(--landing-accent)]">Verified creator</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-zinc-300">
                            Markanı tek bir sayfada premium şekilde sun. Link, ürün ve içerik akışlarını aynı vitrine taşı.
                        </p>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div class="premium-panel-soft rounded-[1.5rem] p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-[rgba(216,178,122,0.14)] text-[color:var(--landing-accent)]">
                                        <i class="fa-solid fa-link"></i>
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Öne Çıkan Link</p>
                                        <p class="text-xs text-zinc-400">Kampanya ve profil yönlendirmeleri</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-white/5 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.22em] text-zinc-300">Free</span>
                            </div>
                        </div>

                        <div class="premium-panel-soft rounded-[1.5rem] p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-[rgba(139,211,199,0.14)] text-[color:var(--landing-success)]">
                                        <i class="fa-solid fa-bag-shopping"></i>
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Ürün Kartı</p>
                                        <p class="text-xs text-zinc-400">Fiyat, açıklama ve satış odaklı blok</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-[rgba(216,178,122,0.12)] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.22em] text-[color:var(--landing-accent)]">Pro</span>
                            </div>
                        </div>

                        <div class="premium-panel-soft rounded-[1.5rem] p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-[rgba(216,178,122,0.14)] text-[color:var(--landing-accent)]">
                                        <i class="fa-solid fa-chart-simple"></i>
                                    </span>
                                    <div>
                                        <p class="text-sm font-semibold text-white">Analytics</p>
                                        <p class="text-xs text-zinc-400">Tıklamaları ve performansı ölç</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-[rgba(216,178,122,0.12)] px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.22em] text-[color:var(--landing-accent)]">Pro</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 premium-panel rounded-[1.75rem] p-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-white">Tema Görünümü</p>
                                <p class="mt-1 text-xs text-zinc-400">Özel tema, CSS ve premium tipografi</p>
                            </div>
                            <div class="flex gap-2">
                                <span class="h-5 w-5 rounded-full border border-white/10 bg-[#f0d4a8]"></span>
                                <span class="h-5 w-5 rounded-full border border-white/10 bg-[#8bd3c7]"></span>
                                <span class="h-5 w-5 rounded-full border border-white/10 bg-white/80"></span>
                            </div>
                        </div>
                        <div class="accent-line mt-4 h-px w-full"></div>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-left">
                                <p class="text-xs uppercase tracking-[0.22em] text-zinc-500">Profil Durumu</p>
                                <p class="mt-2 text-sm font-semibold text-white">Yayına Hazır</p>
                            </div>
                            <button class="premium-button rounded-full px-4 py-2 text-sm font-bold">
                                Yayınla
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
