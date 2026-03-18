@php
    $products = [
        ['name' => 'Premium Theme Pack', 'price' => '799 TL', 'copy' => 'Hazir premium tema setleri, dogrudan mini vitrine eklenebilen urun bloklariyla birlikte gelir.', 'badge' => 'En populer'],
        ['name' => 'Creator Launch Kit', 'price' => '1.290 TL', 'copy' => 'Lansman donemi icin urun karti, WhatsApp CTA ve sosyal proof bloklari tek pakette.', 'badge' => 'Yeni'],
        ['name' => 'Agency Starter', 'price' => '2.490 TL', 'copy' => 'Ajanslar icin coklu profil tasarimi, blok duzeni ve teslim akisini hizlandirir.', 'badge' => 'Ajans'],
    ];
@endphp

<section id="products" data-scene="products" class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 xl:pr-[24rem]">
        <div class="grid gap-8 lg:grid-cols-[0.86fr_1.14fr]">
            <div class="reveal" data-reveal>
                <div class="section-chip">
                    <i class="fa-solid fa-bag-shopping text-amber-300"></i>
                    Product showcase
                </div>
                <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                    Urun satmak icin ekstra sayfa kurmana gerek kalmasin.
                </h2>
                <p class="mt-5 text-lg leading-8 text-slate-300">
                    byoo.pro urun kartlarini ayni profilde sergiler. Gorsel, fiyat, aciklama ve WhatsApp siparis aksiyonu tek kartta toplanir; takipci hemen harekete gecebilir.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                        <p class="text-2xl font-semibold text-white">Tek tik</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">WhatsApp ile siparis baslatma deneyimi tiklanabilir ve mobil odaklidir.</p>
                    </div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/[0.03] p-5">
                        <p class="text-2xl font-semibold text-white">Kart mantigi</p>
                        <p class="mt-2 text-sm leading-6 text-slate-300">Urun bloklari klasik linklerden ayrisir ve daha guclu bir vitrin etkisi olusturur.</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3 reveal" data-reveal>
                @foreach ($products as $product)
                    <article class="group overflow-hidden rounded-[2rem] border border-white/10 bg-[linear-gradient(180deg,rgba(255,255,255,0.08),rgba(255,255,255,0.03))] transition duration-300 hover:-translate-y-1 hover:border-white/20">
                        <div class="h-36 bg-[linear-gradient(135deg,rgba(0,255,204,0.22),rgba(124,58,237,0.26)),radial-gradient(circle_at_top_right,rgba(255,255,255,0.28),transparent_34%)]"></div>
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-3">
                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-cyan-300">{{ $product['badge'] }}</span>
                                <p class="text-base font-semibold text-white">{{ $product['price'] }}</p>
                            </div>
                            <h3 class="mt-4 text-xl font-semibold text-white">{{ $product['name'] }}</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-300">{{ $product['copy'] }}</p>
                            <button class="mt-6 inline-flex w-full items-center justify-center gap-3 rounded-2xl bg-[#00ffcc] px-4 py-3 text-sm font-bold text-slate-950 transition group-hover:bg-[#7effe1]">
                                <i class="fa-brands fa-whatsapp"></i>
                                WhatsApp ile siparis ver
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
