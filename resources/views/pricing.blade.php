<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.22em] text-amber-500">byoo.pro</p>
                <h2 class="mt-2 font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
                    Paketler
                </h2>
            </div>
            <span class="rounded-full border border-amber-200 bg-amber-50 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-amber-700 dark:border-amber-500/20 dark:bg-amber-500/10 dark:text-amber-300">
                Free / Pro
            </span>
        </div>
    </x-slot>

    @php
        $featureMap = [
            'free' => [
                ['label' => 'Maksimum 5 link', 'enabled' => true],
                ['label' => 'Ürün ekleme kapalı', 'enabled' => false],
                ['label' => 'Tema özelleştirme kapalı', 'enabled' => false],
                ['label' => 'Verified kapalı', 'enabled' => false],
            ],
            'pro' => [
                ['label' => 'Sınırsız link', 'enabled' => true],
                ['label' => 'Ürün ekleme', 'enabled' => true],
                ['label' => 'Custom tema & CSS', 'enabled' => true],
                ['label' => 'Verified badge', 'enabled' => true],
                ['label' => 'Analytics', 'enabled' => true],
            ],
        ];
    @endphp

    <div class="py-12">
        <div class="mx-auto max-w-6xl sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-[2rem] border border-black/5 bg-[radial-gradient(circle_at_top,rgba(245,158,11,0.08),transparent_26%),linear-gradient(180deg,#ffffff_0%,#f8fafc_100%)] p-6 shadow-[0_30px_80px_rgba(15,23,42,0.08)] dark:border-white/10 dark:bg-[radial-gradient(circle_at_top,rgba(245,158,11,0.12),transparent_28%),linear-gradient(180deg,#121212_0%,#090909_100%)] dark:shadow-[0_30px_80px_rgba(0,0,0,0.45)] sm:p-8">
                <div class="mx-auto max-w-3xl text-center">
                    <h3 class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        İhtiyacına göre başla, premium seviyeye çıktıkça daha fazlasını aç.
                    </h3>
                    <p class="mt-4 text-base leading-7 text-gray-600 dark:text-gray-300">
                        Free ile hızlı bir başlangıç yap. Pro ile ürün ekleme, custom tema & CSS, verified badge ve analytics özelliklerini aktif et.
                    </p>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-2">
                    @foreach ($plans as $plan)
                        @php
                            $isCurrentPlan = auth()->check()
                                && auth()->user()->plan === $plan->slug;
                            $isPro = $plan->slug === 'pro';
                            $features = $featureMap[$plan->slug] ?? [];
                        @endphp

                        <article class="relative rounded-[1.75rem] border p-6 sm:p-7 {{ $isPro ? 'border-amber-300/60 bg-amber-50/70 dark:border-amber-400/25 dark:bg-amber-400/10' : 'border-black/10 bg-white/70 dark:border-white/10 dark:bg-white/[0.03]' }}">
                            @if ($isCurrentPlan)
                                <span class="absolute right-5 top-5 rounded-full bg-emerald-500/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-emerald-600 dark:text-emerald-300">
                                    Aktif plan
                                </span>
                            @endif

                            <div class="pr-24">
                                <p class="text-sm uppercase tracking-[0.22em] {{ $isPro ? 'text-amber-700 dark:text-amber-300' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $isPro ? 'Premium paket' : 'Başlangıç paketi' }}
                                </p>
                                <h4 class="mt-3 text-3xl font-semibold text-gray-900 dark:text-white">
                                    {{ $plan->name }}
                                </h4>
                                <div class="mt-4 flex items-end gap-2">
                                    @if ((float) $plan->price <= 0)
                                        <span class="text-4xl font-semibold text-gray-900 dark:text-white">Ücretsiz</span>
                                    @else
                                        <span class="text-4xl font-semibold text-gray-900 dark:text-white">${{ number_format($plan->price, 2, ',', '.') }}</span>
                                        <span class="pb-1 text-sm text-gray-500 dark:text-gray-400">/ ay</span>
                                    @endif
                                </div>
                                <p class="mt-4 text-sm leading-7 text-gray-600 dark:text-gray-300">
                                    {{ $isPro
                                        ? 'Daha güçlü görünmek, daha fazla satış yapmak ve performansını ölçmek isteyenler için.'
                                        : 'Şık bir başlangıç için temel yapı. Hızlı kurulum, sade vitrin ve net sınırlar.' }}
                                </p>
                            </div>

                            <div class="mt-6 h-px w-full bg-gradient-to-r from-transparent via-black/10 to-transparent dark:via-white/10"></div>

                            <ul class="mt-6 space-y-4">
                                @foreach ($features as $feature)
                                    <li class="flex items-center gap-3 text-sm {{ $feature['enabled'] ? 'text-gray-800 dark:text-gray-100' : 'text-gray-500 dark:text-gray-500' }}">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full {{ $feature['enabled'] ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300' : 'bg-black/5 text-gray-500 dark:bg-white/5 dark:text-gray-500' }}">
                                            <i class="fa-solid {{ $feature['enabled'] ? 'fa-check' : 'fa-xmark' }}"></i>
                                        </span>
                                        <span class="font-medium">{{ $feature['label'] }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-8">
                                @if ($isCurrentPlan)
                                    <span class="block w-full rounded-full bg-gray-200 px-5 py-4 text-center text-sm font-semibold text-gray-600 dark:bg-white/10 dark:text-gray-300">
                                        Aktif Plan
                                    </span>
                                @else
                                    @if ($isPro)
                                        @if(auth()->check())
                                            <a href="{{ auth()->user()->getUpgradeUrl() }}" target="_blank" class="block w-full rounded-full bg-amber-500 px-5 py-4 text-center text-sm font-semibold text-black transition-transform shadow hover:-translate-y-1 hover:shadow-lg">
                                                <i class="fab fa-whatsapp mr-1 text-lg"></i> Pro’ya Geç
                                            </a>
                                        @else
                                            <a href="{{ route('register') }}" class="block w-full rounded-full bg-amber-500 px-5 py-4 text-center text-sm font-semibold text-black transition-transform shadow hover:-translate-y-1 hover:shadow-lg">
                                                <i class="fas fa-rocket mr-1"></i> Hemen Başla
                                            </a>
                                        @endif
                                    @else
                                        <span class="block w-full rounded-full bg-black text-white dark:bg-white dark:text-black px-5 py-4 text-center text-sm font-semibold">
                                            Free ile Devam Et
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
