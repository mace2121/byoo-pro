@php
    $plans = [
        [
            'name' => 'Free',
            'eyebrow' => 'Başlangıç paketi',
            'description' => 'Şık bir başlangıç için temel yapı. Hızlı kurulum, sade vitrin ve net sınırlar.',
            'highlight' => false,
            'features' => [
                ['label' => 'Maksimum 5 link', 'enabled' => true],
                ['label' => 'Ürün ekleme kapalı', 'enabled' => false],
                ['label' => 'Tema özelleştirme kapalı', 'enabled' => false],
                ['label' => 'Verified kapalı', 'enabled' => false],
            ],
        ],
        [
            'name' => 'Pro',
            'eyebrow' => 'Premium paket',
            'description' => 'Daha güçlü görünmek, daha fazla satış yapmak ve performansı ölçmek isteyenler için.',
            'highlight' => true,
            'features' => [
                ['label' => 'Sınırsız link', 'enabled' => true],
                ['label' => 'Ürün ekleme', 'enabled' => true],
                ['label' => 'Custom tema & CSS', 'enabled' => true],
                ['label' => 'Verified badge', 'enabled' => true],
                ['label' => 'Analytics', 'enabled' => true],
            ],
        ],
    ];
@endphp

<section id="plans" class="relative py-24 sm:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <div class="premium-tag justify-center">
                <i class="fa-solid fa-crown"></i>
                Paketler
            </div>
            <h2 class="landing-heading mt-6 text-3xl font-semibold text-white sm:text-5xl">
                İhtiyacına göre başla, premium seviyeye çıktıkça daha fazlasını aç.
            </h2>
            <p class="mt-5 text-lg leading-8 text-zinc-300">
                Free ile sade ve hızlı bir profil oluştur. Pro ile premium görünümünü tamamla, satış ve büyüme özelliklerini aktif et.
            </p>
        </div>

        <div class="mt-14 grid gap-6 lg:grid-cols-2">
            @foreach ($plans as $plan)
                <article class="{{ $plan['highlight'] ? 'premium-panel border-[rgba(216,178,122,0.32)]' : 'premium-panel-soft' }} rounded-[2rem] p-7 sm:p-8">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm uppercase tracking-[0.22em] {{ $plan['highlight'] ? 'text-[color:var(--landing-accent)]' : 'text-zinc-500' }}">{{ $plan['eyebrow'] }}</p>
                            <h3 class="mt-3 text-3xl font-semibold text-white">{{ $plan['name'] }}</h3>
                        </div>
                        @if ($plan['highlight'])
                            <span class="rounded-full bg-[rgba(216,178,122,0.14)] px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-[color:var(--landing-accent)]">
                                En güçlü seçenek
                            </span>
                        @endif
                    </div>

                    <p class="mt-4 max-w-xl text-sm leading-7 text-zinc-400">
                        {{ $plan['description'] }}
                    </p>

                    <div class="premium-list-line mt-6"></div>

                    <ul class="mt-6 space-y-4">
                        @foreach ($plan['features'] as $feature)
                            <li class="flex items-center gap-3 text-sm {{ $feature['enabled'] ? 'text-zinc-100' : 'text-zinc-500' }}">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full {{ $feature['enabled'] ? 'bg-[rgba(139,211,199,0.12)] text-[color:var(--landing-success)]' : 'bg-white/5 text-zinc-500' }}">
                                    <i class="fa-solid {{ $feature['enabled'] ? 'fa-check' : 'fa-xmark' }}"></i>
                                </span>
                                <span class="font-medium">{{ $feature['label'] }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-8">
                        @if ($plan['highlight'])
                            <a href="{{ Route::has('register') ? route('register') : route('login') }}" class="premium-button inline-flex w-full items-center justify-center gap-3 rounded-full px-5 py-4 text-sm font-bold transition">
                                <i class="fa-solid fa-gem"></i>
                                Pro ile Başla
                            </a>
                        @else
                            <a href="{{ Route::has('register') ? route('register') : route('login') }}" class="premium-button-ghost inline-flex w-full items-center justify-center gap-3 rounded-full px-5 py-4 text-sm font-semibold transition">
                                <i class="fa-solid fa-arrow-right"></i>
                                Free ile Başla
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
